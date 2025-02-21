@extends('user.layouts.app')
@section('content')
<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image"
        style=" background-image: url('/storage/{{ $contents['facilities-background']->value ?? '../images/home/bg.png'}}');">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['facilities-title']->value ?? 'Facilities' }}</h1>
                        <p>{{ $contents['facilities-tagline']->value ?? 'Facilities headline' }}</p>
                        <a onclick="history.back()"><button class="btn shadow-none back-btn">
                                <i class="bi bi-arrow-left"></i> Go Back
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END OF HEADER -->

<!-- CONTENTS -->
<section id="contents">
    <div class="container py-5 mb-5 contents-tab">
        <div class="row g-4">
            <!-- CONTENT CARDS -->
            @foreach ($facilities as $item)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card">
                    <img src="{{asset('../storage/'.$item->image1)}}" class="card-img-top" alt="Facility 1" />
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">
                            {{$item->name}}
                        </p>
                        <a href="{{url('../service/'.$item->id)}}" class="btn shadow-none btn-custom">View More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END OF CONTENTS -->
@endsection
@push('css')
<link href="{{ asset('/css/faci-acad.css') }}?v={{ time() }}" rel="stylesheet">
@endpush