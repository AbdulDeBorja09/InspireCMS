@extends('admin.layouts.app')
@section('content')
@include('Admin.components.alert')

<div class="content" id="facilities">
    <h1>Headers</h1>
    <p>Manage Page Headers</p>

    <div class="form-container">
        @include('admin.components.headersection', ['section' => 'facilities'])
        @include('admin.components.headersection', ['section' => 'academy'])
        @include('admin.components.headersection', ['section' => 'articles'])
        @include('admin.components.headersection', ['section' => 'faq'])
        @include('admin.components.headersection', ['section' => 'about'])
        @include('admin.components.headersection', ['section' => 'quotation'])
        @include('admin.components.headersection', ['section' => 'profile'])
        @include('admin.components.headersection', ['section' => 'Content'])
        @include('admin.components.headersection', ['section' => 'article_content'])
        @include('admin.components.headersection', ['section' => 'Payment'])
    </div>

</div>
@endsection