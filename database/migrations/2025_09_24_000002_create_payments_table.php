<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('payments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('contract_id')->constrained('contracts')->cascadeOnDelete();
			$table->date('month');
			$table->decimal('amount_due', 12, 2);
			$table->decimal('amount_paid', 12, 2)->default(0);
			$table->timestamp('paid_at')->nullable();
			$table->timestamps();

			$table->unique(['contract_id', 'month']);
			$table->index(['month']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('payments');
	}
};
