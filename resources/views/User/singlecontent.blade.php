@extends('user.layouts.app')
@section('content')
<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>Name of the Content</h1>
                        <p>This is a template text</p>
                        <button onclick="window.history.back()" class="btn shadow-none back-btn">
                            <i class="bi bi-arrow-left"></i>
                            Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END OF HEADER -->

<!-- SINGLE CONTENT PAGE -->
<section id="contents">
    <div class="container py-5 mb-5">
        <!-- SINGLE CONTENT IMAGES -->
        <div class="row">
            <div class="col-lg-8">
                <img id="mainImage" src="{{asset('../storage/'. $service->image1)}}" alt="Expert Trainer"
                    class="content-image" />

                <div class="row mt-3">
                    <div class="col-3">
                        <img src="{{asset('../storage/'. $service->image1)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>

                    <div class="col-3">
                        <img src="{{asset('../storage/'. $service->image2)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>

                    <div class="col-3">
                        <img src="{{asset('../storage/'. $service->image3)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>

                    <div class="col-3">
                        <img src="{{asset('../storage/'. $service->image4)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>
                </div>

                <!-- SINGLE CONTENT DESCRIPTION -->
                <div class="content-container">
                    <h1>{{$service->name}}</h1>
                    <p>
                        {{$service->description}}
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Pricing -->
                <div class="pricing-card mb-4">
                    <h4 class="fw-bold">Offered Rates</h4>
                    <ul class="list-group list-group-flush">
                        @forEach($rates as $rate)

                        <li class="list-group-item">
                            {{$rate->rate_type}} - <strong style="text-transform: capitalize"> ₱{{$rate->rate}} /
                                {{$rate->unit}}</strong>
                        </li>

                        @endforeach
                    </ul>
                </div>

                <!-- Follow Our Socials -->
                <div class="social-card">
                    <h5 class="fw-bold">Follow Our Socials</h5>
                    <div class="follow-socials">
                        @if ($facebook)
                        <a href="{{$facebook->value}}" target="_blank"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if ($instagram)
                        <a href="{{$instagram->value}}" target="_blank"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if ($tiktok)
                        <a href="{{$tiktok->value}}" target="_blank"><i class="bi bi-tiktok"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- EDIT OF SINGLE CONTENT PAGE -->
<script src="{{asset('js/change-image.js')}}"></script>
@endsection
@push('css')
<link href="{{ asset('/css/single-content-page.css') }}?v={{ time() }}" rel="stylesheet">
@endpush