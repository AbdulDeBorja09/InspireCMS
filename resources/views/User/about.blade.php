@extends('user.layouts.app')
@section('content')

<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image"
        style=" background-image: url('/storage/{{ $contents['about-background']->value ?? '../images/home/bg.png'}}');">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['about-title']->value ?? 'About' }}</h1>
                        <p>{{ $contents['about-tagline']->value ?? 'This is a template text' }}</p>
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

<!-- ABOUT, MISSION, VISION -->
<section id="about">
    <div class="container my-5 py-5">
        <div class="row about-content">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 about-image">
                {{-- Check if there is image --}}
                @if (!empty($contents['aboutus-background']->value))
                <img class="img-fluid"
                    src="{{ asset('storage/' . $contents['aboutus-background']->value ?? '../images/academy/image.png') }}"
                    alt="About Us Image">
                @else
                {{-- Display default image --}}
                <img src="{{asset('../images/about/image.png')}}" alt="About Us Image" class="img-fluid" />
                @endif

            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 about-text">
                <h2> {{ $contents['aboutus-title']->value ?? '' }}</h2>
                <h1> {{ $contents['aboutus-headline']->value ?? '' }}</h1>

                <div class="tab-container">
                    <div class="tab-box">
                        <button class="tab-btn active">About</button>
                        <button class="tab-btn">Contact</button>
                        <button class="tab-btn">Mission</button>
                        <button class="tab-btn">Vision</button>
                        <div class="line"></div>
                    </div>

                    <div class="content-box">
                        <div class="content active">
                            <p>
                                {{ $contents['aboutus-about']->value ?? '' }}
                            </p>
                        </div>

                        <div class="content">
                            <p>
                                {{ $contents['aboutus-contact']->value ?? '' }}
                            </p>
                        </div>

                        <div class="content">
                            <p>
                                {{ $contents['aboutus-mission']->value ?? '' }}
                            </p>
                        </div>

                        <div class="content">
                            <p>
                                {{ $contents['aboutus-vision']->value ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END OF ABOUT, MISSION, VISION -->

<!-- PARTNERSHIPS -->
<section id="partners">
    <div class="container my-5 py-5 text-center">
        <h2 class="mb-4">Our Partners</h2>
        <div class="partners-container">
            <div class="row">
                {{-- Use col-lg-3 if 3 items below --}}
                @if(isset($partners) && $partners->isNotEmpty())
                @foreach($partners as $item)
                <div class="@if($partners->count() >= 2) col-lg-3 @else col-lg-6 @endif col-md-4 col-sm-6 col-12">
                    <div class="image-frame">
                        <img src="{{asset('../storage/' . $item->image)}}" alt="{{$item->name}}" />
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- END OF PARTNERSHIPS -->

<!-- ISA MEMBERS -->
<section id="team">
    <div class="mb-5 pb-5 team-members">
        <h2 class="text-center">Meet the Team</h2>
        <div class="swiper">
            <div class="swiper-wrapper">
                @if(isset($teams) && $teams->isNotEmpty())
                @foreach($teams->concat($teams) as $items)
                <!-- Combine the collection with itself -->
                <div class="swiper-slide">

                    <img src="{{asset('../storage/' . $items->image)}}" alt="{{$items->name}}" />
                    <div class="caption">
                        <h1>{{$items->name}}</h1>
                    </div>
                </div>
                @endforeach
                @endif


                {{-- <div class="swiper-slide">
                    <img src="images/members/Ayra Nicole Pleto - Accommodation Operations_Sales.jpg" alt="" />
                    <div class="caption">
                        <h1>Ayra Nicole Pleto</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="images/members/Christian Laurento Salaveria - High Performance Gym Supervisor, S&C Coach.JPG"
                        alt="" />
                    <div class="caption">
                        <h1>Christian Laurento Salaveria</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="images/members/Jhanica Perez - Sales & Marketing.JPG" alt="" />
                    <div class="caption">
                        <h1>Jhanica Perez</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="images/members/John Paul Patana - Venue Operations and Supply Management.JPG" alt="" />
                    <div class="caption">
                        <h1>John Paul Patana</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="images/members/Katherine_Pardito_-_Sales_&_Marketing.jpg" alt="" />
                    <div class="caption">
                        <h1>Katherine Pardito</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="images/members/Lyzette Marie Rafwel Barolo - Venue Operations and Project Management.jpg"
                        alt="" />
                    <div class="caption">
                        <h1>Lyzette Marie Rafwel Barolo</h1>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>
<!-- END OF ISA MEMBERS -->




<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="js/swiper-about.js"></script>
<script src="{{asset('/js/details-about.js')}}"></script>
@endsection
@push('css')
<link href="{{ asset('/css/about.css') }}?v={{ time() }}" rel="stylesheet">
@endpush