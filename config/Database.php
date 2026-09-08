<?php
class Database{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "oop_application";
    private $table;
    public $conditions = [];
    private $orderBy = [];
    private $likeAligment = ""; //forward | backward | both
    private $previousState = ""; 
    public $conn;

    function __construct(){
        $this->conn = new mysqli($this->host,$this->user,$this->pass,$this->db);
        if ($this->conn->connect_error) {
            die("Database connection failed: ". $this->conn->connect_error);
        }
    }

     function GetType($value){
      if(is_int($value)){
        return "i";
      }
      if(is_float($value)){
        return "d";
      }
        return "s";
    }

    function table($table = ""){
        if (empty(trim($table))) {
            echo "Table Parameter Can not Be Empty .";
            die();
        }
        $this->table = $table;
        return $this;
    }

    function where($conditions = ""){
        if (empty($conditions)) {
            echo "No parameter Passed  In where clause";
            die();
        }

        $this->conditions[] = ["conditions" => $conditions, "optr" => "AND"];
        return $this;
    }

    function Andwhere($conditions = ""){
        if(empty($this->conditions)){
          echo "AndWhere Function can not be Used without a Where Function";
          die();
        }

        if(empty($conditions)){
          echo "No parameter Passed  In where clause";
          die();
        }

        $this->conditions[] = ["conditions" => $conditions, "optr" => "AND"];
        return $this;
    }

    function Orwhere($conditions = ""){
        if(empty($this->conditions)){
          echo "OrWhere Function can not be Used without a Where Function";
          die();
        }

        if(empty($conditions)){
          echo "No parameter Passed  In where clause";
          die();
        }

        $this->conditions[] = ["conditions" => $conditions, "optr" => "OR"];
        return $this;
    }

    function orderBy($column = "" , $direction = ""){
        if(empty($column) || empty($direction)){
          echo "Parameter Passed  In orderBy Function";
          die();
        }

        $allowedDirection = ['ASC', 'DESC'];
        if (!in_array($direction, $allowedDirection)) {
            echo "Direction Can only be ASC Or DESC.";
            die();
        }

        $this->orderBy[] = ["column" => $column, "direction" => $direction]; 
        return $this;
    }

    function Like($aligment = " "){
        $this->likeAligment = $aligment;
        return $this;
    }


    function Insert($data, $ReturnId = false){
        $columns = "";
        $valuePlaceholder = "";
        $values = [];
        $types = "";

        if(empty($this->table)){
            echo "Table Not Specified.";
            die();
        }

        if(empty($data)) {
            echo "No Data Was Given Query can not run.";
            die();
        }

        foreach ($data as $key => $value) {
            if($columns != ""){
              $columns .= ",";
              $valuePlaceholder .= ",";
            }
            $columns .= $key;
            $valuePlaceholder .= "?";
            $values[] = $value;
            $types .= $this->GetType($value);
        }

        $sql = "INSERT INTO  $this->table ($columns) VALUES ($valuePlaceholder)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
          die("Prepare failed: " . $this->conn->error);
        }
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
        
        $result = $stmt->execute();
        if($result){
           if($ReturnId){
            $insertId = $this->conn->insert_id;
            $stmt->close();
            return $insertId;
            }
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    function Select($selectedColumns = "*"){
        $where    = "";
        $values   = [];
        $val      = "";
        $types    = "";
        
        if (empty($this->table)) {
            echo "Table Not Specified.";
            die();
        }

        foreach ($this->conditions as $key => $value){

            $condition = $value['conditions'];

            if($where != ""){
              $where .= " " .$value['optr']. " "; 
            }

            if($this->likeAligment != ''){
                if(isset($condition['op'])){
                    $where .= $condition['column'] ." ". $condition['op']. " ?";
                    $val = $condition['value'];
                }else{
                    $where .= $condition['column'] ." LIKE ?";
                    if($this->likeAligment == "forward"){
                        $val =  $condition['value'] . "%";
                    }else if($this->likeAligment == "backward"){
                        $val =  "%" . $condition['value'];
                    }else{
                        $val =  "%" . $condition['value'] . "%";
                    }
                 }
                
                $values[] = $val; // %a%
                $types .= $this->GetType($val);

            }else{
                if(!isset($condition['column']) || !isset($condition['op']) || !isset($condition['value'])) {
                    echo "key not set";
                    die();
                }
                $where.= $condition['column'] ." ". $condition['op'] ." ?";
                $values[] = $condition['value'];
                $types .= $this->GetType($condition['value']);
                
            }    
        }

        $sql = "SELECT $selectedColumns FROM ". $this->table;
    
        if ($where != "") {
          $sql .= " WHERE ". $where;
        }

        if($this->orderBy){
            $sql .= " ORDER BY ";
            foreach ($this->orderBy as $key => $value) {
                $column = $value['column'];
                $direction = $value['direction'];

                 if ($key != 0) {
                    $sql .= ", ";
                 }

                $sql .= $column. " ". $direction;
            }
        } 

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
          die("Prepare failed: " . $this->conn->error);
        }
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $Data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $this->conditions = [];
        return $Data;
    }

