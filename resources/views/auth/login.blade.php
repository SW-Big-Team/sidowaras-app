<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Sign In · Sidowaras POS</title>
	<link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
	<style>
		body { font-family: 'Inter', sans-serif; background: linear-gradient(180deg,#f6fbff 0%, #ffffff 100%); }
		.auth-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
		.auth-card { width: 380px; border-radius: 12px; box-shadow: 0 10px 30px rgba(20,30,60,0.08); }
		.auth-logo { width: 56px; height:56px; border-radius:10px; background: linear-gradient(135deg,#2b8aef,#7be495); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; }
		.muted { color:#69707a; }
		footer.minimal { text-align:center; padding:18px 0; font-size:13px; color:#a3adb8; }

		/* Page-local override for primary button to use Sidowaras green */
		.btn-primary {
			background-color: #1AB262 !important;
			border-color: #17a653 !important;
			color: #ffffff !important;
		}
		.btn-primary:hover, .btn-primary:focus {
			background-color: #15924d !important;
			border-color: #117a3d !important;
		}
	</style>
</head>

<body>
	<div class="auth-wrap">
		<div class="card auth-card p-4">
			<div class="d-flex align-items-center mb-3">
				<div class="auth-logo me-3">SP</div>
				<div>
					<h5 class="mb-0">Sidowaras POS</h5>
					<div class="muted" style="font-size:13px">Sign in to your account</div>
				</div>
			</div>

				{{-- show session status or errors --}}
				@if (session('status'))
				<div class="alert alert-success" role="alert">{{ session('status') }}</div>
				@endif

				@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					<ul class="mb-0">
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif

				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" required autofocus>
						@if ($errors->has('email'))
						<div class="invalid-feedback">{{ $errors->first('email') }}</div>
						@endif
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
						@if ($errors->has('password'))
						<div class="invalid-feedback">{{ $errors->first('password') }}</div>
						@endif
					</div>
					<div class="d-flex justify-content-start align-items-center mb-3">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
							<label class="form-check-label muted" for="remember">Remember me</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary w-100">Sign in</button>
				</form>

			{{-- accounts are created by admin; no signup link --}}
		</div>
	</div>

	<footer class="minimal">© {{ date('Y') }} Sidowaras — Built for speed & clarity.</footer>

	<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
</body>

</html>

