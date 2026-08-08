<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $user = $request->user();
        $query = $user->transactions()->with(['category', 'account', 'creditCard'])->orderBy('due_date');
        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(fn ($builder) => $builder->where('description', 'like', "%{$search}%")->orWhere('merchant', 'like', "%{$search}%"));
        }
        if ($request->filled('dateFrom')) {
            $query->whereDate('due_date', '>=', $request->date('dateFrom'));
        }
        if ($request->filled('dateTo')) {
            $query->whereDate('due_date', '<=', $request->date('dateTo'));
        }

        return response()->streamDownload(function () use ($query): void {
            echo "\xEF\xBB\xBF";
            $output = fopen('php://output', 'wb');
            fputcsv($output, ['tipo', 'valor', 'descricao', 'loja', 'data_prevista', 'data_compra', 'status', 'categoria', 'conta', 'cartao', 'observacoes']);
            $query->chunk(250, function ($transactions) use ($output): void {
                foreach ($transactions as $transaction) {
                    fputcsv($output, [$transaction->type, $transaction->amount, $transaction->description, $transaction->merchant, $transaction->due_date->format('Y-m-d'), $transaction->purchase_date?->format('Y-m-d'), $transaction->status, $transaction->category?->name, $transaction->account?->name, $transaction->creditCard?->name, $transaction->notes]);
                }
            });
            fclose($output);
        }, 'transacoes-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
