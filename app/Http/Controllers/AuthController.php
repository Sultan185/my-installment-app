<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$credentials = $request->validate([
			'identifier' => ['required', 'string'], // name or email
			'password' => ['required', 'string'],
		]);

		$identifier = $credentials['identifier'];
		$password = $credentials['password'];

		// Determine if identifier is an email; otherwise treat as name
		$field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

		$user = User::where($field, $identifier)->first();
		if (!$user || !Hash::check($password, $user->password)) {
			return back()->withErrors([
				'identifier' => 'Invalid credentials.',
			])->onlyInput('identifier');
		}

		Auth::login($user, $request->boolean('remember'));

		$request->session()->regenerate();

		return redirect()->intended('/home');
	}

	public function logout(Request $request)
	{
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/');
	}

	public function changePassword(Request $request)
	{
		$user = $request->user();
		$request->validate([
			'current_password' => ['required', 'string'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);

		if (!Hash::check($request->input('current_password'), $user->password)) {
			return back()->withErrors([
				'current_password' => 'The provided password does not match our records.',
			]);
		}

		$user->forceFill([
			'password' => Hash::make($request->input('password')),
		])->save();

		return back()->with('status', 'Password updated');
	}
}
