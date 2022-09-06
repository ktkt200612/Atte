@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="css/login.css">
    <header class="header">
        <h1 class = "header__title">Atte</h1>
    </header>
    <div class="container">
        <p class="title">ログイン</p>

        <!-- Session Status -->
        <x-auth-session-status class="errors" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="errors" :errors="$errors" />

        <div class="wrapper">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input class="email" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required autofocus />
                </div>

                <!-- Password -->
                <div>
                    <x-input class="password"
                        type="password"
                        name="password"
                        required autocomplete="current-password" 
                        placeholder="パスワード"/>
                </div>

                <!-- Login -->
                <div>                
                    <x-button class="login">
                        {{ __('ログイン') }}
                    </x-button>
            </form>
        </div>
        <p class="text">アカウントをお持ちでない方はこちらから</p>
        <p class="register"><a href="/register">会員登録</a></p>
        </div>
    </div>
    <footer>
    Atte,inc.
    </footer>
@endsection
