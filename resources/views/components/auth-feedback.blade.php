@if ($errors->any())
    <div class="auth-feedback auth-feedback--error" role="alert">
        <p>Revisa los siguientes datos:</p>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <p class="auth-feedback auth-feedback--success" role="status">{{ session('status') }}</p>
@endif
