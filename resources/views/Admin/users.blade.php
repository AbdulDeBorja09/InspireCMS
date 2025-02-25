@extends('admin.layouts.app')
@section('content')
<!-- User Us Content -->
<div class="content" id="Contact Us" style="min-height: 100vh">
    <h1>Users</h1>
    <p>Inspire Users.</p>

    <div class="form-container">
        <!-- Table -->
        <h4>Users</h4>
        <div class="table-container">
            <table>

                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Account Age</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $item)
                    @php
                    $createdAt = \Carbon\Carbon::parse($item->created_at);
                    $now = \Carbon\Carbon::now();
                    $years = $createdAt->diff($now)->y;
                    $months = $createdAt->diff($now)->m;
                    $days = $createdAt->diff($now)->d;
                    @endphp
                    <tr>
                        <td class="text-center" style="width: 5%">{{$index + 1}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->lname}}</td>
                        <td>{{$item->fname}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{ $years }} years, {{ $months }} months, {{ $days }} days</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('F j, Y h:m A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
    </div>
</div>

@endsection