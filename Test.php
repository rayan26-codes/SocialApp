<?php
require_once "config/Database.php";

class Test extends Database{
   function test(){
      //   $conditions  = ["column" => "age", "value" => 20, "op" => ">="];
      //   $conditions2 = ["column" => "age", "value" => "40" ,"op" => "<="];
      //   $conditions3 = ["column" => "firstname", "value" => "a"];

      //   $Data = $this->table("user_info")->where($conditions)->OrWhere($conditions3)->Like("forward")->OrWhere($conditions2)->Select();

     $Data = $this->table("user_info")
     ->where([
         "column" => "id",
         "op" => ">",
         "value" => 5
     ])
     ->Select();

     return $Data;
   }
}


$obj = new Test();
print_r($obj->test());





?>

// $obj = new Database();
// ["age" => 23, "id" => 4, "firstname" => "eehal"];
// $Data = $obj->table("user_info")
// ->where(["column" => "age", "value" => "23" ,"op" => ">="])
// ->where(["column" => "id", "value" => "2000" ,"op" => "<="])
// ->GreaterThanEqualTo()->Select();
// echo "<pre>";
// print_r ($obj->conditions);
// echo "/<pre>";// print_r($obj->test("20", "25"));
   



?>