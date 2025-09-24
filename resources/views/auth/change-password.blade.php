<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>تغيير كلمة المرور</title>
		<link rel="stylesheet" href="/css/app.css">
	</head>
	<body>
		<h1>تغيير كلمة المرور</h1>

		@if (session('status'))
			<div>{{ session('status') }}</div>
		@endif

		@if ($errors->any())
			<div>
				<strong>حدثت أخطاء</strong> في البيانات المُدخلة.
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('password.change') }}">
			@csrf
			<div>
				<label for="current_password">كلمة المرور الحالية</label>
				<input id="current_password" name="current_password" type="password" required />
			</div>
			<div>
				<label for="password">كلمة المرور الجديدة</label>
				<input id="password" name="password" type="password" required />
			</div>
			<div>
				<label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
				<input id="password_confirmation" name="password_confirmation" type="password" required />
			</div>
			<div>
				<button type="submit">تحديث كلمة المرور</button>
			</div>
		</form>
	</body>
</html>
