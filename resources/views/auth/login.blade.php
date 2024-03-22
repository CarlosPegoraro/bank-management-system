<x-guest title="Login">
    <main class="row" style="height: 100vh">
        <div class="col-12 col-sm-4 d-flex flex-column justify-content-center align-items-center">

            {{-- Header with logo image --}}
            <div style="max-width: 200px" class="mb-5">
                <x-logo/>
            </div>

            <!-- Login submission form-->
            <form method="post" action="{{ route('login') }}" class="mb-2">
                {{ csrf_field() }}

                <div class="fs-4 mb-3">{{ __('Login') }}</div>

                <div class="mb-4 @error('email') invalid @enderror" style="min-width: 300px !important">

                    <div class="form-outline">

                        <input id="email"
                            type="email"
                            class="form-control border-top-0 border-start-0 border-end-0 @error('email') is-invalid @enderror"
                            name="email" required autofocus
                            value="{{ old('email') }}"  placeholder="{{ __('E-Mail') }}" />

                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="mb-3 @error('password') invalid @enderror">

                    <div class="form-outline">

                        <input id="password"
                            type="password"
                            class="form-control border-top-0 border-start-0 border-end-0 mb-1 @error('password') is-invalid @enderror"
                            name="password" required
                            placeholder="{{ __('Senha') }}" />

                        <div class="d-flex justify-content-between mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                    aria-describedby="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Lembrar Sessão') }}
                                </label>
                            </div>

                            <a class="small fw-bold text-decoration-none" href="">
                                {{ __('Esqueceu a Senha?') }}
                            </a>

                        </div>

                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="mb-3 d-flex justify-content-center align-items-center mt-4">

                    <button class="btn btn-primary">{{ __('Login') }}</button>

                </div>
            </form>

            <div class="text-center">
                <a class="small fw-500 text-decoration-none" href="{{ route('register') }}">
                    {{ __('Novo Usuario') }}
                </a>
            </div>

        </div>

        {{-- Define background image using inline CSS --}}
        <div class="d-none d-md-block col-sm-8"
            style="background-image: url('{{ asset('img/authBackground.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        </div>
    </main>
</x-guest>
