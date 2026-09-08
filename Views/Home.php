<?php include 'Includes/Header.php'; ?>
<?php include 'Includes/Sidebar.php'; ?>

<!-- 1. Header Hero Section -->
<div class="home-header-section">
    <h1>Welcome back <?= htmlspecialchars($_SESSION['firstname']); ?></h1>
    <p>Check out the latest posts from your network.</p>
</div>

<!-- 2. Feed Container -->
<div class="feed-container">

    <!-- Feed Filter Tabs -->
    <div class="feed-filter-card">
        <form action="" method="POST">
        <nav class="feed-tabs" aria-label="Feed Navigation">
            <button type="submit" name="all_posts" class="feed-tab-btn <?= (isset($_POST['My_posts']) || isset($_POST['friends_posts'])) ? '' : 'active'; ?>">All Posts</button>
            <button type="submit" name="My_posts" class="feed-tab-btn <?= isset($_POST['My_posts']) ? 'active' : ''; ?>">My Posts</button>
            <button type="submit" name="friends_posts" class="feed-tab-btn <?= isset($_POST['friends_posts']) ? 'active' : ''; ?>">Friends' Posts</button>
        </nav>
        </form>
    </div>

    <!-- Feed Stream -->
    <div class="feed-stream">

        <?php if (!empty($PostData)) {?>
        <?php foreach ($PostData as $PostKey => $PostValue) { ?>
        <article class="post-card">
            <header class="post-header">
                <div class="post-avatar">
                    <img src="Assets/Profiles/<?= !empty($PostValue['profile_pic']) ? $PostValue['profile_pic'] : 'default_pfp.jpg' ?>" alt="Profile Picture" class="profile-avatar">
                </div>
                <div class="post-author-info">
                    <h4 class="post-author-name"><?php echo $PostValue['firstname']. " ". $PostValue['lastname']; ?></h4>
                    <span class="post-meta">@<?php echo $PostValue['firstname']; ?> • 2 hours ago</span>
                </div>
            </header>

            <div class="post-content">
                <p><?php echo $PostValue['post_text']; ?></p>
                <?php if (!empty($PostValue['images'])){ ?>
                <div class="post-image-container">
                  <?php foreach($PostValue['images'] as $Imagekey => $ImageValue){ ?>  
                    <img src="Assets/Posts/<?= ($ImageValue['post_image']); ?>" alt="Post attachment media">
                 <?php } ?>
                </div>
                <?php } ?>
            </div>

            <footer class="post-footer">
                <div class="post-stats">
                    <span class="stat-item">✅ <?php if(!empty($PostValue['LikeCount'])){echo " ". $PostValue['LikeCount'] ;} ?> Likes</span>
                    <span class="stat-item">❌ <?php if(!empty($PostValue['DislikeCount'])){echo " ". $PostValue['DislikeCount'] ;} ?> Dislikes</span>
                    <span class="stat-item">💬<?php if(!empty($PostValue['CommCount'])){echo " ". $PostValue['CommCount'] ;} ?> Comments</span>
                </div>
                <div class="post-actions">
                        <!-- 1. Like Form -->
                        <form action="" method="POST" class="post-action-form">
                            <input type="hidden" name="reaction_id" value="1">
                            <input type="hidden" name="post_id" value="<?= $PostValue['post_id']; ?>">
                            <button type="submit" name="like_post" class="post-action-btn">
                                <span class="action-icon">👍</span> Like
                            </button>
                        </form>

                        <!-- 2. Dislike Form -->
                        <form action="" method="POST" class="post-action-form">
                            <input type="hidden" name="reaction_id" value="2">
                            <input type="hidden" name="post_id" value="<?= $PostValue['post_id']; ?>">
                            <button type="submit" name="dislike_post" class="post-action-btn">
                                <span class="action-icon">👎</span> Dislike
                            </button>
                        </form>

                        <!-- 3. Comment Toggle Button (No reload) -->
                        <div class="post-action-form">
                            <button type="button" class="post-action-btn toggle-comment-btn" data-target="comments-<?= $PostValue['post_id']; ?>">
                                <span class="action-icon">💬</span> Comment
                          </button>
                        </div>
                </div>

                <!-- 4. Collapsible Comment Panel -->
                <div id="comments-<?= $PostValue['post_id']; ?>" class="comments-panel">
                    <div class="comments-panel-inner">
                        <!-- Submit Comment Form -->
                        <form action="" method="POST" class="comment-submit-form">
                            <input type="hidden" name="post_id" value="<?= $PostValue['post_id']; ?>">
                            <div class="comment-input-group">
                                <textarea name="comment_text" class="comment-textarea" rows="2" placeholder="Write a comment..." required></textarea>
                                <button type="submit" name="submit_comment" class="comment-submit-btn">Submit Comment</button>
                            </div>
                        </form>
                        <!-- Comments List (Easily replaced with PHP foreach later) -->
                         <?php foreach ($PostValue['comments'] as $Commkey => $CommValue) { ?>
                        <div class="comments-list">
                            <!-- Placeholder Comment 1 -->
                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <img src="Assets/Profiles/<?= !empty($CommValue['profile_pic']) ? $CommValue['profile_pic'] : 'default_pfp.jpg' ?>" alt="User avatar">
                                </div>
                                <div class="comment-body">
                                    <div class="comment-header-info">
                                        <span class="comment-author"><?php echo $CommValue['firstname']. " ". $CommValue['lastname']; ?></span>
                                        <span class="comment-time">1 hour ago</span>
                                    </div>
                                    <p class="comment-text"><?php echo $CommValue['comment']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </footer>
        </article>
        <?php  } ?>
        <?php }else{ ?>

        <div class="empty-feed-card">
            <div class="empty-feed-icon">📮</div>
            <h3>No posts yet</h3>
            <p>Posts from you and your friends will appear here once published.</p>
        </div>
       <?php } ?>

    </div>
</div>

<?php include 'Includes/Footer.php'; ?>