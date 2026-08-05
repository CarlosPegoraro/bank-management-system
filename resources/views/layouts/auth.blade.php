<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadê o Meu Dinheiro?</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="auth-page">{{ $slot }}@livewireScripts</body>
</html>
