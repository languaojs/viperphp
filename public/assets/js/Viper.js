class Viper {
    constructor(options) {
        this.options = options;
    }

    static init() {
        document.addEventListener('DOMContentLoaded', () => {
            const flashMsg = document.getElementById('flash-msg');

            if (flashMsg) {
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    flashMsg.style.opacity = '0';
                    setTimeout(() => {
                        flashMsg.remove();
                    }, 500); // Wait for transition to finish
                }, 5000);
            }
        });
    }
}