const updateThemeToggle = () => {
    const dark = document.documentElement.dataset.theme === 'dark';

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.classList.toggle('is-dark', dark);
        button.setAttribute('aria-pressed', dark ? 'true' : 'false');
        button.setAttribute('aria-label', dark ? 'Ativar modo claro' : 'Ativar modo escuro');
        button.querySelector('[data-theme-icon]')?.replaceChildren(document.createTextNode(dark ? '☀' : '☾'));
    });
};

const applySavedTheme = () => {
    const savedTheme = localStorage.getItem('theme');
    document.documentElement.dataset.theme = savedTheme === 'dark' ? 'dark' : 'light';
};

document.addEventListener('click', (event) => {
    const target = event.target;
    const button = target instanceof Element ? target.closest('[data-theme-toggle]') : null;
    if (!button) return;

    const dark = document.documentElement.dataset.theme === 'dark';
    document.documentElement.dataset.theme = dark ? 'light' : 'dark';
    localStorage.setItem('theme', dark ? 'light' : 'dark');
    updateThemeToggle();
});

applySavedTheme();
updateThemeToggle();
document.addEventListener('livewire:navigating', applySavedTheme);
document.addEventListener('livewire:navigated', () => {
    applySavedTheme();
    updateThemeToggle();
});

document.addEventListener('keydown', (event) => {
    const target = event.target;
    const typing = target instanceof HTMLElement && ['INPUT', 'TEXTAREA', 'SELECT'].includes(target.tagName);

    if (event.key === '/' && !typing) {
        const search = document.querySelector('.search-box input');
        if (search) {
            event.preventDefault();
            search.focus();
        }
    }

    if (event.key.toLowerCase() === 'n' && !typing) {
        document.querySelector('[data-shortcut-new]')?.click();
    }

    if (event.key === 'Escape') {
        document.querySelectorAll('details[open]').forEach((menu) => menu.removeAttribute('open'));
    }
});
