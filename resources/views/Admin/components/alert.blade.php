<style>
    .alert-container .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 250px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    .alert-container .success {
        background-color: #008444;
    }

    .alert-container .info {
        background-color: #0045aa;
    }

    .alert-container .error {
        background-color: #c60e0e;
    }

    .alert-container .hidden {
        opacity: 0;
        pointer-events: none;
    }

    .alert-container .exit-btn {
        all: unset;
    }
</style>
<div class="alert-container">
    @if(session('success'))
    <div class="alert .succes">
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert">
        <span>{{ session('error') }}</span>
    </div>
    @endif
    @if ($errors->any())
    <div class="alert .error">
        @foreach ($errors->all() as $error)
        <span>{{ $error }}</span>
        @endforeach
    </div>
    @endif
</div>