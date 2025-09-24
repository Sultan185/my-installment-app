<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>تسجيل الدخول</title>
		<link rel="stylesheet" href="/css/app.css">
	</head>
	<body>
		<h1>تسجيل الدخول</h1>

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

		<form method="POST" action="{{ route('login') }}">
			@csrf
			<div>
				<label for="identifier">البريد الإلكتروني أو اسم المستخدم</label>
				<input id="identifier" name="identifier" type="text" value="{{ old('identifier') }}" required autofocus />
			</div>
			<div>
				<label for="password">كلمة المرور</label>
				<input id="password" name="password" type="password" required />
			</div>
			<div>
				<label>
					<input type="checkbox" name="remember" value="1" /> تذكرني
				</label>
			</div>
			<div>
				<button type="submit">دخول</button>
			</div>
		</form>
	</body>
</html>
