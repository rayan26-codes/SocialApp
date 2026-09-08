<?php
include 'Includes/Header.php'; 
include 'Includes/Sidebar.php'; 
?>

<!-- Views/Friends.php -->
<main class="friends-container">

    <!-- Toast Notification Container -->
    <?php if (isset($_SESSION['message']) && isset($_SESSION['status'])): ?>
        <div class="toast-notification <?= htmlspecialchars($_SESSION['status']) ?>" id="toastNotification" role="alert">
            <div class="toast-content">
                <span class="toast-message"><?= htmlspecialchars($_SESSION['message']) ?></span>
            </div>
            <button type="button" class="toast-close-btn" id="toastCloseBtn" onclick="closeToastNow()" aria-label="Close notification">&times;</button>
        </div>
        <?php 
            // Clear session message so it only displays once after redirect
            unset($_SESSION['message']);
            unset($_SESSION['status']);
        ?>
    <?php endif; ?>

    <!-- Page Header -->
    <header class="page-header">
        <h1>Friends</h1>
        <p class="page-description">Manage your friends, pending requests, and discover new people.</p>
    </header>

    <!-- Global Search Bar -->
    <div class="search-section">
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Search people..." aria-label="Search people">
        </div>
    </div>

    <!-- SECTION 1: Friend Requests -->
    <section class="friends-section">
        <div class="section-header">
            <h2>Friend Requests <span class="badge"><?= count($ReqData) ?></span></h2>
        </div>

        <!-- Populated Grid Example -->
        <div class="cards-grid">
            <!-- Reusable Request Card -->
            <?php foreach ($ReqData as $ReqKey => $ReqValue){ ?>   
            <article class="user-card request-card">
                <img src="Assets/Profiles/<?= !empty($ReqValue['profile_pic']) ? $ReqValue['profile_pic'] : 'default_pfp.jpg' ?>" alt="<?= $ReqValue['firstname'] ?>" class="user-avatar">
                <div class="user-info">
                    <h3 class="user-name"><?= $ReqValue['firstname'] ?></h3>
                    <p class="user-meta">Sent you a friend request</p>
                </div>
                <div class="card-actions dual-actions">
                    <form action="" method="POST">   
                        <input type="hidden" name="request_id" value="<?= $ReqValue['id'] ?>">
                        <button type="submit" name="accept_request" class="btn btn-primary btn-sm">Accept</button>
                    </form>   
                    <form action="" method="POST">
                        <input type="hidden" name="request_id" value="<?= $ReqValue['id'] ?>">
                        <button type="submit" name="reject_request" class="btn btn-secondary btn-sm">Reject</button>
                    </form>
                </div>
            </article>
            <?php } ?> 
        </div>

        <!-- OPTIONAL: Empty State Example (Rendered when no requests exist) -->
        <?php if (empty($ReqData)): ?>
        <div class="empty-state">
            <div class="empty-icon">📫</div>
            <h3>No pending requests</h3>
            <p>You don't have any incoming friend requests at the moment.</p>
        </div>
        <?php endif; ?>
       
    </section>

    <!-- SECTION 2: Find People -->
    <section class="friends-section">
        <div class="section-header">
            <h2>Find People</h2>
        </div>

        <div class="cards-grid">
            <!-- Reusable Find User Card -->
            <?php foreach ($UserData as $UserKey => $UserValue){ ?>
            <article class="user-card">
                <img src="Assets/Profiles/<?= !empty($UserValue['profile_pic']) ? $UserValue['profile_pic'] : 'default_pfp.jpg' ?>" alt="<?= $UserValue['firstname'] ?>" class="user-avatar">
                <div class="user-info">
                    <h3 class="user-name"><?= $UserValue['firstname'] ?></h3>
                    <span class="user-status-text">12 mutual friends</span>
                </div>
                <div class="card-actions">
                  <form action="" method="POST">  
                    <input type="hidden" name="receiver_id" value="<?php echo $UserValue['id']; ?>">
                    <button name="add_friend" type="submit" class="btn btn-primary btn-full">Add Friend</button>
                  </form> 
                </div>
            </article>
            <?php } ?> 
        </div>
    </section>

    <!-- SECTION 3: My Friends -->
    <section class="friends-section">
        <div class="section-header">
            <h2>My Friends <span class="badge badge-muted"><?php echo count($FriendsList); ?></span></h2>
        </div>
     <?php foreach($FriendsList as $FriendKey => $FriendValue){ ?>   
        <div class="cards-grid">
            <!-- Reusable Friend Card -->
            <article class="user-card">
                <img src="Assets/Profiles/<?= !empty($FriendValue['profile_pic']) ? $FriendValue['profile_pic'] : 'default_pfp.jpg' ?>" alt="<?= $FriendValue['firstname'] ?>" class="user-avatar">
                <div class="user-info">
                    <h3 class="user-name"><?= $FriendValue['firstname'] ?></h3>
                    <p class="user-meta"><?= $FriendValue['lastname'] ?></p>
                    <span class="user-status-tag">Friend</span>
                </div>
                <div class="card-actions dual-actions">
                    <button type="button" class="btn btn-muted btn-sm">Profile</button>
                  <form action="" method="POST">
                    <input type="hidden" name="friend_id" value="<?php echo $FriendValue['id']; ?>">
                    <button name="remove_friend" type="submit" class="btn btn-secondary btn-sm">Remove</button>
                  </form>  
                </div>
            </article>
      <?php } ?>
        </div>
    </section>

</main>
<?php include 'Includes/Footer.php'; ?>