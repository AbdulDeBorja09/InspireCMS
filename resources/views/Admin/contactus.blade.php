@extends('Admin.layouts.app')
@section('content')
<!-- Contact Us Content -->
<div class="content" id="Contact Us" style="min-height: 100vh">
    <h1>Contact Us</h1>
    <p>Manage Messages.</p>

    <div class="form-container">
        <!-- Table -->
        <h4>Contact Us</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        {{-- <th class="text-center">Actions</th> --}}
                        <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $index => $item)
                    <tr>
                        <td class="text-center" style="width: 5%">{{$index + 1}}</td>
                        <td>{{$item->lname}}, {{$item->fname}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->phone}}</td>
                        <td style="width: 40%">{{$item->message}}
                        </td>
                       
                        {{-- <td class="text-center" style="width: 15%">
                            <button class="edit-btn">View</button>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
    </div>
</div>

@endsection