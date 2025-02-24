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
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $item)
                    <tr>
                        <td class="text-center" style="width: 5%">{{$index + 1}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->lname}}</td>
                        <td>{{$item->fname}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
    </div>
</div>

@endsection