<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Termos de Uso — Cadim</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        :root { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: #1f2937; background: #f2f8f3; }
        * { box-sizing: border-box; }
        body { margin: 0; min-width: 320px; background: #f2f8f3; background-image: radial-gradient(circle at 5% 7%, rgba(126, 201, 145, .2), transparent 27rem), radial-gradient(circle at 94% 90%, rgba(139, 217, 154, .18), transparent 25rem); }
        .terms-wrap { width: 100%; max-width: 960px; margin: 0 auto; padding: 32px 16px; }
        .terms-card { width: 100%; margin: 0 auto; padding: 40px; background: #fff; border: 1px solid #e5eee7; border-radius: 20px; box-shadow: 0 24px 75px rgba(30, 74, 43, .12); }
        .terms-card .auth-logo { display: inline-block; margin-bottom: 36px; }
        .terms-card .auth-logo img { display: block; width: auto; height: 48px; max-width: 100%; }
        .terms-card .eyebrow { margin: 0; color: #168044; font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .terms-card h1 { margin: 8px 0 0; color: #17221c; font-size: clamp(28px, 4vw, 38px); line-height: 1.15; letter-spacing: -.03em; }
        .terms-card h2 { margin: 32px 0 0; color: #26382d; font-size: 18px; line-height: 1.3; }
        .terms-card p { margin: 12px 0 0; color: #526257; font-size: 15px; line-height: 1.7; }
        .terms-card .terms-lead { margin-top: 16px; color: #637568; font-size: 16px; }
        .terms-card .terms-updated { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5eee7; color: #7b8b80; font-size: 12px; }
        .terms-card .terms-back { display: inline-flex; margin-top: 20px; padding: 11px 16px; border-radius: 8px; background: #62ad76; color: #fff; font-size: 14px; font-weight: 700; text-decoration: none; }
        .terms-card .terms-back:hover { background: #168044; }
        @media (max-width: 640px) { .terms-wrap { padding: 16px 12px; } .terms-card { padding: 24px 20px; border-radius: 14px; } .terms-card .auth-logo { margin-bottom: 28px; } }
    </style>
</head>
<body class="auth-page">
    <main class="terms-wrap">
        <article class="terms-card">
            <a href="{{ route('login') }}" class="auth-logo"><img src="{{ asset('logo.svg') }}" alt="Cadim"></a>
            <p class="eyebrow">DOCUMENTO V{{ config('legal.terms_version') }}</p>
            <h1>Termos de Uso</h1>
            <p class="terms-lead">Leia estas regras antes de criar sua conta no Cadim. Ao marcar a opção de aceite no cadastro, você declara que leu e concorda com este documento.</p>

            <h2>1. Sobre o serviço</h2>
            <p>O Cadim é uma ferramenta de organização financeira pessoal. Ele permite registrar receitas, despesas, contas, cartões, transferências, orçamentos e metas para facilitar o acompanhamento da sua vida financeira.</p>
            <p>O serviço não é instituição financeira, banco, corretora, emissor de cartão ou consultoria de investimentos. Não movimentamos seu dinheiro e não executamos pagamentos ou transações em seu nome.</p>

            <h2>2. Cadastro e responsabilidade pela conta</h2>
            <p>Você deve fornecer informações verdadeiras, manter seus dados atualizados e ter pelo menos 18 anos, ou utilizar o serviço com a assistência e autorização do responsável legal. Sua conta é pessoal e você é responsável pela senha, pelos dispositivos usados para acesso e por toda atividade realizada nela.</p>
            <p>Não compartilhe suas credenciais. Avise o responsável pelo serviço assim que perceber acesso indevido, perda da senha ou qualquer incidente de segurança.</p>

            <h2>3. Dados financeiros informados por você</h2>
            <p>Os dados de contas, cartões e transações são inseridos e mantidos por você. O sistema pode realizar cálculos, classificações e projeções com base nessas informações, mas você deve conferir os resultados antes de tomar decisões.</p>
            <p>As informações exibidas são de apoio à organização e não constituem recomendação financeira, tributária, contábil ou de investimento. O serviço não garante que projeções, saldos ou alertas estejam livres de erros ou sejam adequados à sua situação.</p>

            <h2>4. Uso permitido</h2>
            <p>Você se compromete a utilizar o serviço de forma lícita, sem tentar obter acesso a contas de terceiros, interferir no funcionamento da plataforma, enviar código malicioso, explorar falhas ou usar o sistema para fraude, lavagem de dinheiro ou qualquer finalidade ilegal.</p>

            <h2>5. Disponibilidade e alterações</h2>
            <p>Podemos corrigir, atualizar, suspender ou descontinuar funcionalidades para manutenção, segurança ou evolução do serviço. Quando uma alteração relevante afetar estes Termos, publicaremos uma nova versão nesta página e informaremos os usuários pelos canais disponíveis, quando aplicável.</p>

            <h2>6. Privacidade e proteção de dados</h2>
            <p id="privacidade">Tratamos os dados pessoais necessários para criar e operar sua conta, autenticar seu acesso, proteger o serviço e oferecer suas funcionalidades. O tratamento observará a Lei Geral de Proteção de Dados (Lei nº 13.709/2018), os princípios de necessidade, segurança e transparência e os direitos do titular previstos em lei.</p>
            <p>Você pode solicitar informações sobre o tratamento dos seus dados e exercer seus direitos pelo canal de suporte disponibilizado no sistema. O aceite destes Termos não autoriza usos genéricos ou incompatíveis com as finalidades informadas.</p>

            <h2>7. Segurança e exclusão da conta</h2>
            <p>Adotamos medidas razoáveis de segurança, mas nenhum serviço conectado à internet é completamente imune a falhas. Você pode solicitar a exclusão da conta pelo canal de suporte, observadas as obrigações legais de retenção. O uso em desacordo com estes Termos poderá resultar em suspensão ou encerramento da conta, respeitada a legislação aplicável.</p>

            <h2>8. Lei aplicável</h2>
            <p>Estes Termos são regidos pelas leis brasileiras. Eventuais dúvidas ou conflitos deverão ser tratados inicialmente pelo canal de suporte do serviço, sem prejuízo dos direitos assegurados pela legislação aplicável.</p>

            <p class="terms-updated">Última atualização: 9 de agosto de 2026 · Versão {{ config('legal.terms_version') }}</p>
            <a href="{{ route('register') }}" class="btn-primary terms-back">Voltar ao cadastro</a>
        </article>
    </main>
</body>
</html>
