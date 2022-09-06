@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="css/register.css">
    <header class="header">
        <h1 class = "header__title">Atte</h1>
    </header>
    <div class="container">
        <p class="title">会員登録</p>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="errors" :errors="$errors" />

        <div class="wrapper">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-label for="name"/>
                    <x-input type="text" name="name" class="name" :value="old('name')" placeholder="名前"  required autofocus />
                </div>

                <!-- Email Address -->
                <div>
                    <x-label for="email"/>
                    <x-input type="email" name="email" class="email" :value="old('email')" placeholder="メールアドレス"  required />
                </div>

                <!-- Password -->
                <div>
                    <x-label for="password"/>
                    <x-input
                        class="password"
                        type="password"
                        name="password"
                        required autocomplete="new-password" 
                        placeholder="パスワード"  />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-label for="password_confirmation"/>
                    <x-input
                        class="confirm"
                        type="password"
                        name="password_confirmation" required
                        placeholder="確認用パスワード"  />
                </div>

                <x-button class="register">
                    {{ __('会員登録') }}
                </x-button>
            </form>
        </div>
        <p class="text">アカウントをお持ちの方はこちらから</p>
        <p class="login"><a href="{{ route('login') }}">
            {{ __('ログイン') }}</a>  
        </p>              
    </div>
    <footer>
    Atte,inc.
    </footer>
@endsection
