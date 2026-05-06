<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Показать форму входа
    public function showLogin()
    {
        if (auth()->check()) return redirect('/')->with('info', 'Вы уже вошли в систему');
        return view('auth.login');
    }

    // Обработка входа
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Поле email обязательно',
            'email.email' => 'Введите корректный email',
            'password.required' => 'Введите пароль',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Добро пожаловать, ' . auth()->user()->name);
        }

        return back()->withErrors(['email' => 'Неверный email или пароль'])->onlyInput('email');
    }

    // Показать форму регистрации
    public function showRegister()
    {
        if (auth()->check()) return redirect('/')->with('info', 'Вы уже авторизованы');
        return view('auth.register');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Введите имя',
            'email.required' => 'Введите email',
            'email.email' => 'Неверный формат email',
            'email.unique' => 'Этот email уже зарегистрирован',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен быть не менее 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';
        
        $user = User::create($data);
        Auth::login($user);

        return redirect('/')->with('success', 'Регистрация успешна!');
    }

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }

    // Профиль
    public function profile()
    {
        if (!auth()->check()) return redirect()->route('login')->with('error', 'Сначала войдите');
        return view('auth.profile', ['user' => auth()->user()]);
    }
}