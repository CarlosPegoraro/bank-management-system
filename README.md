# Verde Finanças

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

Para validar: `php artisan test` e `npm run build`.

## Docker

O ambiente de desenvolvimento segue o padrão dos projetos em `/var/www/portfolio/docker`:

```bash
docker compose -f docker/compose.yaml up --build
```

Aplicação: `http://localhost:5101`; Vite: `http://localhost:5102`; PostgreSQL: porta `5433`.

Para produção, crie `docker/.env` a partir de `docker/.env.example`, defina domínio, `APP_KEY` e senha do banco. Em seguida execute:

```bash
docker compose --env-file docker/.env -f docker/compose.prod.yaml up -d --build
```
