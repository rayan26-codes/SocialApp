document.addEventListener('DOMContentLoaded', () => {
    // Mobile Navigation Drawer integration (Preserved across app JS files)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const appSidebar = document.getElementById('appSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && appSidebar && sidebarOverlay) {
        const toggleMenu = () => {
            appSidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
            sidebarToggle.classList.toggle('active');
        };

        sidebarToggle.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', toggleMenu);
    }

    // ==========================================================================
    // Local Image Selection & Preview (Frontend UI Only)
    // ==========================================================================
    const imageInput = document.getElementById('imageUploadInput');
    const dropzoneLabel = document.getElementById('dropzoneLabel');
    const imagePreviewCard = document.getElementById('imagePreviewCard');
    const imagePreviewImg = document.getElementById('imagePreviewImg');
    const removeImageBtn = document.getElementById('removeImageBtn');

    if (imageInput && dropzoneLabel && imagePreviewCard && imagePreviewImg && removeImageBtn) {
        
        // Listen for file selection
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreviewImg.src = e.target.result;
                    dropzoneLabel.style.display = 'none';
                    imagePreviewCard.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Clear image selection
        removeImageBtn.addEventListener('click', function () {
            imageInput.value = '';
            imagePreviewImg.src = '';
            imagePreviewCard.classList.add('hidden');
            dropzoneLabel.style.display = 'flex';
        });
    }
});