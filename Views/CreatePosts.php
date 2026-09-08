<?php include 'Includes/Header.php'; ?>
<?php include 'Includes/Sidebar.php'; ?>

<!-- Page Hero Header -->
<div class="create-post-header">
    <h1>Create Post</h1>
    <p>Share what's on your mind with your community.</p>
</div>

<!-- Main Form Container -->
<div class="create-post-container">
    <form action="" method="POST" enctype="multipart/form-data" class="card create-post-card">
        
        <!-- User Info Bar -->
        <div class="creator-profile-bar">
            <div class="creator-avatar">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['firstname'] ?? 'User'); ?>&background=eff6ff&color=1d4ed8" alt="Profile Picture">
            </div>
            <div class="creator-meta">
                <span class="creator-name"><?= htmlspecialchars($_SESSION['firstname'] ?? 'User'); ?></span>
            </div>
        </div>

        <!-- Post Text Area -->
        <div class="post-input-group">
            <textarea  
                id="postContent" 
                class="post-textarea" 
                name="post_text"
                placeholder="What's on your mind?" 
                rows="5" 
                required
            ></textarea>
        </div>

        <!-- Image Upload Dropzone -->
        <div class="image-upload-wrapper">
            <label for="imageUploadInput" class="upload-dropzone" id="dropzoneLabel">
                <span class="dropzone-icon">🖼️</span>
                <span class="dropzone-text">Click or drag an image here to attach</span>
                <span class="dropzone-hint">PNG, JPG, GIF up to 5MB</span>
            </label>
            <input 
                type="file" 
                name="post_images[]" 
                id="imageUploadInput" 
                accept="image/*" 
                class="hidden-file-input"
            >

            <!-- Local Image Preview Area -->
            <div class="image-preview-card hidden" id="imagePreviewCard">
                <img src="" alt="Selected Image Preview" id="imagePreviewImg">
                <button type="button" name="remove_image" id="removeImageBtn" class="remove-image-btn" title="Remove Image">✕</button>
            </div>
        </div>

        <!-- Form Action Footer -->
        <div class="create-post-actions">
            <a href="index.php?page=home" class="btn btn-outline btn-cancel">Cancel</a>
            <button type="submit" name="create_posts" class="btn btn-primary btn-submit">Create Post</button>   
        </div>

    </form>
</div>

<!-- Page Specific JS -->
<script src="Assets/JS/CreatePosts.js"></script>

<?php include 'Includes/Footer.php'; ?>