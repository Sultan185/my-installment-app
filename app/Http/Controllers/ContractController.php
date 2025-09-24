<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function create(Request $request)
    {
        $customerId = $request->query('customer');
        $customer = $customerId ? Customer::find($customerId) : null;
        return view('contracts.create', compact('customer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'device_type' => ['required', 'string', 'max:255'],
            'serial_number' => ['required', 'string', 'max:255'],
            'price_total' => ['required', 'numeric', 'min:0'],
            'down_payment' => ['nullable', 'numeric', 'min:0'],
            // remaining_amount computed server-side
            'installment_months' => ['required', 'integer', 'min:1'],
            // 'start_date' => ['required', 'date'],
        ]);

        $priceTotal = (float) $validated['price_total'];
        $downPayment = (float) ($validated['down_payment'] ?? 0);
        $remainingAmount = max(0, $priceTotal - $downPayment);

        $payload = $validated;
        $payload['remaining_amount'] = $remainingAmount;
        // date now()
        $payload['start_date']= now();
        Contract::create($payload);

        return redirect()
            ->route('customers.show', $validated['customer_id'])
            ->with('status', 'تم إنشاء العقد بنجاح');
    }
}
