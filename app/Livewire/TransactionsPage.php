<?php

namespace App\Livewire;

use App\Services\RecurrenceService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsPage extends Component
{
    use WithPagination;

    public string $type = '';

    public string $status = '';

    public string $search = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public bool $showForm = false;

    public array $form = [];

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->endOfMonth()->toDateString();
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = ['type' => 'expense', 'amount' => '', 'description' => '', 'merchant' => '', 'category_id' => '', 'financial_account_id' => '', 'credit_card_id' => '', 'due_date' => now()->toDateString(), 'recurrence' => 'one_time', 'installments' => '', 'notes' => ''];
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function save(RecurrenceService $service)
    {
        $d = $this->validate(['form.type' => 'required|in:income,expense', 'form.amount' => 'required|numeric|min:0.01', 'form.description' => 'required|max:255', 'form.merchant' => 'nullable|max:255', 'form.category_id' => 'nullable|exists:categories,id', 'form.financial_account_id' => 'nullable|exists:financial_accounts,id', 'form.credit_card_id' => 'nullable|exists:credit_cards,id', 'form.due_date' => 'required|date', 'form.recurrence' => 'required|in:one_time,monthly,installment', 'form.installments' => 'nullable|required_if:form.recurrence,installment|integer|min:2|max:360', 'form.notes' => 'nullable|max:2000']);
        $f = $d['form'];
        foreach (['category_id', 'financial_account_id', 'credit_card_id'] as $field) {
            $f[$field] = filled($f[$field]) ? (int) $f[$field] : null;
        } if ($f['category_id'] && ! auth()->user()->categories()->whereKey($f['category_id'])->exists()) {
            abort(403);
        } if ($f['financial_account_id'] && ! auth()->user()->accounts()->whereKey($f['financial_account_id'])->exists()) {
            abort(403);
        } if ($f['credit_card_id'] && ! auth()->user()->creditCards()->whereKey($f['credit_card_id'])->exists()) {
            abort(403);
        } if ($f['credit_card_id']) {
            $card = auth()->user()->creditCards()->findOrFail($f['credit_card_id']);
            $purchase = Carbon::parse($f['due_date']);
            $cycle = $purchase->copy()->startOfMonth();
            if ($purchase->day > $card->closing_day) {
                $cycle->addMonth();
            } $due = $cycle->copy()->day(min($card->due_day, $cycle->daysInMonth));
            if ($due->lt($purchase)) {
                $due->addMonth();
            } $f['due_date'] = $due->toDateString();
        } $end = $f['recurrence'] === 'installment' ? Carbon::parse($f['due_date'])->addMonths(((int) $f['installments']) - 1) : null;
        $series = auth()->user()->transactionSeries()->create(array_merge($f, ['starts_on' => $f['due_date'], 'ends_on' => $end, 'installments' => $f['recurrence'] === 'installment' ? $f['installments'] : null]));
        $service->materialize($series);
        $this->showForm = false;
    }

    public function settle($id)
    {
        auth()->user()->transactions()->findOrFail($id)->update(['status' => 'settled', 'settled_at' => today()]);
    }

    public function cancelFuture($id)
    {
        $t = auth()->user()->transactions()->findOrFail($id);
        if ($t->transaction_series_id) {
            $t->series->update(['is_active' => false, 'ends_on' => $t->due_date->copy()->subDay()]);
            auth()->user()->transactions()->where('transaction_series_id', $t->transaction_series_id)->where('status', 'pending')->whereDate('due_date', '>=', $t->due_date)->delete();
        } else {
            $t->delete();
        }
    }

    public function updated($field)
    {
        if (in_array($field, ['type', 'status', 'search', 'dateFrom', 'dateTo'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $q = auth()->user()->transactions()->with(['category', 'account', 'creditCard'])->orderByDesc('due_date');
        if ($this->type) {
            $q->where('type', $this->type);
        } if ($this->status) {
            $q->where('status', $this->status);
        } if ($this->search) {
            $q->where(fn ($x) => $x->where('description', 'ilike', '%'.$this->search.'%')->orWhere('merchant', 'ilike', '%'.$this->search.'%'));
        } if ($this->dateFrom) {
            $q->whereDate('due_date', '>=', $this->dateFrom);
        } if ($this->dateTo) {
            $q->whereDate('due_date', '<=', $this->dateTo);
        }

        return view('livewire.transactions-page', ['transactions' => $q->paginate(12), 'categories' => auth()->user()->categories()->where('is_archived', false)->orderBy('name')->get(), 'accounts' => auth()->user()->accounts()->where('is_archived', false)->get(), 'cards' => auth()->user()->creditCards()->where('is_archived', false)->get()])->layout('layouts.app');
    }
}
