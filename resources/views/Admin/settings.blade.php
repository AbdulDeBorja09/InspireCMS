@extends('admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<div class="content" id="settings">
    <h1>Settings</h1>
    <p>Manage your account settings.</p>

    <div class="form-container">
        <h4>Security</h4>
        <form action="{{ route('admin.ChangePassword') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="old_password">Enter old password:</label>
                <input type="password" id="old_password" name="old_password" placeholder="Enter old password" />
            </div>
            <div class="form-group">
                <label for="new_password">Enter new password:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" />
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Change Password
                </button>
            </div>
        </form>

    </div>
</div>
</div>
@endsection