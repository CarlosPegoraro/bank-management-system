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
        $installments = (int) $request->input('installments');
        $dayOfPurchase = new DateTime($request->input('date'));
        if ($dayOfPurchase->format('d') < '27') {
            $installments -= 1;
        }
        $dueInterval = 'P' . $installments . 'M';
        $finnaly = new DateTime($request->input('date'));
        $finnaly->add(new DateInterval($dueInterval));
        $finnalyFormatted = $finnaly->format('Y-m-d');

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
        $installments = (int) $request->input('installments');
        $dayOfPurchase = new DateTime($request->input('date'));
        if ($dayOfPurchase->format('d') < '27') {
            $installments -= 1;
        }
        $dueInterval = 'P' . $installments . 'M';
        $finnaly = new DateTime($request->input('date'));
        $finnaly->add(new DateInterval($dueInterval));
        $finnalyFormatted = $finnaly->format('Y-m-d');

        $request->merge(['finnaly' => $finnalyFormatted]);

        // Update the debt with the new values
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
