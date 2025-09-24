@extends('layouts.app')

@section('title', 'تغيير كلمة المرور')

@section('content')
	<div class="card shadow-sm mx-auto" style="max-width: 520px;">
		<div class="card-body">
			<h1 class="h4 mb-3">تغيير كلمة المرور</h1>

			@if (session('status'))
				<div class="alert alert-success">{{ session('status') }}</div>
			@endif

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

			<form method="POST" action="{{ route('password.change') }}" class="row g-3">
				@csrf
				<div class="col-12">
					<label for="current_password" class="form-label">كلمة المرور الحالية</label>
					<input id="current_password" name="current_password" type="password" required class="form-control" />
				</div>
				<div class="col-12">
					<label for="password" class="form-label">كلمة المرور الجديدة</label>
					<input id="password" name="password" type="password" required class="form-control" />
				</div>
				<div class="col-12">
					<label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
					<input id="password_confirmation" name="password_confirmation" type="password" required class="form-control" />
				</div>
				<div class="d-flex justify-content-end gap-2">
					<button type="submit" class="btn btn-primary">تحديث كلمة المرور</button>
					<a href="{{ route('home') }}" class="btn btn-outline-secondary">إلغاء</a>
				</div>
			</form>
		</div>
	</div>
@endsection
