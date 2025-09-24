@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h1 class="h4 mb-0">الصفحة الرئيسية</h1>
		<div class="d-flex gap-2">
			<a class="btn btn-outline-secondary" href="{{ route('password.change.form') }}">تغيير كلمة المرور</a>
			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<button type="submit" class="btn btn-danger">تسجيل الخروج</button>
			</form>
		</div>
	</div>

	<div class="row g-3">
		<!-- Search Section -->
		<div class="col-12">
			<div class="card shadow-sm border-0">
				<div class="card-body">
					<h2 class="h6 mb-3">بحث سريع عن عميل</h2>
					<form method="POST" action="{{ route('customers.search') }}" class="row g-2">
						@csrf
						<div class="col-12 col-lg-9">
							<input type="text" name="query" value="{{ old('query') }}" class="form-control form-control-lg" placeholder="أدخل رقم الهاتف أو الرقم القومي" autocomplete="off" required>
						</div>
						<div class="col-12 col-lg-3 d-grid">
							<button type="submit" class="btn btn-primary btn-lg">بحث</button>
						</div>
					</form>
					@if ($errors->has('query'))
						<div class="alert alert-danger mt-2 mb-0">{{ $errors->first('query') }}</div>
					@endif
					@if (session('status'))
						<div class="alert alert-warning mt-2 mb-0">{{ session('status') }}</div>
					@endif
				</div>
			</div>
		</div>

		<!-- Quick Actions -->
		<div class="col-12 col-md-6">
			<div class="card shadow-sm h-100 border-0">
				<div class="card-body d-flex flex-column">
					<h2 class="h5 mb-1">العملاء</h2>
					<p class="text-muted mb-3">إدارة العملاء وإضافة عملاء جدد</p>
					<div class="mt-auto d-flex gap-2">
						<a href="{{ route('customers.create') }}" class="btn btn-primary">إنشاء عميل</a>
						<a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">قائمة العملاء</a>
					</div>
				</div>
			</div>
		</div>
		{{-- <div class="col-12 col-md-6">
			<div class="card shadow-sm h-100 border-0">
				<div class="card-body d-flex flex-column">
					<h2 class="h5 mb-1">العقود</h2>
					<p class="text-muted mb-3">إنشاء وإدارة العقود والأقساط</p>
					<div class="mt-auto">
						<a href="{{ route('contracts.create') }}" class="btn btn-primary">إنشاء عقد</a>
					</div>
				</div>
			</div>
		</div> --}}
	</div>
@endsection
