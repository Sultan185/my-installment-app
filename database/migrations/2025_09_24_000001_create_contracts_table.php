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
		Schema::create('contracts', function (Blueprint $table) {
			$table->id();
			$table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
			$table->string('device_type');
			$table->string('serial_number')->index();
			$table->decimal('price_total', 12, 2);
			$table->decimal('down_payment', 12, 2)->default(0);
			$table->decimal('remaining_amount', 12, 2);
			$table->unsignedSmallInteger('installment_months');
			$table->date('start_date');
			$table->timestamps();

			$table->index(['customer_id', 'start_date']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('contracts');
	}
};
