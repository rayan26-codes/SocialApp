document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggle-password-btn');

    // Modern SVG markup for Show (Eye) and Hide (Eye Slashed)
    const eyeIconSvg = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    `;

    const eyeSlashIconSvg = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M21 21l-18-18m18 18-3.686-3.686m1.89-1.857a10.457 10.457 0 0 0 1.83-3.457C19.774 7.662 15.756 4.5 11.999 4.5c-1.127 0-2.204.175-3.214.498m-1.39 1.39A3.001 3.001 0 0 0 12 15a3 3 0 0 0 .9-.14" />
        </svg>
    `;

    toggleButtons.forEach(button => {
        const eyeIconContainer = button.querySelector('.eye-icon');
        
        // Set initial state icon (Eye / Show)
        if (eyeIconContainer) {
            eyeIconContainer.innerHTML = eyeIconSvg;
        }

        button.addEventListener('click', function () {
            const passwordInput = this.parentElement.querySelector('input');
            const eyeIcon = this.querySelector('.eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = eyeSlashIconSvg; // Show the "Slashed" eye when text is visible
                this.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = eyeIconSvg; // Show normal eye when hidden
                this.setAttribute('aria-label', 'Show password');
            }
        });
    });
});
// ==========================================================================
    // Minimal Alert Dismissal Logic
    // ==========================================================================
    const alertBox = document.getElementById('authMessage');
    const closeBtn = document.getElementById('closeMessageBtn');

    if (alertBox) {
        // Safe, clean programmatic fade and collapse helper
        const closeAlert = () => {
            alertBox.classList.add('fade-out');
            
            // Wait for transition to end before destroying elements in the DOM
            alertBox.addEventListener('transitionend', function handler(e) {
                if (e.propertyName === 'opacity') {
                    alertBox.remove();
                }
            });
        };

        // Manual Close
        if (closeBtn) {
            closeBtn.addEventListener('click', closeAlert);
        }

        // Auto-Dismiss after 5 seconds
        const autoHideTimeout = setTimeout(closeAlert, 5000);

        // Cancel automatic timer if user decides to close early
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                clearTimeout(autoHideTimeout);
            });
        }
    }