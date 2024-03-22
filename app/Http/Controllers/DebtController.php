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
        $installments = 'P' . $request->input('installments') . 'M';
        $dayOfPurchase = new DateTime($request->input('date'));
        $dayOfMonth = $dayOfPurchase->format('d');

        // If the purchase is made on or before the 29th, start counting months from the 5th of the current month
        // If made after the 29th, start counting months from the 5th of the next month
        if ($dayOfMonth <= 29) {
            // Set the final date to the 5th of the current month
            $finnaly = new DateTime($dayOfPurchase->format('Y-m-05'));
        } else {
            // Set the final date to the 5th of the next month
            $finnaly = new DateTime($dayOfPurchase->format('Y-m-05'));
            $finnaly->add(new DateInterval('P1M'));
        }

        $finnaly->add(new DateInterval($installments));
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

    public function update(Request $request, $id)
    {
        $debt = Debt::findOrFail($id); // Retrieve the debt to be updated

        $installments = 'P' . $request->input('installments') . 'M';
        $dayOfPurchase = new DateTime($request->input('date'));
        $dayOfMonth = $dayOfPurchase->format('d');

        // Replicate the logic for calculating "finnaly"
        if ($dayOfMonth <= 29) {
            $finnaly = new DateTime($dayOfPurchase->format('Y-m-05'));
        } else {
            $finnaly = new DateTime($dayOfPurchase->format('Y-m-05'));
            $finnaly->add(new DateInterval('P1M'));
        }
        $finnaly->add(new DateInterval($installments));
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
