@extends('user.layouts.app')
@section('content')

<!-- HEADER PAGE -->
<section id="image" class="position-relative text-white"
    style="background-image: url('/storage/{{ $contents['top-background']->value ?? '/images/home/bg.png' }}');">
    <div class="image-overlay d-flex align-items-center">
        <div class="container-fluid">
            <div class="row justify-content-center image-text">
                <div class="col-lg-12 col-md-8 text-center text-md-start px-3 px-md-5">
                    {{-- Dsiplay Data with default value --}}
                    <h1>{{ $contents['top-headline']->value ?? '' }}</h1>
                    <p>{{ $contents['top-tagline']->value ?? '' }}
                    </p>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- END OF HEADER PAGE -->

<!-- FACILITY -->
<section id="facility">
    <div class="container mb-3 facility-text text-center">
        <!-- HEADING -->
        <h2> {{ $contents['facility-title']->value ?? '' }}</h2>
        <!-- SUB-HEADING -->
        <p>{{ $contents['facility-tagline']->value ?? '' }}

        </p>
        <!-- VIEW MORE BTN -->
        <a href="facilities.html" class="btn shadow-none view-btn">View More</a>
    </div>

    <div class="facility-container">
        <div class="swiper">
            <div class="swiper-wrapper">

                @foreach($services->concat($services) as $item)
                <div class="swiper-slide">
                    <img src="{{asset('/storage/'. $item->image1)}}" />
                    <div class="facility-title">{{$item->name}}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- END OF FACILITY -->

<!-- ACADEMY -->
<section id="academy">
    <div class="container my-5 academy-box">
        <div class="row academy-content">
            <div class="col-lg-6 col-md-12 col-sm-12 py-5 academy-text">
                <h2>{{ $contents['academy-title']->value ?? '' }}</h2>
                <h1>{{ $contents['academy-headline']->value ?? '' }}</h1>
                <p>{{ $contents['academy-tagline']->value ?? '' }}

                </p>

                <div class="benefits">
                    <div class="row">

                        @php
                        // Decode the JSON value if it exists, otherwise set it as an empty array
                        $benefits = isset($contents['academy-benefits']) ?
                        json_decode($contents['academy-benefits']->value,
                        true) : [];
                        @endphp

                        @if(!empty($benefits))
                        @foreach($benefits as $benefit)
                        <div class="col-md-6">
                            <ul>
                                <li>
                                    <i class="bi bi-check-lg"></i>
                                    {{$benefit}}
                                </li>
                            </ul>
                        </div>
                        @endforeach

                        @endif



                    </div>
                </div>

                <a href="{{url('/Academies')}}" class="btn shadow-none mt-4 join-btn">
                    Join Our Academy
                </a>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 academy-image">

                {{-- Check if there is image --}}
                @if (!empty($contents['academy-background']->value))
                <img class="img-fluid"
                    src="{{ asset('storage/' . $contents['academy-background']->value ?? '/images/academy/image.png') }}"
                    alt="academy-img">
                @else
                {{-- Display default image --}}
                <img class="img-fluid" src="{{ asset('/images/academy/image.png') }}" alt="academy-img">
                @endif

            </div>
        </div>
    </div>
</section>
<!-- END OF ACADEMY -->

<!-- ARTICLES -->
<section id="articles">
    <div class="container my-5 articles-tab">

        <h2>{{ $contents['homearticle-title']->value ?? '' }}</h2>

        <div class="row justify-content-start g-4 articles-box">
            @if(isset($articles) && $articles->isNotEmpty())
            @foreach($articles as $item)
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex">
                <a class="news-card">
                    <img src="{{asset('/storage/'. $item->image)}}" alt="{{$item->title}}" />
                    <div class="meta-info">
                        <span><i class="bi bi-person"></i> {{$item->author}}</span>
                        <span><i class="bi bi-calendar"></i>{{ \Carbon\Carbon::parse($item->date)->format('F j, Y')
                            }}
                        </span>
                    </div>
                    <p class="news-title">
                        {{$item->title}}
                    </p>
                </a>
            </div>
            @endforeach
            @endif


        </div>
        <a href="{{url('/Articles')}}" class="btn shadow-none mt-4 read-btn">
            Read More
        </a>
    </div>
</section>
<!-- END OF ARTICLES -->

<!-- ABOUT -->
<section id="about">
    <div class="container mt-5 py-5 about-box">
        <div class="row about-content">
            <div class="col-lg-6 col-md-12 col-sm-12 about-image">


                {{-- Check if there is image --}}
                @if (!empty($contents['homeabout-background']->value))
                <img class="img-fluid"
                    src="{{ asset('storage/' . $contents['homeabout-background']->value ?? '/images/academy/image.png') }}"
                    alt="About Us Image">
                @else
                {{-- Display default image --}}
                <img src="{{asset('/images/about/image.png')}}" alt="About Us Image" class="img-fluid" />
                @endif
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 py-5 academy-text">
                <h2> {{ $contents['homeabout-title']->value ?? '' }}</h2>
                <h1>{{ $contents['homeabout-headline']->value ?? '' }}</h1>
                <hr style="
                  border: 1px solid #64748b;
                  opacity: 1;
                  width: 30%;
                  float: left;
                  margin-top: 5px;
                " />
                <br />
                <p>{{ $contents['homeabout-tagline']->value ?? '' }}

                </p>

                <a href="{{url('/About')}}" class="btn shadow-none read-btn mt-4">
                    Read More
                </a>
            </div>
        </div>
    </div>
</section>
<!-- END OF ABOUT -->


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="js/swiper-about.js"></script>
@endsection
@push('css')
<link href="{{ asset('/css/styles.css') }}?v={{ time() }}" rel="stylesheet">
@endpush