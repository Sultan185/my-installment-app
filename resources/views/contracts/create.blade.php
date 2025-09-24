@extends('layouts.app')

@section('title', 'إنشاء عقد')

@section('content')
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h1 class="h4 mb-0">إنشاء عقد</h1>
		<a class="btn btn-outline-secondary" href="{{ isset($customer) ? route('customers.show', $customer) : route('customers.index') }}">رجوع</a>
	</div>

	<div class="card shadow-sm mx-auto" style="max-width:800px;">
		<div class="card-body">
			@if ($errors->any())
				<div class="alert alert-danger">
					<strong>أخطاء:</strong>
					<ul class="mb-0 mt-2">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('contracts.store') }}" class="row g-3">
				@csrf
				<div class="col-12 col-md-6">
					<label for="customer_id" class="form-label">العميل</label>
					<input type="hidden" name="customer_id" value="{{ old('customer_id', optional($customer)->id) }}" />
					<input id="customer_id" type="text" class="form-control" value="{{ optional($customer)->name ?? 'اختر من صفحة العملاء' }}" readonly />
				</div>
				<div class="col-12 col-md-6">
					<label for="device_type" class="form-label">نوع الجهاز</label>
					<input id="device_type" name="device_type" type="text" value="{{ old('device_type') }}" required class="form-control" />
				</div>
				<div class="col-12 col-md-6">
					<label for="serial_number" class="form-label">الرقم التسلسلي</label>
					<input id="serial_number" name="serial_number" type="text" value="{{ old('serial_number') }}" required class="form-control" />
				</div>
				<div class="col-12 col-md-6">
					<label for="price_total" class="form-label">إجمالي السعر</label>
					<input id="price_total" name="price_total" type="number" step="0.01" value="{{ old('price_total') }}" required class="form-control" />
				</div>
				<div class="col-12 col-md-6">
					<label for="down_payment" class="form-label">المقدم</label>
					<input id="down_payment" name="down_payment" type="number" step="0.01" value="{{ old('down_payment', 0) }}" class="form-control" />
				</div>
				<div class="col-12 col-md-6">
					<label for="remaining_amount" class="form-label">المتبقي</label>
					<input id="remaining_amount" name="remaining_amount" type="number" step="0.01" value="{{ old('remaining_amount') }}" class="form-control" readonly />
				</div>
				<div class="col-12 col-md-6">
					<label for="installment_months" class="form-label">عدد الأشهر</label>
					<input id="installment_months" name="installment_months" type="number" min="1" value="{{ old('installment_months') }}" required class="form-control" />
				</div>
				{{-- <div class="col-12 col-md-6">
					<label for="start_date" class="form-label">تاريخ البدء</label>
					<input id="start_date" name="start_date" type="date" value="{{ old('start_date', now()->format('Y-m-d')) }}" required class="form-control" />
				</div> --}}
				<div class="d-flex gap-2">
					<button type="submit" class="btn btn-primary">حفظ العقد</button>
					<a class="btn btn-outline-secondary" href="{{ isset($customer) ? route('customers.show', $customer) : route('customers.index') }}">إلغاء</a>
				</div>
			</form>
			<script>
				(function(){
					const price = document.getElementById('price_total');
					const down = document.getElementById('down_payment');
					const remaining = document.getElementById('remaining_amount');
					function updateRemaining(){
						const p = parseFloat(price.value || 0);
						const d = parseFloat(down.value || 0);
						const r = Math.max(0, (p - d));
						remaining.value = r.toFixed(2);
					}
					price.addEventListener('input', updateRemaining);
					down.addEventListener('input', updateRemaining);
					updateRemaining();
				})();
			</script>
		</div>
	</div>
@endsection


