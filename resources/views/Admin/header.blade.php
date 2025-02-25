@extends('Admin.layouts.app')
@section('content')
@include('Admin.components.alert')

<div class="content" id="facilities">
    <h1>Headers</h1>
    <p>Manage Page Headers</p>

    <div class="form-container">
        @include('Admin.components.headersection', ['section' => 'facilities'])
        @include('Admin.components.headersection', ['section' => 'academy'])
        @include('Admin.components.headersection', ['section' => 'articles'])
        @include('Admin.components.headersection', ['section' => 'faq'])
        @include('Admin.components.headersection', ['section' => 'about'])
        @include('Admin.components.headersection', ['section' => 'quotation'])
        @include('Admin.components.headersection', ['section' => 'profile'])
        @include('Admin.components.headersection', ['section' => 'Content'])
        @include('Admin.components.headersection', ['section' => 'article_content'])
        @include('Admin.components.headersection', ['section' => 'Payment'])
    </div>

</div>
@endsection