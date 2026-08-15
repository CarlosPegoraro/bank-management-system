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

const closeMobileMenu = () => {
    document.body.classList.remove('mobile-menu-open');
    const sidebar = document.querySelector('[data-mobile-sidebar]');
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    sidebar?.classList.remove('is-open');
    toggle?.setAttribute('aria-expanded', 'false');
    toggle?.setAttribute('aria-label', 'Abrir menu');
};

const toggleMobileMenu = () => {
    const sidebar = document.querySelector('[data-mobile-sidebar]');
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    if (!sidebar || !toggle) return;
    const open = sidebar.classList.toggle('is-open');
    document.body.classList.toggle('mobile-menu-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
};

document.addEventListener('click', (event) => {
    const target = event.target instanceof Element ? event.target : null;
    if (target?.closest('[data-mobile-menu-toggle]')) toggleMobileMenu();
    if (target?.closest('[data-mobile-menu-close], [data-mobile-sidebar] a')) closeMobileMenu();
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeMobileMenu();
});

document.addEventListener('livewire:navigated', closeMobileMenu);

let helpStep = 0;
let helpTarget = null;

const sendHelpEvent = (event, step = null) => {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    fetch('/onboarding/event', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: JSON.stringify({ tour: document.body.dataset.helpTour || 'unknown', event, step }),
        keepalive: true,
    }).catch(() => {});
};

const positionHelpDialog = () => {
    const modal = document.querySelector('[data-help-modal]');
    const dialog = modal?.querySelector('.help-dialog');
    if (!dialog || !modal || modal.hasAttribute('hidden')) return;

    const target = helpTarget;
    const margin = 16;
    const gap = 18;
    const width = Math.min(380, window.innerWidth - (margin * 2));
    dialog.style.width = `${width}px`;

    if (!target) {
        dialog.style.top = `${Math.max(margin, (window.innerHeight - dialog.offsetHeight) / 2)}px`;
        dialog.style.left = `${Math.max(margin, (window.innerWidth - width) / 2)}px`;
        return;
    }

    const rect = target.getBoundingClientRect();
    const dialogHeight = dialog.offsetHeight;
    const fitsVertically = (top) => top >= margin && top + dialogHeight <= window.innerHeight - margin;
    const fitsHorizontally = (left) => left >= margin && left + width <= window.innerWidth - margin;
    const overlaps = (top, left) => !(left + width <= rect.left - gap || left >= rect.right + gap || top + dialogHeight <= rect.top - gap || top >= rect.bottom + gap);
    const candidates = [
        { placement: 'bottom', top: rect.bottom + gap, left: rect.left + (rect.width / 2) - (width / 2) },
        { placement: 'top', top: rect.top - dialogHeight - gap, left: rect.left + (rect.width / 2) - (width / 2) },
        { placement: 'right', top: rect.top + (rect.height / 2) - (dialogHeight / 2), left: rect.right + gap },
        { placement: 'left', top: rect.top + (rect.height / 2) - (dialogHeight / 2), left: rect.left - width - gap },
    ];
    const bounded = candidates.map((candidate) => ({
        ...candidate,
        top: Math.max(margin, Math.min(candidate.top, window.innerHeight - dialogHeight - margin)),
        left: Math.max(margin, Math.min(candidate.left, window.innerWidth - width - margin)),
    }));
    const safe = bounded.find((candidate) => !overlaps(candidate.top, candidate.left));
    const inViewport = bounded.find((candidate) => fitsVertically(candidate.top) && fitsHorizontally(candidate.left));
    const fallback = safe || inViewport || bounded[0];
    const top = fallback.top;
    const left = fallback.left;

    dialog.dataset.placement = fallback.placement;
    dialog.style.top = `${top}px`;
    dialog.style.left = `${left}px`;
};

const closeHelp = (reason = null) => {
    if (reason) sendHelpEvent(reason, helpStep + 1);
    document.querySelector('[data-help-modal]')?.setAttribute('hidden', '');
    helpTarget?.classList.remove('help-highlight');
    helpTarget = null;
    document.body.classList.remove('help-is-open');
};

