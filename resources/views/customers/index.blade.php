@extends('layouts.app')

@section('title', 'العملاء')

@section('content')
	<h1 class="h4 mb-3">قائمة العملاء</h1>
    @if (session('status'))
		<div class="alert alert-success">{{ session('status') }}</div>
    @endif
	<nav class="d-flex gap-2 mb-3">
		<a class="btn btn-outline-secondary" href="{{ route('home') }}">الرئيسية</a>
		<a class="btn btn-primary" href="{{ route('customers.create') }}">إنشاء عميل</a>
	</nav>
	<div class="card shadow-sm">
		<table class="table table-hover table-striped mb-0">
			<thead>
				<tr>
					<th>الاسم</th>
					<th>الرقم القومي</th>
					<th>الهاتف</th>
					<th>إجراءات</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($customers as $customer)
					<tr>
						<td>{{ $customer->name }}</td>
						<td>{{ $customer->national_id }}</td>
						<td>{{ $customer->phone }}</td>
						<td>
						<a class="btn btn-sm btn-outline-secondary" href="{{ route('customers.show', $customer) }}">عرض</a>
							<a class="btn btn-sm btn-outline-primary" href="{{ route('customers.edit', $customer) }}">تعديل</a>
							<form method="POST" action="{{ route('customers.destroy', $customer) }}" style="display:inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
								@csrf
								@method('DELETE')
								<button class="btn btn-sm btn-danger" type="submit">حذف</button>
							</form>
						</td>
					</tr>
				@empty
					<tr><td colspan="4">لا توجد بيانات</td></tr>
				@endforelse
			</tbody>
		</table>
	</div>

	<div class="mt-3">
		{{ $customers->links() }}
	</div>
@endsection
