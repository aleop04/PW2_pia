@if (session('success'))
    <p class="flow-feedback flow-feedback--success" role="status">{{ session('success') }}</p>
@endif
@if ($errors->any())
    <div class="flow-feedback flow-feedback--error" role="alert">
        <p>Revisa estos datos:</p>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif
