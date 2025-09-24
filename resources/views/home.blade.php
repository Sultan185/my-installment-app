<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>الرئيسية</title>
		<link rel="stylesheet" href="/css/app.css">
	</head>
	<body>
		<h1>الصفحة الرئيسية</h1>
		<nav>
			<form method="POST" action="{{ route('logout') }}" style="display:inline">
				@csrf
				<button type="submit">تسجيل الخروج</button>
			</form>
			<a href="{{ route('password.change.form') }}">تغيير كلمة المرور</a>
		</nav>

		<div style="margin-top:20px;">
			<a href="{{ route('customers.create') }}">
				<button>إنشاء عميل</button>
			</a>
			<a href="{{ route('contracts.create') }}" style="margin-right:10px;">
				<button>إنشاء عقد</button>
			</a>
		</div>
	</body>
</html>
