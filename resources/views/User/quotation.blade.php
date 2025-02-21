@extends('user.layouts.app')
@section('content')
<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>Offered Services</h1>
                        <p>This is a template text</p>
                        <a href="index.html"><button class="btn shadow-none back-btn">
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
    <div class="container py-5 mb-5 content-container">

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="facilities-tab" data-bs-toggle="tab" data-bs-target="#facilities"
                    type="button" role="tab">
                    Facilities
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="academies-tab" data-bs-toggle="tab" data-bs-target="#academies"
                    type="button" role="tab">
                    Academies
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="membership-tab" data-bs-toggle="tab" data-bs-target="#membership"
                    type="button" role="tab">
                    Membership
                </button>
            </li>

            <li class="nav-item ms-auto" role="presentation">
                <button class="nav-link" id="cart" data-bs-toggle="tab" data-bs-target="#cart" type="button" role="tab">
                    <i class="bi bi-cart-fill"></i>
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4" id="myTabContent" style="min-height: 50vh">
            <!-- Facilities Tab -->
            <div class="tab-pane fade show active" id="facilities" role="tabpanel">
                <div class="row g-4">
                    @if(isset($facilities) && $facilities->isNotEmpty())
                    @foreach ($facilities as $facility)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="{{asset('../storage/'.$facility->image1)}}" class="card-img-top"
                                alt="Facility 1" />
                            <div class="card-body">
                                <h5 class="card-title">{{$facility->name}}</h5>
                                <p class="card-text">
                                    {{$facility->name}}
                                </p>
                                <a href="{{url('../service/'.$facility->id)}}" class="btn shadow-none btn-custom">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Academies Tab -->
            <div class="tab-pane fade" id="academies" role="tabpanel">
                <div class="row">
                    @if(isset($academies) && $academies->isNotEmpty())
                    @foreach ($academies as $item)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="{{asset('../storage/'. $item->image1)}}" class="card-img-top" alt="Facility 1">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->name}}</h5>
                                <p class="card-text">
                                    A state-of-the-art gym with top-tier equipment.
                                </p>
                                <a href="{{url('../service/'.$item->id)}}" class="btn shadow-none btn-custom">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Membership Tab -->
            <div class="tab-pane fade" id="membership" role="tabpanel">
                <div class="row">
                    @if(isset($membership) && $membership->isNotEmpty())
                    @foreach ($membership as $item)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="{{asset('../storage/'. $item->image1)}}" class="card-img-top" alt="Facility 1">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->name}}</h5>
                                <p class="card-text">
                                    A state-of-the-art gym with top-tier equipment.
                                </p>
                                <a href="{{url('../service/'.$item->id)}}" class="btn shadow-none btn-custom">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Cart -->
        </div>
    </div>
</section>
{{-- <script src="{{asset('js/details.js')}}"></script> --}}
@endsection
@push('css')
<link href="{{ asset('../css/quote-page.css') }}?v={{ time() }}" rel="stylesheet">
@endpush