<?php

namespace App\Http\Controllers\Backend\Client;

use App\Http\Controllers\Controller;
use App\Models\BillingHistory;
use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $plan = $user->plan;
        $allPlans = Plan::where('price', '>', 0)->get();

        return view('client.backend.checkout.index', compact('user', 'plan', 'allPlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|int|exists:plans,id',
            'bank_name' => 'required',
            'account_holder' => 'required',
            'account_number' => 'required',
        ]);

        $user = Auth::user();
        $newPlan = Plan::find($request->plan_id);

        BillingHistory::create([
            'user_id' => $user->id,
            'plan_Id' => $newPlan->id,
            'payment_date' => now(),
            'total' => $newPlan->price,
            'bank_name' => $request->bank_name,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
        ]);

        $user->plan_id = $request->plan_id;
        $user->current_word_usage = $newPlan->monthly_word_limit;
        $user->save();

        $notification = [
            'type' => 'success',
            'message' => 'Plan upgrade submitted.'
        ];

        return redirect()->route('payment.success')->with($notification);
    }

    public function paymentSuccess()
    {
        return view('client.backend.checkout.payment_success');
    }

    public function invoiceGenerate($id)
    {
        $billing = BillingHistory::with('user', 'plan')->findOrFail($id);

        $pdf = Pdf::loadView('client.backend.checkout.invoice', compact('billing'));

        return $pdf->download('invoice' . $billing->id . '.pdf');


    }
}
