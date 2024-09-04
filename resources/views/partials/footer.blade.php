<footer class="footer mt-auto py-3 bg-body-tertiary">
    <div class="container">
        <span class="text-body-secondary">Place sticky footer content here.</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('bd-theme');
    const themeOptions = document.querySelectorAll('[data-bs-theme-value]');

    themeOptions.forEach(option => {
        option.addEventListener('click', function () {
            const theme = this.getAttribute('data-bs-theme-value');
            document.documentElement.setAttribute('data-bs-theme', theme);
            updateActiveThemeOption(theme);
        });
    });

    function updateActiveThemeOption(theme) {
        themeOptions.forEach(option => {
            const isActive = option.getAttribute('data-bs-theme-value') === theme;
            option.classList.toggle('active', isActive);
            option.setAttribute('aria-pressed', isActive);
        });
    }

    // Set initial theme based on current value
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'auto';
    updateActiveThemeOption(currentTheme);
});

</script>
