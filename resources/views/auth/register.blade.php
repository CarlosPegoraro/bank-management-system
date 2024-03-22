<x-guest title="Registrar">
    <main class="row" style="height: 100vh">

        {{-- Form container --}}
        <div class="col-12 col-sm-3 d-flex flex-column justify-content-center align-items-center">

            {{-- Header with logo image --}}
            <div style="max-width: 200px" class="mb-5">
                <x-logo/>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1 class="text-primary mb-4">{{ __('New User') }}</h1>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="{{ __('Name') }}" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="{{ __('Email') }}" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="{{ __('Password') }}" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                    <a class="small fw-500 text-decoration-none" href="{{ route('login') }}">
                        {{ __('Do you has a register?') }}
                    </a>
                </div>
            </form>


        </div>

        <div class="d-none d-md-block col-sm-9"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </main>
</x-guest>
