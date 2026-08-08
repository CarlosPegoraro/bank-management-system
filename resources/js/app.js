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
