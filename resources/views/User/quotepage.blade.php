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
                <img id="mainImage" src="{{asset('/storage/'. $service->image1)}}" alt="Expert Trainer"
                    class="content-image" />

                <div class="row mt-3">
                    <div class="col-3">
                        <img src="{{asset('/storage/'. $service->image1)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>

                    <div class="col-3">
                        <img src="{{asset('/storage/'. $service->image2)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>

                    <div class="col-3">
                        <img src="{{asset('/storage/'. $service->image3)}}" class="thumb-image"
                            onclick="changeImage(this)" />
                    </div>

                    <div class="col-3">
                        <img src="{{asset('/storage/'. $service->image4)}}" class="thumb-image"
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
                @php
                $rates = $rates->sortByDesc(function($item) {
                return Str::contains(strtolower($item->rate_type), 'individual') ? 1 : 0;
                });
                @endphp

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
                    <form action="{{route('CreateQuotation')}}" method="POST" onsubmit="return validateForm()">
                        @csrf
                        <h4>Request Quotation</h4>
                        <input type="hidden" name="service_id" value="{{$service->id}}">
                        <input type="hidden" name="service_type" value="{{$service->type}}">
                        <input type="hidden" name="service_name" value="{{$service->name}}">
                        <!-- Rate Selector -->
                        <select id="rateSelector" name="rate_type" required>
                            <option disabled selected value="">Select a Rate</option>
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
                        <button class="modal-date-btn" type="button" onclick="ViewCalendar({{$service}})">Select
                            Date</button>
                        <input type="number" name="guests" placeholder="Enter Guests" required />

                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <input type="hidden" id="datessssss" class="form-control"
                                                    placeholder="Start Time"
                                                    style="height: 0px; padding:0; margin:0; background-color:#f1f5f9;"
                                                    readonly>
                                                <!-- Visible Inputs for Start and End -->

                                                <div class="flex-box">
                                                    <h1 style="margin-top: 65px; font-size: 23px">Select Reservation
                                                        Date
                                                    </h1>
                                                    <input type="text" id="start_date" class="form-control" name="date"
                                                        placeholder="Start Date" readonly required>
                                                    <input type="text" id="start_time" class="form-control"
                                                        name="start_time" placeholder="Start Time" readonly required>
                                                    <input type="text" id="end_time" class="form-control"
                                                        name="end_time" placeholder="End Time" readonly required>

                                                </div>

                                                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

                                                <script src="{{asset('/js/calendar.js')}}"></script>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12" id="View_calendar"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="close-btn" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="confirm-btn" id="CheckBtn">Confirm</button>
                                        <script>
                                            document.getElementById("CheckBtn").addEventListener("click", function (e) {
                                            // Validate before closing the modal
                                            if (validateForm()) {
                                                let modalEl = document.getElementById("staticBackdrop");
                                                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                                                if (modalInstance) {
                                                    modalInstance.hide();
                                                } else {
                                                    modalInstance = new bootstrap.Modal(modalEl);
                                                    modalInstance.hide();
                                                }
                                            } else {
                                                e.preventDefault();
                                            }
                                        });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
            if (document.getElementById('View_calendar')) {
                initializeCalendar([]);
            }
        });

        function initializeCalendar(blockedDates) {
            var calendarEl = document.getElementById('View_calendar');

                if (!calendarEl) {
                    console.error("Error: Calendar element not found!");
                    return;
                }

                // Destroy existing calendar instance if it exists
                if (calendarEl._calendar) {
                    calendarEl._calendar.destroy();
                }
                var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: blockedDates.map(date => {
                    return {
                        title: `(${moment(date.start_date).format('hh:mm A')} - ${moment(date.end_date).format('hh:mm A')})`, 
                        start: moment(date.start_date).toISOString(),  
                        end: moment(date.end_date).toISOString(), 
                        color: '#064e3b',
                        backgroundColor: '#122444',
                        allDay: false
                    };
                }),
                eventDidMount: function(info) {
                    info.el.style.whiteSpace = 'normal';
                    info.el.style.display = 'block'; 
                },
                eventContent: function(arg) {
                    return { html: arg.event.title };
                }
        });

        calendarEl._calendar = calendar;
        calendar.render();
    }

    function ViewCalendar(Item) {


        $.ajax({
            url: "/User/Request/Dates/api",  // Directly use the route without Blade syntax
            type: 'GET',
            data: { id: Item.id },
            dataType: 'json',
            success: function(response) {
                console.log("Response Data:", response); // Debugging
                if (Array.isArray(response.blocked_dates)) {
                    initializeCalendar(response.blocked_dates);
                } else {
                    console.warn("Blocked dates not an array:", response.blocked_dates);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching quotation orders:", error);
            }
        });

        let modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        modal.show();
    }
</script> --}}
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
<link href="{{ asset('/css/quote-single-content-page.css') }}?v={{ time() }}" rel="stylesheet">
@endpush