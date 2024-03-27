<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="shortcut icon" href="{{ asset('img/logoSlim.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-header />
    <div class="container-fluid">
        {{ $slot }}
        @include('components.toast')
    </div>

    <x-scripts />

</body>

</html>
