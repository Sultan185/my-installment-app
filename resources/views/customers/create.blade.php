@extends('layouts.app')

@section('title', 'إنشاء عميل')

@section('content')
	<div class="card shadow-sm mx-auto" style="max-width:640px;">
		<div class="card-body">
			<h1 class="h4 mb-3">إنشاء عميل</h1>
			@if ($errors->any())
				<div class="alert alert-danger">
					<strong>أخطاء:</strong>
					<ul class="mb-0 mt-2">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<form method="POST" action="{{ route('customers.store') }}" class="row g-3">
				@csrf
				<div class="col-12">
					<label for="name" class="form-label">الاسم</label>
					<input id="name" name="name" type="text" value="{{ old('name') }}" required class="form-control" />
				</div>
				<div class="col-12">
					<label for="national_id" class="form-label">الرقم القومي</label>
					<input id="national_id" name="national_id" type="text" value="{{ old('national_id') }}" required class="form-control" />
				</div>
				<div class="col-12">
					<label for="phone" class="form-label">الهاتف</label>
					<input id="phone" name="phone" type="text" value="{{ old('phone') }}" required class="form-control" />
				</div>
				<div class="d-flex gap-2">
					<button class="btn btn-primary" type="submit">حفظ</button>
					<a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">إلغاء</a>
				</div>
			</form>
		</div>
	</div>
@endsection