    function Update($data){
        $where = "";
        $set = "";
        $values = [];
        $types = "";

         if(empty($this->table)){
            echo "Table Not Specified.";
            die();
         }

        if(empty($data)) {
            echo "No Data Was Given Query can not run.";
            die();
        }

        foreach($data as $key => $value){
            if($set != ""){
              $set .= ", "; 
            }

            $set .= $key ." = ?";
            $values[] = $value;
            $types .= $this->GetType($value);
        }  
            foreach($this->conditions as $key => $value) {

                $condition = $value['conditions'];

                if ($where != "") {
                    $where .= " " .$value['optr']. " ";  
                }

                if($this->likeAligment != ''){
                    if(isset($condition['op'])){
                        $where .= $condition['column'] ." ". $condition['op']. " ?";
                        $val = $condition['value'];
                    }else{
                        $where .= $condition['column'] ." LIKE ?";
                        if($this->likeAligment == "forward"){
                            $val =  $condition['value'] . "%";
                        }else if($this->likeAligment == "backward"){
                            $val =  "%" . $condition['value'];
                        }else{
                            $val =  "%" . $condition['value'] . "%";
                        }
                    }
                    
                    $values[] = $val; // %a%
                    $types .= $this->GetType($val);

                }else{
                    if(!isset($condition['column']) || !isset($condition['op']) || !isset($condition['value'])) {
                        echo "key not set";
                        die();
                    }
                    $where.= $condition['column'] ." ". $condition['op'] ." ?";
                    $values[] = $condition['value'];
                    $types .= $this->GetType($condition['value']);
                }    
            }

             $sql = "UPDATE $this->table SET ". $set;
                
                if ($where != "") {
                $sql .= " WHERE ". $where;
                }

                $stmt = $this->conn->prepare($sql);
                if (!$stmt) {
                die("Prepare failed: " . $this->conn->error);
                }
                if (!empty($values)) {
                    $stmt->bind_param($types, ...$values);
                }
                $Result = $stmt->execute();
                $stmt->close();
                return $Result;
        }

        function Delete(){
            $where = "";
            $values = [];
            $types = "";

             if(empty($this->table)){
                echo "Table Not Specified.";
                die();
             }

            foreach($this->conditions as $key => $value) {

                $condition = $value['conditions'];

                if ($where != "") {
                    $where .= " " .$value['optr']. " "; 
                }

                if($this->likeAligment != ''){
                    if(isset($condition['op'])){
                        $where .= $condition['column'] ." ". $condition['op']. " ?";
                        $val = $condition['value'];
                    }else{
                        $where .= $condition['column'] ." LIKE ?";
                        if($this->likeAligment == "forward"){
                            $val =  $condition['value'] . "%";
                        }else if($this->likeAligment == "backward"){
                            $val =  "%" . $condition['value'];
                        }else{
                            $val =  "%" . $condition['value'] . "%";
                        }
                    }
                    
                    $values[] = $val; // %a%
                    $types .= $this->GetType($val);

                }else{
                    if(!isset($condition['column']) || !isset($condition['op']) || !isset($condition['value'])) {
                        echo "key not set";
                        die();
                    }
                    $where.= $condition['column'] ." ". $condition['op'] ." ?";
                    $values[] = $condition['value'];
                    $types .= $this->GetType($condition['value']);
                }    
            }

            $sql = "DELETE FROM $this->table";

            if ($where != "") {
                $sql .= " WHERE " . $where;
            }

            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                die("Prepare failed: " . $this->conn->error);
            }

            if (!empty($values)) {
                $stmt->bind_param($types, ...$values);
            }

            $Result = $stmt->execute();
            $stmt->close();
            return $Result;
        }

    function Query($sql, $types = "", $values = []){
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
          die("Prepare failed: " . $this->conn->error);
        }
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $Data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $Data;
    }

    function Execute($sql, $types = "", $values = []){
         $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
          die("Prepare failed: " . $this->conn->error);
        }
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>