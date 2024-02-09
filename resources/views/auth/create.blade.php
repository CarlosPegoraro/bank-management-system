<x-layout title="Login">
    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <h1 class="text-primary mb-5">Seu Gerenciador de Contas</h1>
        <form class="p-5  rounded shadow-lg w-25" method="POST" action="{{ route('auth.register') }}">
            @csrf
            <h1 class="text-primary mb-4">Login</h1>
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
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
</x-layout>
