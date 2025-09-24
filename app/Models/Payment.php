<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
	use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contract_id',
        'month',
        'amount_due',
        'amount_paid',
        'paid_at',
    ];

	/**
	 * Get the contract that owns the payment.
	 */
	public function contract(): BelongsTo
	{
		return $this->belongsTo(Contract::class);
	}

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'month' => 'date',
		'paid_at' => 'datetime',
	];
}
