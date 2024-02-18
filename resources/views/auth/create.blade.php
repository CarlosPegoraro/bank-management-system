<x-guest title="Registrar">
    <main class="row" style="height: 100vh">

        {{-- Form container --}}
        <div class="col-12 col-sm-3 d-flex flex-column justify-content-center align-items-center">

            {{-- Header with logo image --}}
            <div>
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" style="max-height: 200px" class="mb-5" />
            </div>

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf
                <h1 class="text-primary mb-4">Novo Usuario</h1>
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha </label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a class="small fw-500 text-decoration-none" href="{{ route('auth.index') }}">
                        {{ __('Possui registro?') }}
                    </a>
                </div>
            </form>


        </div>

        <div class="d-none d-md-block col-sm-9"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </main>
</x-guest>
