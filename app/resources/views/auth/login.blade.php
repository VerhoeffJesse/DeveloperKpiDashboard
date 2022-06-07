<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/FullColor-NoTagline-vierkant.png') }}">
    <title>Inloggen</title>

    <!-- Fonts -->
{{--    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">--}}
    <link href="{{ asset('css/app.css?v=').time() }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

</head>
<body class="antialiased">

<div id="__next">

<div class="login__container">
    <div class="login__left">
        <div><h4 class="login__header">Login</h4>
            <p class="login__paragraph">Log in om toegang te krijgen tot het dashboard.</p></div>
            <form method="POST" class="login__input" action="{{ route('login') }}">
                            @csrf
            <label for="email" > Email</label>
            <input id="email" class="login__input_field" type="email" name="email" required autofocus />

            <label for="password" > Wachtwoord</label>

            <input id="password" class="login__input_field"
                     type="password"
                     name="password"
                      />
            <button type="submit" class="login__input_button">Login</button>

        </form>

    </div>
    <div class="login__right"></div>
</div>
</div>

</body>
</html>


