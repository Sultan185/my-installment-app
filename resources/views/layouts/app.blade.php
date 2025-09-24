<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title', 'تطبيق الأقساط')</title>
		@vite(['resources/css/app.css','resources/js/app.js'])
		@stack('head')
	</head>
	<body>
		<div class="container py-4">
			@yield('content')
		</div>
		@stack('scripts')
	</body>
</html>


