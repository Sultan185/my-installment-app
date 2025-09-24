<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>إنشاء عميل</title>
	</head>
	<body>
		<h1>إنشاء عميل</h1>
		@if ($errors->any())
			<div>
				<strong>أخطاء:</strong>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<form method="POST" action="{{ route('customers.store') }}">
			@csrf
			<div>
				<label for="name">الاسم</label>
				<input id="name" name="name" type="text" value="{{ old('name') }}" required />
			</div>
			<div>
				<label for="national_id">الرقم القومي</label>
				<input id="national_id" name="national_id" type="text" value="{{ old('national_id') }}" required />
			</div>
			<div>
				<label for="phone">الهاتف</label>
				<input id="phone" name="phone" type="text" value="{{ old('phone') }}" required />
			</div>
			<div>
				<button type="submit">حفظ</button>
				<a href="{{ route('customers.index') }}">إلغاء</a>
			</div>
		</form>
	</body>
</html>
