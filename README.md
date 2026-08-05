# Cadê o Meu Dinheiro?

Sistema pessoal de gestão financeira feito com Laravel, Livewire, Tailwind CSS e PostgreSQL.

## Recursos

- Entradas e saídas avulsas, mensais ou parceladas.
- Confirmação de pagamento/recebimento e projeção de seis meses.
- Dashboard mensal e fluxo de 12 meses (cinco anteriores, atual e seis futuros).
- Contas, cartões com fechamento/vencimento e categorias pessoais.

## Executar localmente

1. Crie um banco PostgreSQL chamado `verde_financas` e ajuste as credenciais em `.env` a partir de `.env.example`.
2. Instale dependências: `composer install && npm install`.
3. Gere a chave e as tabelas: `php artisan key:generate && php artisan migrate`.
4. Inicie o ambiente: `composer run dev`.

Para validar localmente:

```bash
composer test
composer analyse
composer pint:check
npm run build
```

## Docker

O ambiente de desenvolvimento segue o padrão dos projetos em `/var/www/portfolio/docker`:

```bash
docker compose -f docker/compose.yaml up --build
```

Aplicação: `http://localhost:5101`; Vite: `http://localhost:5102`; PostgreSQL: porta `5433`.

### Testes E2E

O Playwright é executado em um container dedicado, isolado das dependências Node
usadas pelo Vite. Com os serviços de desenvolvimento ativos, execute:

```bash
docker compose -f docker/compose.yaml --profile e2e run --rm playwright
```

O container usa `http://app:8000` na rede Docker; fora dele, `npm run test:e2e`
usa `http://localhost:5101` por padrão.

Para produção, crie `docker/.env` a partir de `docker/.env.example`, defina domínio, `APP_KEY` e senha do banco. Em seguida execute:

```bash
docker compose --env-file docker/.env -f docker/compose.prod.yaml up -d --build
```
