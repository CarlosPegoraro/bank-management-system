<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use DateTime;
use DateInterval;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function extract()
    {
        $user = Auth::user();
        $debts = $user->debts()->orderBy('finnaly', 'asc')->get();

        return view('debt.extract', compact('debts'));
    }

    public function create()
    {
        $cards = Auth::user()->cards;
        return view('debt.create', compact('cards'));
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

        $finnaly = $dayOfPurchase->add(new DateInterval($dueInterval));

        $finnalyFormatted = $finnaly->format('Y-m-d');

        $request->merge(['finnaly' => $finnalyFormatted]);

        $user = Auth::user();
        $user->debts()->create($request->except('_token'));
        return redirect()->route('home')
            ->with('toast', [['type' => 'success', 'message' => __('Debt Created successfully')]]);
    }

    public function edit(Debt $debt)
    {
        $cards = Auth::user()->cards;
        return view('debt.edit', compact('debt', 'cards'));
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

        $finnaly = $dayOfPurchase->add(new DateInterval($dueInterval));

        $finnalyFormatted = $finnaly->format('Y-m-d');

        $request->merge(['finnaly' => $finnalyFormatted]);

        $debt->update($request->except(['_token', '_method']));

        return redirect()->route('home')
            ->with('toast', [['type' => 'success', 'message' => __('Debt Updated successfully')]]);
    }


    public function destroy(Debt $debt)
    {
        $debt->delete();
        return redirect()->route('home')
            ->with('toast', [['type' => 'success', 'message' => __('Debt Deleted successfully')]]);
    }

    public function show(Debt $debt)
    {
        return view('debt.show', compact('debt'));
    }
}
