<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'national_id',
		'phone',
	];

	/**
	 * Get the contracts for the customer.
	 */
	public function contracts(): HasMany
	{
		return $this->hasMany(Contract::class);
	}
}
