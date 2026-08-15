<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Termos de Uso e Política de Privacidade — Cadim</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: #1f2937; background: #f2f8f3; }
        * { box-sizing: border-box; }
        body { margin: 0; min-width: 320px; background: #f2f8f3; background-image: radial-gradient(circle at 5% 7%, rgba(126, 201, 145, .2), transparent 27rem), radial-gradient(circle at 94% 90%, rgba(139, 217, 154, .18), transparent 25rem); }
        .terms-wrap { width: 100%; max-width: 1024px; margin: 0 auto; padding: 32px 16px; }
        .terms-card { width: 100%; margin: 0 auto; padding: 40px; background: #fff; border: 1px solid #e5eee7; border-radius: 20px; box-shadow: 0 24px 75px rgba(30, 74, 43, .12); }
        .terms-card .auth-logo { display: inline-block; margin-bottom: 36px; }
        .terms-card .auth-logo img { display: block; width: auto; height: 48px; max-width: 100%; }
        .terms-card .eyebrow { margin: 0; color: #168044; font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .terms-card h1 { margin: 8px 0 0; color: #17221c; font-size: clamp(28px, 4vw, 38px); line-height: 1.15; letter-spacing: -.03em; }
        .terms-card h2 { margin: 40px 0 0; padding-top: 8px; color: #26382d; font-size: 21px; line-height: 1.3; }
        .terms-card h3 { margin: 28px 0 0; color: #304b39; font-size: 17px; line-height: 1.35; }
        .terms-card p { margin: 12px 0 0; color: #526257; font-size: 15px; line-height: 1.7; }
        .terms-card .terms-lead { margin-top: 16px; color: #637568; font-size: 16px; }
        .terms-card ul, .terms-card ol { margin: 12px 0 0; padding-left: 24px; color: #526257; font-size: 15px; line-height: 1.7; }
        .terms-card li + li { margin-top: 5px; }
        .terms-card strong { color: #304b39; }
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
            <h1>Termos de Uso e Política de Privacidade do Cadim</h1>
            <p class="terms-lead">Estes Termos de Uso e Política de Privacidade regulam o acesso e a utilização do Cadim, plataforma digital destinada à organização e ao acompanhamento de informações financeiras pessoais.</p>
            <p>Ao criar uma conta, acessar ou utilizar o Cadim, o usuário declara ter lido e compreendido este documento e concorda em utilizar a plataforma de acordo com estas condições.</p>
            <p>O aceite destes Termos não representa autorização genérica para tratamento de dados pessoais. O tratamento de dados será realizado somente para finalidades determinadas e com fundamento nas hipóteses previstas na legislação aplicável.</p>

            <h2>PARTE I — TERMOS DE USO</h2>
            <h3>1. Identificação do serviço</h3>
            <p>O Cadim é disponibilizado por:</p>
            <p><strong>Responsável:</strong> Carlos Eduardo Pegoraro Lopes<br><strong>CPF/CNPJ:</strong> 549.457.XXX-XX<br><strong>Endereço:</strong> Não aplicável<br><strong>E-mail de suporte:</strong> carlospegorarolopes@gmail.com<br><strong>Canal de privacidade:</strong> carlospegorarolopes@gmail.com</p>
            <p>Neste documento, o responsável pela plataforma poderá ser denominado simplesmente <strong>“Cadim”</strong>, <strong>“nós”</strong> ou <strong>“plataforma”</strong>.</p>

            <h3>2. Sobre o Cadim</h3>
            <p>O Cadim é uma ferramenta tecnológica de organização financeira pessoal que permite, conforme as funcionalidades disponíveis em cada momento, registrar, consultar, categorizar e acompanhar informações como:</p>
            <ul><li>receitas;</li><li>despesas;</li><li>contas;</li><li>cartões;</li><li>transferências;</li><li>categorias financeiras;</li><li>orçamentos;</li><li>metas;</li><li>saldos;</li><li>lançamentos recorrentes;</li><li>projeções e indicadores financeiros.</li></ul>
            <p>A disponibilidade de determinada funcionalidade poderá variar conforme a versão, modalidade de acesso ou plano utilizado.</p>
            <h3>2.1. O que o Cadim não é</h3>
            <p>O Cadim <strong>não é instituição financeira, instituição de pagamento, banco, corretora de valores, seguradora, administradora de recursos ou consultoria financeira, contábil, jurídica, tributária ou de investimentos</strong>.</p>
            <p>Salvo quando expressamente informado em funcionalidade específica, o Cadim não movimenta recursos financeiros do usuário, não realiza pagamentos em nome do usuário, não concede crédito, não intermedeia investimentos, não custodia recursos ou ativos e não garante resultados financeiros.</p>
            <p>Informações, gráficos, projeções, classificações, alertas, estatísticas e demais resultados produzidos pelo sistema possuem caráter exclusivamente informativo e de organização.</p>

            <h3>3. Elegibilidade</h3>
            <p>O Cadim é destinado exclusivamente a pessoas com <strong>18 anos ou mais e plenamente capazes de praticar os atos da vida civil</strong>. Ao criar uma conta, o usuário declara possuir capacidade legal para aceitar estes Termos.</p>

            <h3>4. Cadastro</h3>
            <p>Para utilizar determinadas funcionalidades, poderá ser necessária a criação de uma conta. O usuário compromete-se a:</p>
            <ol><li>fornecer informações verdadeiras e atualizadas;</li><li>manter seus dados cadastrais atualizados;</li><li>não criar conta utilizando identidade falsa ou dados de terceiros sem autorização;</li><li>manter suas credenciais de acesso sob sigilo;</li><li>adotar medidas razoáveis de segurança nos dispositivos utilizados para acessar o Cadim.</li></ol>
            <p>A conta é pessoal e, salvo quando a própria plataforma oferecer funcionalidade específica de compartilhamento, não deve ser transferida ou compartilhada com terceiros.</p>

            <h3>5. Segurança da conta</h3>
            <p>O usuário é responsável pela guarda de suas credenciais e pela utilização dos dispositivos através dos quais acessa o Cadim. Caso identifique acesso não autorizado, comprometimento de senha, dispositivo perdido ou roubado, atividade suspeita ou qualquer outro evento que possa comprometer sua conta, deverá comunicar o Cadim assim que possível através do canal de suporte.</p>
            <p>O Cadim poderá solicitar redefinição de senha, realizar encerramento de sessões ou adotar outras medidas preventivas quando houver indícios razoáveis de comprometimento de segurança.</p>

            <h3>6. Informações financeiras inseridas pelo usuário</h3>
            <p>Grande parte das informações financeiras existentes no Cadim poderá ser cadastrada, editada ou importada pelo próprio usuário. O usuário é responsável pela exatidão, integridade e atualização desses dados.</p>
            <p>O Cadim poderá executar automaticamente cálculos, classificações, agregações, filtros, projeções, estimativas, identificação de recorrências, geração de gráficos e produção de indicadores. Esses resultados dependem diretamente da qualidade e da atualização dos dados disponíveis.</p>
            <p>O usuário deverá conferir informações relevantes antes de utilizá-las para decisões financeiras, patrimoniais, fiscais, contábeis ou de qualquer outra natureza.</p>

            <h3>7. Ausência de recomendação financeira</h3>
            <p>Nenhuma informação exibida pelo Cadim deve ser interpretada como promessa de resultado ou recomendação personalizada de investimento, financiamento, contratação de crédito, compra ou venda de ativos, planejamento tributário, estratégia contábil ou decisão patrimonial. Decisões financeiras permanecem sob responsabilidade exclusiva do usuário.</p>

            <h3>8. Uso permitido da plataforma</h3>
            <p>O usuário compromete-se a utilizar o Cadim exclusivamente para finalidades lícitas e de acordo com estes Termos.</p>
            <p>É proibido:</p>
            <ol><li>acessar ou tentar acessar conta pertencente a terceiro sem autorização;</li><li>obter, tentar obter ou explorar acesso não autorizado aos sistemas do Cadim;</li><li>interferir deliberadamente no funcionamento ou disponibilidade da plataforma;</li><li>contornar mecanismos de autenticação, controle de acesso, rate limiting ou segurança;</li><li>realizar varreduras, testes de intrusão ou exploração de vulnerabilidades sem autorização prévia;</li><li>introduzir vírus, malware, scripts maliciosos ou outros códigos destinados a comprometer a plataforma;</li><li>realizar ataques de negação de serviço;</li><li>utilizar automação, scraping ou mecanismos semelhantes de forma incompatível com as funcionalidades disponibilizadas;</li><li>utilizar a plataforma para fraude, lavagem de dinheiro, ocultação patrimonial ou qualquer atividade ilícita;</li><li>copiar, reproduzir ou explorar comercialmente elementos protegidos do Cadim sem autorização;</li><li>tentar realizar engenharia reversa da aplicação, exceto quando expressamente permitido por lei;</li><li>utilizar a infraestrutura do Cadim de maneira que prejudique outros usuários ou coloque em risco a segurança da plataforma.</li></ol>

            <h3>9. Propriedade intelectual</h3>
            <p>A plataforma, incluindo seu código-fonte, código compilado, interfaces, identidade visual, textos, elementos gráficos, banco de dados, arquitetura, funcionalidades e demais componentes protegíveis pertencem aos seus respectivos titulares.</p>
            <p>A criação de uma conta concede ao usuário apenas uma licença pessoal, limitada, revogável, não exclusiva e intransferível para utilizar o Cadim de acordo com estes Termos. Nenhum direito de propriedade intelectual é transferido ao usuário em razão da utilização do serviço.</p>
            <p>Os dados financeiros e demais conteúdos inseridos pelo usuário permanecem pertencentes ao usuário ou aos respectivos titulares.</p>

            <h3>10. Disponibilidade do serviço</h3>
            <p>O Cadim busca manter seus serviços disponíveis e funcionais, mas não garante operação ininterrupta ou totalmente livre de erros. A plataforma poderá ser temporariamente afetada por manutenção, atualizações, falhas de infraestrutura, indisponibilidade de fornecedores, falhas de telecomunicações, ataques cibernéticos, eventos de força maior ou problemas técnicos imprevisíveis.</p>

            <h3>11. Funcionalidades experimentais</h3>
            <p>O Cadim poderá disponibilizar funcionalidades identificadas como <strong>beta</strong>, <strong>experimental</strong>, <strong>preview</strong>, <strong>teste</strong> ou equivalente. Essas funcionalidades poderão apresentar instabilidade, sofrer alterações substanciais ou ser removidas. O usuário não deverá depender exclusivamente delas para armazenar informação cuja perda possa produzir consequências relevantes.</p>

            <h3>12. Serviços e integrações de terceiros</h3>
            <p>O Cadim poderá utilizar serviços de terceiros necessários à sua operação, incluindo infraestrutura de hospedagem, autenticação, envio de mensagens, monitoramento, armazenamento, análise de erros, pagamentos ou outras funcionalidades. Quando o usuário utilizar uma funcionalidade integrada a serviço externo, determinados dados poderão ser tratados por esse fornecedor na medida necessária à execução da integração.</p>

            <h3>13. Backup e conservação de informações</h3>
            <p>O Cadim poderá manter rotinas técnicas de backup destinadas à continuidade e recuperação do serviço. Backups de infraestrutura não constituem serviço individual de armazenamento permanente de documentos ou garantia absoluta de recuperação de cada informação cadastrada pelo usuário. Quando disponibilizada funcionalidade de exportação, recomenda-se que o usuário mantenha cópias próprias das informações relevantes.</p>

            <h3>14. Alterações no serviço</h3>
            <p>O Cadim poderá adicionar, alterar, substituir ou descontinuar funcionalidades para aprimoramento, manutenção, segurança, adequação jurídica ou evolução tecnológica. Mudanças que afetem materialmente os direitos dos usuários serão comunicadas pelos meios razoavelmente disponíveis.</p>

            <h3>15. Suspensão e encerramento de contas</h3>
            <p>O Cadim poderá restringir, suspender ou encerrar uma conta quando houver indícios razoáveis de fraude, violação destes Termos, comprometimento de segurança, utilização ilícita, risco para outros usuários ou para a infraestrutura, obrigação legal ou determinação de autoridade competente.</p>

            <h3>16. Encerramento da conta pelo usuário</h3>
            <p>O usuário poderá solicitar o encerramento de sua conta através da funcionalidade existente na plataforma ou do canal de suporte. O encerramento não significa necessariamente exclusão instantânea de todos os registros. Determinadas informações poderão permanecer armazenadas quando necessárias para cumprimento de obrigação legal, exercício regular de direitos, prevenção de fraude ou cumprimento de ordem judicial ou administrativa.</p>

            <h3>17. Responsabilidade do usuário</h3>
            <p>O usuário será responsável pelos danos decorrentes de utilização ilícita da plataforma ou de violação destes Termos quando comprovadamente atribuíveis à sua conduta. Também permanece responsável pela análise das informações que cadastra ou obtém e pelas decisões tomadas com base nelas.</p>

            <h3>18. Limitação de responsabilidade do Cadim</h3>
            <p>Dentro dos limites permitidos pela legislação, o Cadim não será responsável por perdas resultantes exclusivamente de informações incorretas fornecidas pelo usuário, decisões financeiras tomadas pelo usuário, utilização em desacordo com estes Termos, comprometimento de credenciais causado pelo próprio usuário, serviços de terceiros fora de seu controle razoável ou eventos imprevisíveis e inevitáveis.</p>
            <p>Nenhuma disposição destes Termos tem por objetivo excluir ou limitar responsabilidade que não possa ser legalmente afastada. Esta cláusula não prejudica direitos garantidos pela legislação brasileira, inclusive normas de proteção ao consumidor e de proteção de dados pessoais.</p>

            <h3>19. Alterações destes Termos</h3>
            <p>Estes Termos poderão ser atualizados para refletir novas funcionalidades, alterações técnicas, mudanças operacionais, alterações legislativas ou aperfeiçoamentos de segurança e privacidade. A versão vigente estará identificada pela data e número da versão. Quando juridicamente necessário, poderá ser solicitado novo aceite.</p>

            <h3>20. Comunicações</h3>
            <p>O Cadim poderá enviar comunicações relacionadas à prestação do serviço, incluindo mensagens sobre segurança, autenticação, alterações importantes da conta, manutenção, mudanças contratuais, privacidade e suporte. Comunicações estritamente necessárias ao funcionamento ou à segurança da conta não possuem natureza promocional.</p>

            <h2>PARTE II — POLÍTICA DE PRIVACIDADE</h2>
            <h3>21. Compromisso com a privacidade</h3>
            <p>O Cadim busca tratar dados pessoais de maneira compatível com a <strong>Lei nº 13.709/2018 — Lei Geral de Proteção de Dados Pessoais (LGPD)</strong> e demais normas aplicáveis, observando finalidade, adequação, necessidade, livre acesso, qualidade, transparência, segurança, prevenção, não discriminação e responsabilização.</p>

            <h3>22. Controlador dos dados pessoais</h3>
            <p>Para os tratamentos de dados pessoais relacionados diretamente à operação do Cadim, o controlador é:</p>
            <p><strong>Controlador:</strong> Carlos Eduardo Pegoraro Lopes<br><strong>CPF/CNPJ:</strong> 549.457.XXX-XX<br><strong>Canal para assuntos de privacidade:</strong> carlospegorarolopes@gmail.com</p>
            <p>Solicitações relacionadas à LGPD deverão ser encaminhadas preferencialmente por esse canal.</p>

            <h3>23. Dados que podemos tratar</h3>
            <p>Dependendo da utilização do serviço, poderão ser tratados dados cadastrais, como nome, e-mail, identificador interno, informações necessárias à autenticação e preferências da conta; dados financeiros cadastrados pelo usuário, como receitas, despesas, valores, categorias, contas, cartões, transferências, orçamentos, metas e saldos; dados técnicos e de utilização, como IP, data e horário de acesso, navegador, sistema operacional, identificadores técnicos, logs, eventos de segurança, erros, sessões e autenticação; e dados de suporte, como solicitações, mensagens, dados técnicos e arquivos enviados voluntariamente.</p>

            <h3>24. Dados que não devem ser informados desnecessariamente</h3>
            <p>O usuário não deve inserir em campos de texto livre dados pessoais de terceiros ou informações sensíveis desnecessárias. [SE FOR VERDADE NO SISTEMA:] O Cadim não solicita senha de internet banking, senha de cartão, PIN, CVV ou código de autenticação bancária. Caso receba solicitação desse tipo em nome do Cadim, deverá interromper a interação e procurar o canal oficial.</p>

            <h3>25. Finalidades e bases legais</h3>
            <p>Os dados poderão ser tratados para criar e administrar a conta, autenticar o usuário, manter sessões e executar funcionalidades solicitadas, com base na execução de contrato; para segurança e prevenção de fraude, com base em legítimo interesse, execução contratual, exercício regular de direitos ou obrigação legal; para suporte e melhoria do produto; para cumprimento de obrigações legais; e, quando necessário, com consentimento específico e destacado.</p>

            <h3>26. Decisões automatizadas</h3>
            <p>O Cadim poderá executar automaticamente cálculos, classificações, projeções e organização de informações para disponibilizar suas funcionalidades. Essas operações não têm como objetivo produzir decisões com efeitos jurídicos contra o usuário. Caso futuramente sejam implementadas operações com efeitos significativos, esta Política será atualizada.</p>

            <h3>27. Compartilhamento de dados</h3>
            <p>O Cadim <strong>não comercializa dados pessoais dos usuários</strong>. Dados poderão ser compartilhados somente quando necessário com fornecedores de infraestrutura, prestadores de suporte técnico, autoridades públicas quando houver obrigação válida ou em operações societárias, observadas as obrigações legais aplicáveis.</p>

            <h3>28. Operadores e fornecedores</h3>
            <p>Fornecedores que realizem tratamento em nome do Cadim deverão receber acesso apenas às informações necessárias para execução de seus serviços. Sempre que aplicável, serão adotados mecanismos contratuais de confidencialidade, segurança e proteção de dados.</p>
            <p>[RECOMENDADO: manter uma página atualizada denominada “Suboperadores e fornecedores” identificando os principais provedores de infraestrutura.]</p>

            <h3>29. Transferência internacional de dados</h3>
            <p>Alguns fornecedores tecnológicos poderão processar ou armazenar informações fora do Brasil. Quando houver transferência internacional, serão observados os mecanismos e requisitos estabelecidos pela LGPD e pela regulamentação aplicável da ANPD.</p>

            <h3>30. Retenção de dados</h3>
            <p>Dados pessoais serão conservados somente pelo período necessário para cumprir suas finalidades, respeitando obrigações legais, regulatórias, contratuais e o exercício regular de direitos. Dados poderão ser anonimizados e mantidos quando a legislação permitir e não for mais razoavelmente possível relacioná-los a pessoa identificada ou identificável.</p>

            <h3>31. Logs de acesso</h3>
            <p>Quando aplicável ao Cadim na condição de provedor de aplicação de internet, determinados registros de acesso poderão ser conservados pelo período previsto na legislação brasileira, sob condições de segurança e confidencialidade.</p>

            <h3>32. Cookies e tecnologias semelhantes</h3>
            <p>O Cadim poderá utilizar cookies estritamente necessários para autenticação, manutenção da sessão, segurança e preferências essenciais. Caso utilize cookies de análise ou outras finalidades, o usuário receberá informações adequadas sobre sua finalidade e, quando exigido, poderá manifestar sua preferência antes da utilização.</p>
            <p>[SE O CADIM USAR GOOGLE ANALYTICS, META PIXEL, CLARITY, POSTHOG, SENTRY OU SIMILAR, IDENTIFICAR AQUI OU EM UMA POLÍTICA DE COOKIES.]</p>

            <h3>33. Segurança da informação</h3>
            <p>O Cadim adota medidas técnicas e administrativas destinadas a reduzir riscos de acesso não autorizado, destruição, perda, alteração, comunicação, vazamento ou tratamento inadequado de dados pessoais. Essas medidas poderão incluir controle de acesso, autenticação, proteção de credenciais, registros de segurança, backups, atualização de dependências, monitoramento e gestão de vulnerabilidades.</p>
            <p>Nenhum sistema conectado à internet pode oferecer risco zero. A segurança é tratada como processo contínuo de prevenção, detecção e resposta.</p>

            <h3>34. Incidentes de segurança</h3>
            <p>Caso ocorra incidente de segurança envolvendo dados pessoais, o Cadim avaliará a natureza dos dados, a quantidade e o perfil dos titulares, as consequências potenciais e as medidas de contenção. Quando o incidente puder acarretar risco ou dano relevante, serão realizadas as comunicações exigidas pela LGPD e pela regulamentação da ANPD dentro dos prazos aplicáveis.</p>

            <h3>35. Direitos do titular</h3>
            <p>Nos termos da legislação aplicável, o titular poderá solicitar confirmação da existência de tratamento, acesso, correção, anonimização, bloqueio ou eliminação, portabilidade quando aplicável, informações sobre compartilhamento, revogação do consentimento, eliminação de dados tratados com consentimento, oposição a determinados tratamentos, revisão de decisões automatizadas quando aplicável e demais direitos previstos em lei.</p>

            <h3>36. Como exercer direitos</h3>
            <p>Solicitações relacionadas a dados pessoais poderão ser encaminhadas para <strong>[PRIVACIDADE@CADIM...]</strong>. Para proteger os próprios dados, o Cadim poderá solicitar informações razoavelmente necessárias para confirmar a identidade do solicitante. Solicitações serão analisadas dentro dos prazos previstos na legislação.</p>

            <h3>37. Exclusão da conta e dos dados</h3>
            <p>O usuário poderá solicitar o encerramento de sua conta. Dados que não possuam fundamento legítimo para conservação serão eliminados ou anonimizados de acordo com os processos técnicos aplicáveis. Algumas informações poderão permanecer armazenadas quando necessárias para cumprimento de obrigação legal, determinação de autoridade, exercício regular de direitos, prevenção de fraude ou proteção do Cadim e de seus usuários.</p>
            <p>Backups poderão manter cópias temporárias até a conclusão de seus ciclos regulares de expiração, permanecendo protegidos contra utilização ordinária.</p>

            <h3>38. Privacidade desde a concepção</h3>
            <p>Sempre que razoavelmente aplicável, novas funcionalidades do Cadim serão desenvolvidas considerando minimização da coleta, limitação de acesso, segurança, finalidade, retenção adequada e privacidade por padrão.</p>

            <h3>39. Alterações desta Política</h3>
            <p>Esta Política poderá ser atualizada em razão de mudanças legislativas, regulatórias, tecnológicas, operacionais ou relacionadas às funcionalidades do Cadim. A versão vigente permanecerá disponível nesta página com a respectiva data de atualização. Alterações materiais poderão ser comunicadas pelos canais adequados.</p>

            <h2>PARTE III — DISPOSIÇÕES FINAIS</h2>
            <h3>40. Invalidade parcial</h3>
            <p>Caso alguma disposição seja considerada inválida, ilegal ou inexequível, as demais continuarão em vigor na máxima extensão permitida pela legislação.</p>
            <h3>41. Tolerância</h3>
            <p>A eventual ausência de exercício de determinado direito não representa renúncia, alteração contratual ou novação.</p>
            <h3>42. Legislação aplicável</h3>
            <p>Estes Termos são regidos pelas leis da República Federativa do Brasil, especialmente pela legislação aplicável à proteção de dados pessoais, serviços digitais e relações de consumo.</p>
            <h3>43. Resolução de conflitos</h3>
            <p>Em caso de dúvida ou controvérsia, o usuário poderá entrar em contato inicialmente pelo canal <strong>[SUPORTE@CADIM...]</strong>. O Cadim buscará solucionar solicitações de maneira razoável e transparente, sem impedir o acesso aos órgãos administrativos ou ao Poder Judiciário.</p>
            <h3>44. Contato</h3>
            <p><strong>Suporte:</strong> [SUPORTE@CADIM...]<br><strong>Privacidade e proteção de dados:</strong> [PRIVACIDADE@CADIM...]<br><strong>Responsável pelo Cadim:</strong> [NOME/RAZÃO SOCIAL]<br><strong>CPF/CNPJ:</strong> [CPF/CNPJ]</p>

            <p class="terms-updated">Última atualização: {{ config('legal.terms_updated_at') }} · Versão {{ config('legal.terms_version') }}</p>
            <a href="{{ route('register') }}" class="btn-primary terms-back">Voltar ao cadastro</a>
        </article>
    </main>
</body>
</html>
