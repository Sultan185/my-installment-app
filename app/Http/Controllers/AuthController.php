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
            'identifier' => ['required', 'string'], // الاسم أو البريد
            'password' => ['required', 'string'],
        ], [
            'identifier.required' => 'من فضلك أدخل البريد الإلكتروني أو اسم المستخدم.',
            'password.required' => 'من فضلك أدخل كلمة المرور.',
        ]);

        $identifier = $credentials['identifier'];
        $password = $credentials['password'];

        // التحقق إذا كان البريد أو اسم مستخدم
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($field, $identifier)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors([
                'identifier' => 'بيانات الدخول غير صحيحة.',
            ])->onlyInput('identifier');
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended('/home')->with('status', 'تم تسجيل الدخول بنجاح.');
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
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'password.min' => 'كلمة المرور الجديدة يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors([
                'current_password' => 'كلمة المرور الحالية غير صحيحة.',
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        return back()->with('status', 'تم تحديث كلمة المرور بنجاح.');
    }
}