const showHelpStep = (index) => {
    const modal = document.querySelector('[data-help-modal]');
    const config = modal?.querySelector('[data-help-config]');
    if (!modal || !config) return;
    let steps;
    try { steps = JSON.parse(config.textContent); } catch { steps = []; }
    if (!steps.length) return;
    helpStep = Math.max(0, Math.min(index, steps.length - 1));
    sendHelpEvent('step', helpStep + 1);
    helpTarget?.classList.remove('help-highlight');
    const step = steps[helpStep];
    helpTarget = document.querySelector(step.selector);
    helpTarget?.classList.add('help-highlight');
    helpTarget?.scrollIntoView({ behavior: 'auto', block: 'center' });
    modal.querySelector('[data-help-step-title]').textContent = step.title;
    modal.querySelector('[data-help-step-text]').textContent = step.text;
    modal.querySelector('[data-help-count]').textContent = `Passo ${helpStep + 1} de ${steps.length}`;
    modal.querySelector('[data-help-progress]').style.width = `${((helpStep + 1) / steps.length) * 100}%`;
    modal.querySelector('[data-help-next]').textContent = helpStep === steps.length - 1 ? '✓' : '→';
    modal.querySelector('[data-help-prev]').disabled = helpStep === 0;
    requestAnimationFrame(() => requestAnimationFrame(positionHelpDialog));
};

const openHelp = () => {
    const modal = document.querySelector('[data-help-modal]');
    if (!modal) return;
    modal.removeAttribute('hidden');
    document.body.classList.add('help-is-open');
    showHelpStep(0);
};

document.addEventListener('click', (event) => {
    const target = event.target instanceof Element ? event.target : null;
    if (target?.closest('[data-help-open], [data-start-tour]')) { sendHelpEvent('opened'); openHelp(); }
    if (target?.closest('[data-help-close], [data-help-skip]')) closeHelp('skipped');
    if (target?.closest('[data-help-next]')) {
        const config = document.querySelector('[data-help-config]');
        const steps = config ? JSON.parse(config.textContent) : [];
        if (helpStep >= steps.length - 1) { sendHelpEvent('completed', helpStep + 1); if (document.body.dataset.helpTour === 'first-access') { document.body.dataset.onboardingComplete = 'true'; sessionStorage.setItem('cadim-onboarding-seen', '1'); } closeHelp(); } else showHelpStep(helpStep + 1);
    }
    if (target?.closest('[data-help-prev]') && helpStep > 0) showHelpStep(helpStep - 1);
    const search = target?.closest('[data-support-search]');
    if (search) {
        const query = search.value.trim().toLowerCase();
        let found = 0;
        document.querySelectorAll('[data-support-article]').forEach((article) => {
            const visible = !query || article.dataset.searchText.includes(query);
            article.hidden = !visible;
            if (visible) found++;
        });
        const empty = document.querySelector('[data-support-empty]');
        if (empty) empty.hidden = found > 0;
    }
    const feedback = target?.closest('[data-article-feedback]');
    if (feedback) {
        const article = feedback.closest('[data-feedback-article]')?.dataset.feedbackArticle;
        fetch('/suporte/feedback', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content, 'Accept': 'application/json' }, body: JSON.stringify({ article, type: feedback.dataset.articleFeedback }), keepalive: true }).catch(() => {});
        feedback.parentElement.querySelectorAll('[data-article-feedback]').forEach((button) => button.disabled = true);
        feedback.parentElement.insertAdjacentHTML('beforeend', '<small class="feedback-thanks">Obrigado pelo feedback!</small>');
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-support-feedback-form]');
    if (!form) return;
    event.preventDefault();
    const status = form.querySelector('[data-feedback-status]');
    fetch('/suporte/feedback', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content, 'Accept': 'application/json' }, body: JSON.stringify({ type: 'suggestion', message: form.message.value }) }).then(() => { form.reset(); status.textContent = 'Enviado. Obrigado!'; }).catch(() => { status.textContent = 'Não foi possível enviar agora.'; });
});

document.addEventListener('input', (event) => {
    if (!(event.target instanceof HTMLElement) || !event.target.matches('[data-support-search]')) return;
    event.target.dispatchEvent(new Event('click', { bubbles: true }));
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeHelp('skipped');
});

window.addEventListener('resize', positionHelpDialog);
window.addEventListener('scroll', positionHelpDialog, true);

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.onboardingComplete !== 'true' && !sessionStorage.getItem('cadim-onboarding-seen')) {
        sessionStorage.setItem('cadim-onboarding-seen', '1');
        setTimeout(() => { sendHelpEvent('opened'); openHelp(); }, 700);
    }
});
