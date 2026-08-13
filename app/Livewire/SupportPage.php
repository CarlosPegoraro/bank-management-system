<?php

namespace App\Livewire;

use Livewire\Component;

class SupportPage extends Component
{
    public string $search = '';

    /** @return array<int, array<string, mixed>> */
    public function articles(): array
    {
        return [
            ['category' => 'Primeiros passos', 'icon' => '🚀', 'title' => 'Comece por aqui', 'summary' => 'A ordem mais simples para configurar o Cadim.', 'body' => ['Cadastre suas contas e cartões em Contas e Cartões.', 'Revise ou crie suas Categorias para separar entradas e saídas.', 'Registre suas transações. O Dashboard passa a mostrar seus números automaticamente.']],
            ['category' => 'Primeiros passos', 'icon' => '🧭', 'title' => 'Entenda o Dashboard', 'summary' => 'Leia seus principais indicadores sem complicação.', 'body' => ['Receitas e despesas mostram os lançamentos do período selecionado.', 'Saldo atual considera o que já aconteceu; saldo previsto inclui lançamentos futuros.', 'Use o filtro de período para comparar mês, ano ou um intervalo personalizado.']],
            ['category' => 'Transações', 'icon' => '↗', 'title' => 'Registrar uma transação', 'summary' => 'Como lançar uma entrada, saída ou recorrência.', 'body' => ['Clique em + Nova transação e escolha Entrada ou Saída.', 'Preencha valor, descrição, data e a conta ou cartão de origem.', 'Use recorrência para lançamentos mensais e parcelamento para compras divididas.', 'Confirme o pagamento quando ele acontecer para manter o saldo real atualizado.']],
            ['category' => 'Transações', 'icon' => '⇄', 'title' => 'Importar e exportar CSV', 'summary' => 'Mova seus dados para dentro ou fora do sistema.', 'body' => ['Em Transações, clique em Importar CSV e associe cada coluna ao campo correspondente.', 'Para fazer uma cópia ou analisar os dados, use Exportar CSV.', 'Revise os lançamentos importados antes de confirmá-los.']],
            ['category' => 'Contas e cartões', 'icon' => '▣', 'title' => 'Organizar suas contas', 'summary' => 'Cadastre contas, cartões e transferências.', 'body' => ['Adicione contas bancárias com saldo inicial e tipo correto.', 'Cadastre cartões com limite, dia de fechamento e vencimento.', 'Use Nova transferência para mover dinheiro entre duas contas sem criar uma despesa falsa.']],
            ['category' => 'Planejamento', 'icon' => '◎', 'title' => 'Criar um orçamento ou meta', 'summary' => 'Planeje o mês e acompanhe o progresso.', 'body' => ['Orçamentos definem um limite de gastos por categoria ou para todas as despesas.', 'Metas acompanham um valor que você quer alcançar, como reserva de emergência ou viagem.', 'Atualize o progresso da meta sempre que guardar dinheiro.']],
            ['category' => 'Organização', 'icon' => '✦', 'title' => 'Categorias que ajudam', 'summary' => 'Dicas para manter seus relatórios úteis.', 'body' => ['Prefira nomes claros e consistentes, como Moradia, Alimentação e Transporte.', 'Crie categorias separadas para entradas e saídas.', 'Arquive categorias antigas para preservar o histórico sem poluir os novos lançamentos.']],
            ['category' => 'Conta e segurança', 'icon' => '⌑', 'title' => 'Meu perfil e segurança', 'summary' => 'Atualize seus dados e senha.', 'body' => ['Abra seu avatar no canto superior direito para acessar Meu perfil.', 'Mantenha o e-mail atualizado e escolha um ícone para reconhecer sua conta.', 'Troque sua senha periodicamente e nunca compartilhe suas credenciais.']],
        ];
    }

    public function render()
    {
        return view('livewire.support-page', ['articles' => $this->articles()])->layout('layouts.app');
    }
}
