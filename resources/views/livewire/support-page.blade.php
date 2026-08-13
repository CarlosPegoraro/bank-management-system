<div class="support-page">
    <header class="support-hero" data-help-target="support-hero">
        <div>
            <p class="eyebrow">CENTRAL DE SUPORTE</p>
            <h1>Aprenda a cuidar melhor das suas finanças</h1>
            <p>Guias rápidos para você encontrar seu caminho no Cadim, do primeiro cadastro ao planejamento do mês.</p>
        </div>
        <div class="support-hero-mark">?</div>
    </header>

    <div class="support-toolbar">
        <label class="support-search"><span>⌕</span><input type="search" placeholder="Buscar um artigo, por exemplo: cartão" data-support-search></label>
        <button type="button" class="btn-secondary" data-start-tour>▶ Começar tour da página</button>
    </div>

    <div class="support-grid" data-support-list>
        @foreach($articles as $article)
            <article class="support-article" data-support-article data-search-text="{{ strtolower($article['category'].' '.$article['title'].' '.$article['summary'].' '.implode(' ', $article['body'])) }}">
                <div class="support-article-icon">{{ $article['icon'] }}</div>
                <p class="support-category">{{ $article['category'] }}</p>
                <h2>{{ $article['title'] }}</h2>
                <p class="support-summary">{{ $article['summary'] }}</p>
                <details><summary>Ver passo a passo <span>＋</span></summary><ol>@foreach($article['body'] as $step)<li>{{ $step }}</li>@endforeach</ol><div class="article-feedback" data-feedback-article="{{ $article['title'] }}"><span>Este artigo ajudou?</span><button type="button" data-article-feedback="helpful" aria-label="Sim, ajudou">👍</button><button type="button" data-article-feedback="not_helpful" aria-label="Não ajudou">👎</button></div></details>
            </article>
        @endforeach
    </div>
    <p class="support-empty" data-support-empty hidden>Nenhum artigo encontrado. Tente buscar por outra palavra.</p>
    <section class="support-contact"><div><p class="support-category">AINDA PRECISA DE AJUDA?</p><h2>Envie uma sugestão</h2><p>Conte o que podemos melhorar ou descreva um problema encontrado.</p></div><form data-support-feedback-form><textarea name="message" rows="3" placeholder="Escreva sua sugestão..."></textarea><button type="submit" class="btn-primary">Enviar sugestão</button><span data-feedback-status></span></form></section>
</div>
