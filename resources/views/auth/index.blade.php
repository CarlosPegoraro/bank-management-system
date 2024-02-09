<x-layout title="Login">
    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <h1 class="text-primary mb-5">Bem vindo de volta</h1>
        <form class="p-5  rounded shadow-lg w-25" method="POST" action="{{ route('auth.login') }}">
            @csrf
            <h1 class="text-primary mb-4">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Lembrar de mim</label>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary">Entrar</button>
                <a href="{{ route('auth.create') }}" class="link">criar conta</a>
            </div>
        </form>
    </div>
</x-layout>
