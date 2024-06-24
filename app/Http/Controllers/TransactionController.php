<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use DateTime;
use DateInterval;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->where('finnaly', '>=', now()->format('Y-m-d'))->orderBy('finnaly', 'desc')->get();

        return view('transaction.index', compact('transactions'));
    }

    public function extract()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->orderBy('finnaly', 'asc')->get();

        return view('transaction.extract', compact('transactions'));
    }

    public function create()
    {
        return view('transaction.create');
    }


    public function store(Request $request)
    {
        $installments = $request->input('installments');
        $dayOfPurchase = new DateTime($request->input('date'));

        if ($dayOfPurchase->format('d') < 27) {
            $dueInterval = 'P' . ($installments - 1) . 'M';
        } else {
            $dueInterval = 'P' . $installments . 'M';
        }

        $dayOfPurchase->modify('first day of next month');
        $dayOfPurchase->modify('+4 days');

        // Calcular a data final
        $finnaly = $dayOfPurchase->add(new DateInterval($dueInterval));

        // Formatar a data final
        $finnalyFormatted = $finnaly->format('Y-m-d');

        // Salvar a data final na requisição
        $request->merge(['finnaly' => $finnalyFormatted]);

        $user = Auth::user();
        $user->transactions()->create($request->except('_token'));
        return redirect()->route('transaction.index')
            ->with('toast', [['type' => 'success', 'message' => __('transaction Created successfully')]]);
    }

    public function edit(Transaction $transaction)
    {
        return view('transaction.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $installments = $request->input('installments');
        $dayOfPurchase = new DateTime($request->input('date'));

        if ($dayOfPurchase->format('d') < 27) {
            $dueInterval = 'P' . ($installments - 1) . 'M';
        } else {
            $dueInterval = 'P' . $installments . 'M';
        }

        $dayOfPurchase->modify('first day of next month');
        $dayOfPurchase->modify('+4 days');

        // Calcular a data final
        $finnaly = $dayOfPurchase->add(new DateInterval($dueInterval));

        // Formatar a data final
        $finnalyFormatted = $finnaly->format('Y-m-d');

        // Salvar a data final na requisição
        $request->merge(['finnaly' => $finnalyFormatted]);

        $transaction->update($request->except(['_token', '_method']));

        return redirect()->route('transaction.index')
            ->with('toast', [['type' => 'success', 'message' => __('transaction Updated successfully')]]);
    }


    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transaction.index')
            ->with('toast', [['type' => 'success', 'message' => __('transaction Deleted successfully')]]);
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.show', compact('transaction'));
    }
}
