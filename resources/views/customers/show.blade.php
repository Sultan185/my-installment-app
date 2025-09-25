@extends('layouts.app')

@section('title', 'تفاصيل العميل')

@section('content')
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h1 class="h4 mb-0">تفاصيل العميل</h1>
		<div class="d-flex gap-2">
			<a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">رجوع</a>
			<a class="btn btn-primary" href="{{ route('contracts.create', ['customer' => $customer->id]) }}">إنشاء عقد</a>
		</div>
	</div>

	<div class="card shadow-sm mb-3">
		<div class="card-body">
			@if (session('status'))
				<div class="alert alert-success mb-3">{{ session('status') }}</div>
			@endif
			@if ($errors->any())
				<div class="alert alert-danger mb-3">
					<ul class="mb-0">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="row g-3">
				<div class="col-12 col-md-4">
					<div class="text-muted">الاسم</div>
					<div class="fw-bold">{{ $customer->name }}</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="text-muted">رقم العميل</div>
					<div class="fw-bold">{{ $customer->customer_number }}</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="text-muted">الرقم القومي</div>
					<div class="fw-bold">{{ $customer->national_id }}</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="text-muted">الهاتف</div>
					<div class="fw-bold">{{ $customer->phone }}</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card shadow-sm">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h2 class="h5 mb-0">العقود</h2>
				@if ($customer->contracts->isNotEmpty())
					<div class="btn-group">
						<button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
							تسجيل دفعة
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							@foreach ($customer->contracts as $contract)
								<li>
									<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $contract->id }}">
										{{ $contract->device_type }} — {{ $contract->serial_number }}
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
			@if ($customer->contracts->isEmpty())
				<p class="text-muted mb-0">لا توجد عقود لهذا العميل.</p>
			@else
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle mb-0">
						<thead>
 							<tr>
								<th>نوع الجهاز</th>
								<th>الرقم التسلسلي</th>
								<th>إجمالي السعر</th>
								<th>المقدم</th>
								<th> المبلغ المتبقي </th>
								<th> عدد الأشهر</th>
								<th> الأشهر المتبقية</th>
								<th>تاريخ البدء</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($customer->contracts as $contract)
								<tr>
									<td>{{ $contract->device_type }}</td>
									<td>{{ $contract->serial_number }}</td>
									<td>{{ number_format($contract->price_total, 2) }}</td>
									<td>{{ number_format($contract->down_payment, 2) }}</td>
									<td>{{ number_format($contract->remaining_amount, 2) }}</td>
								<td>{{ $contract->installment_months }}</td>
								<td>{{ max($contract->installment_months - $contract->payments->count(), 0) }}</td>
							<td>{{ \Carbon\Carbon::parse($contract->start_date)->format('Y-m-d') }}</td>
								</tr>
							<tr>
							<td colspan="8">
									@if ($contract->payments->isNotEmpty())
										<div class="table-responsive mb-3">
											<table class="table table-sm table-bordered">
												<thead>
													<tr>
                                                    <th>الشهر</th>
                                                    <th>المدفوع</th>
														<th>تاريخ الدفع</th>
														<th>اليوم</th>
														<th>الساعة</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($contract->payments as $p)
														<tr>
															<td>{{ \Carbon\Carbon::parse($p->month)->format('Y-m') }}</td>
                                                            <td>{{ number_format($p->amount_paid, 2) }}</td>
															<td>{{ $p->paid_at ? \Carbon\Carbon::parse($p->paid_at)->format('Y-m-d') : '-' }}</td>
															<td>{{ $p->paid_at ? \Carbon\Carbon::parse($p->paid_at)->locale('ar')->dayName : '-' }}</td>
															<td>{{ $p->paid_at ? \Carbon\Carbon::parse($p->paid_at)->format('H:i') : '-' }}</td>
														</tr>
													@endforeach
                                                    <tr class="table-light">
                                                        <td class="fw-bold">الإجمالي</td>
                                                        <td class="fw-bold">{{ number_format($contract->payments->sum('amount_paid'), 2) }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
												</tbody>
											</table>
										</div>
													@endif
													<div class="modal fade" id="paymentModal-{{ $contract->id }}" tabindex="-1" aria-labelledby="paymentModalLabel-{{ $contract->id }}" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="paymentModalLabel-{{ $contract->id }}">تسجيل دفعة</h5>
																	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>
																<form method="POST" action="{{ route('payments.store', $contract) }}">
																	@csrf
																	<div class="modal-body">
																		<div class="mb-3">
																			<label class="form-label">شهر</label>
																			<input type="month" name="month" class="form-control" required>
																		</div>
																		<div class="mb-3">
																			<label class="form-label">المبلغ المدفوع</label>
																	<input type="number" step="0.01" min="0.01" name="amount_paid" class="form-control" placeholder="0.00" required>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
																		<button type="submit" class="btn btn-success">حفظ</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
@endsection


