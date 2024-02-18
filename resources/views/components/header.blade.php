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
        <a class="navbar-brand" href="{{ route('transaction.index') }}">
            <img src="{{ asset('img/logo.svg') }}" alt="BMS" style="width: 100px"/>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transaction.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transaction.extract') }}">Histórico de Compras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('card.index') }}">Cartões</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('analysis.index') }}">Relatório de Análise</a>
                </li>
                <li class="nav-item rounded-circle px-1 ms-sm-4 w-fit">
                    <a class="nav-link text-danger" title="logout" href="{{ route('auth.logout') }}">Deslogar</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

</body>
</html>

