<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .nav-link:hover {
            color: #0EC4EC !important;
            text-decoration: none;
        }

        header {
            box-shadow: 0px 2px 15px 0px #25252555;
        }

    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.svg') }}" alt="BMS" style="width: 100px"/>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse w-full" id="navbarNav">
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('debt.extract') }}">{{ __('Shop History') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('card.index') }}">{{ __('Cards') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('analysis.index') }}">{{ __('Analisys Report') }}</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-danger d-sm-none" title="logout">{{ __('Logout') }}</button>
                        <button type="submit" class="nav-link text-danger d-none d-sm-block"
                            title="logout""><i class="bi bi-person fs-4"></i></button>

                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>

</body>
</html>

