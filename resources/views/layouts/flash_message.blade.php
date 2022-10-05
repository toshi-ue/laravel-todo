@if (session('success'))
    <div class="flash_message alert alert-success">
        <p>{{ session('success') }}</p>
    </div>
@endif
@if (session('notice'))
<div class="flash_message alert alert-notice">
    <p>{{ session('notice') }}</p>
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
