<?php

namespace Database\Seeders;

use App\Models\TransactionSeries;
use App\Models\User;
use App\Services\RecurrenceService;
use Illuminate\Database\Seeder;

class FinancialDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@example.com')->first();

        if (! $user) {
            return;
        }

        CategorySeeder::seedFor($user);

        $account = $user->accounts()->firstOrCreate(
            ['name' => 'Conta principal'],
            ['type' => 'checking', 'initial_balance' => 4200, 'color' => 'emerald'],
        );
        $reserve = $user->accounts()->firstOrCreate(
            ['name' => 'Reserva de emergência'],
            ['type' => 'investments', 'initial_balance' => 15000, 'color' => 'sky'],
        );
        $card = $user->creditCards()->firstOrCreate(
            ['name' => 'Cartão Nubank'],
            ['brand' => 'Mastercard', 'closing_day' => 25, 'due_day' => 5, 'limit' => 6000, 'color' => 'violet'],
        );

        $categories = $user->categories()->get()->keyBy(fn ($category) => "{$category->type}:{$category->name}");
        $month = now()->startOfMonth();
        $series = [];

        $series[] = $this->series($user, [
            'type' => 'income', 'amount' => 6500, 'description' => 'Salário mensal',
            'merchant' => 'Empresa Exemplo', 'category_id' => $categories['income:Salário']->id,
            'financial_account_id' => $account->id, 'recurrence' => 'monthly',
            'starts_on' => $month->copy()->subMonths(5)->day(5),
        ]);
        $series[] = $this->series($user, [
            'type' => 'income', 'amount' => 250, 'description' => 'Rendimentos da reserva',
            'merchant' => 'Banco', 'category_id' => $categories['income:Investimentos']->id,
            'financial_account_id' => $reserve->id, 'recurrence' => 'monthly',
            'starts_on' => $month->copy()->subMonths(5)->day(1),
        ]);
        $series[] = $this->series($user, [
            'type' => 'expense', 'amount' => 1850, 'description' => 'Aluguel',
            'merchant' => 'Imobiliária Central', 'category_id' => $categories['expense:Moradia']->id,
            'financial_account_id' => $account->id, 'recurrence' => 'monthly',
            'starts_on' => $month->copy()->subMonths(5)->day(8),
        ]);
        $series[] = $this->series($user, [
            'type' => 'expense', 'amount' => 119.90, 'description' => 'Internet residencial',
            'merchant' => 'Vivo Fibra', 'category_id' => $categories['expense:Moradia']->id,
            'financial_account_id' => $account->id, 'recurrence' => 'monthly',
            'starts_on' => $month->copy()->subMonths(5)->day(12),
        ]);
        $series[] = $this->series($user, [
            'type' => 'expense', 'amount' => 74.90, 'description' => 'Assinaturas digitais',
            'merchant' => 'Spotify, Netflix e iCloud', 'category_id' => $categories['expense:Assinaturas']->id,
            'credit_card_id' => $card->id, 'recurrence' => 'monthly',
            'starts_on' => $month->copy()->subMonths(5)->day(5),
        ]);
        $series[] = $this->series($user, [
            'type' => 'expense', 'amount' => 289.90, 'description' => 'Notebook parcelado',
            'merchant' => 'Loja de tecnologia', 'category_id' => $categories['expense:Outros']->id,
            'credit_card_id' => $card->id, 'recurrence' => 'installment', 'installments' => 10,
            'starts_on' => $month->copy()->subMonths(3)->day(5), 'ends_on' => $month->copy()->addMonths(6)->day(5),
        ]);

        foreach (range(0, 5) as $offset) {
            $reference = $month->copy()->subMonths($offset);
            $label = $reference->translatedFormat('m/Y');

            $series[] = $this->series($user, [
                'type' => 'expense', 'amount' => 680 + ($offset * 35), 'description' => "Mercado e feira {$label}",
                'merchant' => 'Supermercado', 'category_id' => $categories['expense:Alimentação']->id,
                'financial_account_id' => $account->id, 'recurrence' => 'one_time',
                'starts_on' => $reference->copy()->day(18),
            ]);
            $series[] = $this->series($user, [
                'type' => 'expense', 'amount' => 180 + (($offset % 3) * 30), 'description' => "Transporte {$label}",
                'merchant' => 'Mobilidade urbana', 'category_id' => $categories['expense:Transporte']->id,
                'credit_card_id' => $card->id, 'recurrence' => 'one_time',
                'starts_on' => $reference->copy()->day(22),
            ]);
        }

        $series[] = $this->series($user, [
            'type' => 'income', 'amount' => 1200, 'description' => 'Projeto freelancer',
            'merchant' => 'Cliente Alpha', 'category_id' => $categories['income:Freelance']->id,
            'financial_account_id' => $account->id, 'recurrence' => 'one_time',
            'starts_on' => $month->copy()->subMonths(1)->day(20),
        ]);
        $series[] = $this->series($user, [
            'type' => 'expense', 'amount' => 240, 'description' => 'Consulta de rotina',
            'merchant' => 'Clínica Saúde', 'category_id' => $categories['expense:Saúde']->id,
            'financial_account_id' => $account->id, 'recurrence' => 'one_time',
            'starts_on' => $month->copy()->subMonths(2)->day(14),
        ]);
        $series[] = $this->series($user, [
            'type' => 'expense', 'amount' => 320, 'description' => 'Fim de semana',
            'merchant' => 'Restaurante e cinema', 'category_id' => $categories['expense:Lazer']->id,
            'credit_card_id' => $card->id, 'recurrence' => 'one_time',
            'starts_on' => $month->copy()->subMonths(1)->day(16),
        ]);

        $recurrence = app(RecurrenceService::class);
        foreach ($series as $item) {
            $recurrence->materialize($item, $month->copy()->addMonths(6)->endOfMonth());
        }

        $user->transactions()
            ->whereIn('transaction_series_id', collect($series)->pluck('id'))
            ->whereDate('due_date', '<', today())
            ->where('status', 'pending')
            ->update(['status' => 'settled', 'settled_at' => today()]);
    }

    /** @param array<string, mixed> $attributes */
    private function series(User $user, array $attributes): TransactionSeries
    {
        return $user->transactionSeries()->firstOrCreate(
            ['description' => $attributes['description']],
            $attributes + ['is_active' => true],
        );
    }
}
