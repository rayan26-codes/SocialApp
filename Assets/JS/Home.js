document.addEventListener('DOMContentLoaded', () => {
    // ==========================================================================
    // 1. Mobile Sidebar Navigation Toggle Controls
    // ==========================================================================
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
    // 2. Feed Filter Navigation Tabs Switcher
    // ==========================================================================
    const feedTabs = document.querySelectorAll('.feed-tab-btn');
    feedTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            feedTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ==========================================================================
    // 3. Interactive Action Button Animation & Visual State
    // ==========================================================================
    const postActionButtons = document.querySelectorAll('.post-action-btn');
    postActionButtons.forEach(btn => {
        btn.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.96)';
        });
        btn.addEventListener('mouseup', function() {
            this.style.transform = 'scale(1)';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // ==========================================================================
    // 4. Comment Panel Toggle Handler
    // ==========================================================================
    const commentToggleBtns = document.querySelectorAll('.toggle-comment-btn');
    
    commentToggleBtns.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const targetPanel = document.getElementById(targetId);

            if (targetPanel) {
                const isOpen = targetPanel.classList.contains('open');
                
                // Toggle current target panel state
                targetPanel.classList.toggle('open');
                this.classList.toggle('active');

                // Optional: Auto-focus textarea when opened
                if (!isOpen) {
                    const textarea = targetPanel.querySelector('.comment-textarea');
                    if (textarea) {
                        setTimeout(() => textarea.focus(), 150);
                    }
                }
            }
        });
    });
});