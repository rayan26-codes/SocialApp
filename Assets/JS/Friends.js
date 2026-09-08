// Assets/JS/Friends.js

// ==========================================================================
// Toast Close Function (Global Scope for direct onclick execution)
// ==========================================================================
function closeToastNow() {
    const toast = document.getElementById('toastNotification');

    if (toast) {
        toast.classList.add('hide');

        setTimeout(() => {
            if (toast && toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 250); // Matches CSS transition duration
    }
}

document.addEventListener('DOMContentLoaded', () => {

    // ======================================================================
    // Toast Auto-Dismiss
    // ======================================================================
    // Auto-dismiss notification after 3 seconds (3000 milliseconds)
    const toast = document.getElementById('toastNotification');

    if (toast) {
        setTimeout(() => {
            closeToastNow();
        }, 3000);
    }

    // ======================================================================
    // Existing Friends Page Functionality
    // ======================================================================

    const userCards = document.querySelectorAll('.user-card');
    const searchInput = document.querySelector('.search-input');

    // 1. Interactive Button Micro-Animations
    const actionButtons = document.querySelectorAll('.card-actions .btn');

    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            this.style.transform = 'scale(0.95)';

            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // 2. Search Input Highlight Polish
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-1px)';
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = '';
        });
    }
});