@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
	<div class="card shadow-sm mx-auto" style="max-width: 420px;">
		<div class="card-body">
			<h1 class="h4 mb-3">تسجيل الدخول</h1>

			@if ($errors->any())
				<div class="alert alert-danger">
					<strong>حدثت أخطاء</strong> في البيانات المُدخلة.
					<ul class="mb-0 mt-2">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('login') }}" class="row g-3">
				@csrf
				<div class="col-12">
					<label for="identifier" class="form-label">البريد الإلكتروني أو اسم المستخدم</label>
					<input id="identifier" name="identifier" type="text" value="{{ old('identifier') }}" required autofocus class="form-control" />
				</div>
				<div class="col-12">
					<label for="password" class="form-label">كلمة المرور</label>
					<input id="password" name="password" type="password" required class="form-control" />
				</div>
				<div class="d-flex justify-content-between align-items-center">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
						<label class="form-check-label" for="remember">تذكرني</label>
					</div>
					<button class="btn btn-primary" type="submit">دخول</button>
				</div>
			</form>
		</div>
	</div>
@endsection
