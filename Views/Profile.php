<?php
include 'Includes/Header.php'; 
include 'Includes/Sidebar.php'; 
?>

<!-- Profile Page Container -->
<main class="profile-container">

    <!-- Profile Display Card -->
    <section class="profile-card">
        <div class="profile-header">
            <div class="avatar-wrapper">
                <!-- Clean, simple dynamic image path from your database -->
               <img id="display-avatar" src="Assets/Profiles/<?= !empty($ProfileData[0]['profile_pic']) ? $ProfileData[0]['profile_pic'] : 'default_pfp.jpg' ?>" alt="Profile Picture"
               class="profile-avatar">
            </div>
            <h1 class="user-fullname"><?= $ProfileData[0]['firstname'] ?></h1>
            <p class="user-email-sub"><?= $ProfileData[0]['email'] ?></p>
        </div>

        <hr class="divider">

        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-group">
                <span class="info-label">First Name</span>
                <span class="info-value"><?= $ProfileData[0]['firstname'] ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Last Name</span>
                <span class="info-value"><?= $ProfileData[0]['lastname'] ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Email Address</span>
                <span class="info-value"><?= $ProfileData[0]['email'] ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Age</span>
                <span class="info-value"><?= $ProfileData[0]['age'] ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Joined Date</span>
                <span class="info-value">January 15, 2025</span>
            </div>
            <div class="info-group">
                <span class="info-label">Account Status</span>
                <span class="info-value status-badge active">Active</span>
            </div>
        </div>

        <div class="card-actions">
            <button type="button" id="edit-profile-btn" class="btn btn-primary">Edit Profile</button>
        </div>
    </section>

    <!-- Update Profile Panel (Hidden by default) -->
    <section id="update-panel" class="update-panel collapsed">
        <div class="panel-header">
            <h2>Update Profile Details</h2>
            <p class="panel-subtitle">Leave any field blank if you don't want to change it.</p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="update-form">
            
            <!-- Picture Upload Section -->
            <div class="form-group full-width avatar-upload-group">
                <label class="form-label">Profile Picture</label>
                <div class="upload-preview-container">
                    <!-- Preview image also uses the dynamic picture value -->
                 <img id="upload-preview" src="Assets/Profiles/<?= !empty($ProfileData[0]['profile_pic']) ? $ProfileData[0]['profile_pic'] : 'default_pfp.jpg' ?>" alt="Preview"
                 class="preview-avatar">
                    <div class="file-input-wrapper">
                        <label for="profile_pic" class="btn btn-outline">Upload New Picture</label>
                        <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- First & Last Name -->
            <div class="form-group">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" id="first_name" name="firstname" placeholder="Enter new first name" class="form-input" value="<?= $ProfileData[0]['firstname'] ?>">
            </div>

            <div class="form-group">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" id="last_name" name="lastname" placeholder="Enter new last name" class="form-input" value="<?= $ProfileData[0]['lastname'] ?>">
            </div>

            <!-- Age -->
            <div class="form-group full-width">
                <label for="age" class="form-label">Age</label>
                <input type="number" id="age" name="age" placeholder="Enter new age" min="1" max="120" class="form-input" value="<?= $ProfileData[0]['age'] ?>">
            </div>

            <!-- Form Actions -->
            <div class="form-actions full-width">
                <button type="button" id="cancel-edit-btn" class="btn btn-secondary">Cancel</button>
                <button type="submit" name="save_changes" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </section>

</main>
<?php include 'Includes/Footer.php'; ?>