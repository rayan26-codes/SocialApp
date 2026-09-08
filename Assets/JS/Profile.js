document.addEventListener('DOMContentLoaded', () => {
    // 1. Elements
    const editBtn = document.getElementById('edit-profile-btn');
    const cancelBtn = document.getElementById('cancel-edit-btn');
    const updatePanel = document.getElementById('update-panel');
    
    const fileInput = document.getElementById('profile_pic');
    const previewImg = document.getElementById('upload-preview');
    const originalAvatarSvg = previewImg.src; // Keep reference to original SVG

    // 2. Toggle Panel Functionality
    const openUpdatePanel = () => {
        updatePanel.classList.remove('collapsed');
        // Smooth scroll to form section once revealed
        setTimeout(() => {
            updatePanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 150);
    };

    const closeUpdatePanel = () => {
        updatePanel.classList.add('collapsed');
    };

    editBtn.addEventListener('click', openUpdatePanel);
    cancelBtn.addEventListener('click', closeUpdatePanel);

    // 3. Live Profile Picture Preview
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Apply source image asynchronously to target image elements
                previewImg.src = e.target.result;
            };
            
            reader.readAsDataURL(file);
        } else {
            // Revert back to the placeholder vector structure if input cleared
            previewImg.src = originalAvatarSvg;
        }
    });
});