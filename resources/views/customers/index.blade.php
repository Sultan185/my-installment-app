<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>العملاء</title>
		<style>
			table { border-collapse: collapse; width: 100%; }
			th, td { border: 1px solid #ccc; padding: 8px; }
			nav a, a.button, button { margin-left: 8px; }
		</style>
	</head>
	<body>
		<h1>قائمة العملاء</h1>
		@if (session('status'))
			<div>{{ session('status') }}</div>
		@endif
		<nav>
			<a href="{{ route('home') }}">الرئيسية</a>
			<a href="{{ route('customers.create') }}">إنشاء عميل</a>
		</nav>
		<table>
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
							<a class="button" href="{{ route('customers.edit', $customer) }}">تعديل</a>
							<form method="POST" action="{{ route('customers.destroy', $customer) }}" style="display:inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
								@csrf
								@method('DELETE')
								<button type="submit">حذف</button>
							</form>
						</td>
					</tr>
				@empty
					<tr><td colspan="4">لا توجد بيانات</td></tr>
				@endforelse
			</tbody>
		</table>

		<div style="margin-top:12px;">
			{{ $customers->links() }}
		</div>
	</body>
</html>
