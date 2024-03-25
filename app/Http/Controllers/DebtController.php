<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use DateTime;
use DateInterval;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $debts = $user->debts()->where('finnaly', '>=', now()->format('Y-m-d'))->orderBy('finnaly', 'desc')->get();

        return view('debt.index', compact('debts'));
    }

    public function extract()
    {
        $user = Auth::user();
        $debts = $user->debts()->orderBy('finnaly', 'asc')->get();

        return view('debt.extract', compact('debts'));
    }

    public function create()
    {
        return view('debt.create');
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
        $user->debts()->create($request->except('_token'));
        return redirect()->route('debt.index')
            ->with('toast', [['type' => 'success', 'message' => __('Debt Created successfully')]]);
    }

    public function edit(Debt $debt)
    {
        return view('debt.edit', compact('debt'));
    }

    public function update(Request $request, Debt $debt)
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

        $debt->update($request->except(['_token', '_method']));

        return redirect()->route('debt.index')
            ->with('toast', [['type' => 'success', 'message' => __('Debt Updated successfully')]]);
    }


    public function destroy(Debt $debt)
    {
        $debt->delete();
        return redirect()->route('debt.index')
            ->with('toast', [['type' => 'success', 'message' => __('Debt Deleted successfully')]]);
    }

    public function show(Debt $debt)
    {
        return view('debt.show', compact('debt'));
    }
}
