<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
	use HasFactory;

    protected $fillable = [
        'customer_id',
        'device_type',
        'serial_number',
        'price_total',
        'down_payment',
        'remaining_amount',
        'installment_months',
        'start_date',
    ];

	/**
	 * Get the customer that owns the contract.
	 */
	public function customer(): BelongsTo
	{
		return $this->belongsTo(Customer::class);
	}

	/**
	 * Get the payments for the contract.
	 */
	public function payments(): HasMany
	{
		return $this->hasMany(Payment::class);
	}
}
