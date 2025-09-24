<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'month' => ['required', 'date'],
            'amount_paid' => ['required', 'numeric', 'gt:0'],
        ], [
            'month.required' => 'حقل الشهر مطلوب.',
            'month.date' => 'صيغة الشهر غير صحيحة.',
            'amount_paid.required' => 'حقل المبلغ المدفوع مطلوب.',
            'amount_paid.numeric' => 'المبلغ المدفوع يجب أن يكون رقمًا.',
            'amount_paid.gt' => 'المبلغ المدفوع يجب أن يكون أكبر من صفر.',
        ]);

        // Normalize month to first day of month (e.g., 2025-09 -> 2025-09-01)
        $rawMonth = (string) $validated['month'];
        if (preg_match('/^\d{4}-\d{2}$/', $rawMonth) === 1) {
            $normalizedMonth = $rawMonth . '-01';
        } else {
            $normalizedMonth = date('Y-m-01', strtotime($rawMonth));
        }

        // Prevent paying more than the remaining amount on the contract
        $enteredAmount = (float) $validated['amount_paid'];
        $remainingOnContract = (float) $contract->remaining_amount;
        if ($enteredAmount > $remainingOnContract) {
            return back()->withErrors([
                'amount_paid' => 'لا يمكن دفع مبلغ أكبر من المتبقي للعقد (' . number_format($remainingOnContract, 2) . ').',
            ])->withInput();
        }

        // Prevent exceeding the configured number of installments
        $existingPaymentsCount = $contract->payments()->count();
        if ($existingPaymentsCount >= (int) $contract->installment_months) {
            return back()->withErrors(['month' => 'تم الوصول للحد الأقصى لعدد الدفعات لهذا العقد.']);
        }

        // Disallow duplicate month records for same contract
        $existingForMonth = Payment::where('contract_id', $contract->id)
            ->where('month', $normalizedMonth)
            ->first();

        if ($existingForMonth) {
            // Update existing month: add full entered amount
            $toApply = (float) $validated['amount_paid'];
            $currentPaid = (float) ($existingForMonth->amount_paid ?? 0);
            $existingForMonth->amount_paid = $currentPaid + $toApply;
            $existingForMonth->paid_at = now();
            $existingForMonth->save();

            // Decrement contract remaining amount by the applied portion only
            $contract->remaining_amount = max(0, (float) $contract->remaining_amount - $toApply);
            $contract->save();
        } else {
            // Create new payment row for the month using full entered amount
            $toApply = (float) $validated['amount_paid'];

            Payment::create([
                'contract_id' => $contract->id,
                'month' => $normalizedMonth,
                'amount_due' => 0,
                'amount_paid' => $toApply,
                'paid_at' => now(),
            ]);

            $contract->remaining_amount = max(0, (float) $contract->remaining_amount - $toApply);
            $contract->save();
        }

        return redirect()->route('customers.show', $contract->customer_id)
            ->with('status', 'تم تسجيل الدفعة بنجاح');
    }
}


