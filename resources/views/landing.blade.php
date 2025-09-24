<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>الصفحة الرئيسية البسيطة</title>
		<style>
			body { font-family: sans-serif; margin: 24px; }
			nav a { margin-left: 12px; }
		</style>
	</head>
	<body>
		<h1>مرحباً بك</h1>
		<nav>
			@if (Route::has('login'))
				@auth
					<a href="{{ url('/home') }}">الانتقال إلى الرئيسية</a>
				@else
					<a href="{{ route('login.form') }}">تسجيل الدخول</a>
				@endauth
			@endif
		</nav>
	</body>
</html>
