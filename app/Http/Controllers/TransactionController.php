<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->where('finnaly', '>=', now()->format('Y-m-d'))->get();
        return view('transaction.index', compact('transactions'));
    }

    public function create()
    {
        return view('transaction.create');
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
        $user->transactions()->create($request->except('_token'));
        return redirect()->route('transaction.index');
    }
}
