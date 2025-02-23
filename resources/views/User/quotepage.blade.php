@extends('user.layouts.app')

@section('content')
<section id="image" class="position-relative text-white">
    <div class="bg-image" style=" background-image: url('/storage/{{ $contents['Content-background']->value ?? ''}}');">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['Content-title']->value ?? '' }}</h1>
                        <p>{{ $contents['Content-tagline']->value ?? '' }}</p>
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
<section id="contents" class="content-page">
    <div class="container my-5 py-5">
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


                <div class="content-container">
                    <h1>{{ $service->name}}</h1>
                    <p>
                        {{ $service->description}}
                    </p>
                </div>
            </div>

            <div class="col-lg-4">


                <!-- Pricing -->
                <div class="pricing-card mb-4">
                    <h4 class="text-center" style="text-transform: uppercase">Offered Rates</h4>
                    <ul class="list-group list-group-flush">
                        @foreach ($rates as $items)
                        <li class="list-group-item">
                            {{$items->rate_type}}
                            <strong><br>₱ {{$items->rate}}
                                @if ($items->unit)
                                / {{$items->unit}}
                                @endif
                            </strong>
                        </li>
                        @endforeach

                    </ul>
                </div>
                <!-- Options -->
                <div class="options-card mb-4">
                    <form action="{{route('CreateQuotation')}}" method="POST">
                        @csrf
                        <h4>Select Your Plan</h4>
                        <input type="hidden" name="service_id" value="{{$service->id}}">
                        <input type="hidden" name="service_type" value="{{$service->type}}">
                        <input type="hidden" name="service_name" value="{{$service->name}}">
                        <!-- Rate Selector -->
                        <select id="rateSelector" name="rate_type" required>
                            <option disabled selected value="">Select a rate</option>
                            @foreach ($rates as $items)
                            @if (!Str::contains(strtolower($items->rate_type), 'individual'))
                            <option value="{{$items->id}}" data-rate="{{ $items->rate }}">
                                {{ $items->rate_type }}
                            </option>
                            @endif
                            @endforeach
                        </select>

                        @if($service->type === 'Facility')
                        <!-- Quantity Input -->
                        <input type="number" name="guests" placeholder="Enter Guests" required />


                        <input type="hidden" id="datessssss" class="form-control" placeholder="Start Time"
                            style="height: 0px; padding:0; margin:0; background-color:#f1f5f9;" readonly>
                        <!-- Visible Inputs for Start and End -->
                        <input type="text" id="start_time_display" class="form-control" name="start_date"
                            placeholder="Start Time" readonly required>
                        <input type="text" id="end_time_display" class="form-control" name="end_date"
                            placeholder="End Time" readonly required>
                        @else
                        <input type="number" name="qty" placeholder="Enter Qty." required />
                        @endif
                        <!-- Total Price -->
                        <div class="total-price" id="totalPrice">₱0.00</div>
                        <!-- Add to Quote Button -->
                        <button id="addToQuote" type="submit" class="btn-quote">
                            Request Quote
                        </button>
                    </form>
                </div>
                <style>
                    /* Style for highlighting blocked dates in red */
                    .flatpickr-day.booked {
                        background: #ff4d4d !important;
                        /* Red background */
                        color: white !important;
                        border-radius: 5px;
                    }

                    /* Style for highlighting fully booked days in black */
                    /* .flatpickr-day.fully-booked {
                        background: rgb(221, 221, 221) !important;
                        color: white !important;
                        border-radius: 5px;
                        cursor: not-allowed;
                    } */
                </style>
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="{{asset('/js/calendar.js')}}"></script>
                <!-- Follow Our Socials -->
                <div class="social-card">
                    <h5 class="fw-bold">Follow Our Socials</h5>
                    <div class="follow-socials">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('rateSelector').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex]; // Get selected option
        let rate = selectedOption.getAttribute('data-rate'); // Get data-rate attribute
        
        if (rate) {
            document.getElementById('totalPrice').textContent = `₱${parseFloat(rate).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
        } else {
            document.getElementById('totalPrice').textContent = "₱0.00";
        }
    });
</script>
<script src="{{asset('js/change-image.js')}}"></script>
@endsection
@push('css')
<link href="{{ asset('../css/quote-single-content-page.css') }}?v={{ time() }}" rel="stylesheet">
@endpush