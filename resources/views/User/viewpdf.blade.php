@extends('user.layouts.app')
@section('content')
<style>
    .tab-content {
        display: flex;
        justify-content: center;
    }

    .pdf-table {
        font-family: Arial, sans-serif;
        padding: 20px;
        /* margin: 20px; */
        width: 8.5in;
        height: auto;

        background-color: #f1f5f9;
        border-radius: 10px;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
    }

    .pdf-table .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
        line-height: 25px;
    }

    .logo {
        width: 250px;
        height: 150px;
    }

    .pdf-table .header img {
        width: 300px;
    }

    .pdf-table .company-details {
        text-align: right;
        font-size: 12px;
    }

    .pdf-table .info {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 12px;
    }

    .pdf-table .info-left {
        width: 50%;
    }

    .pdf-table .info-right {
        width: 50%;

        .info p {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .info span {
            display: inline-block;
            width: 180px;
            border-bottom: 1px solid black;
        }
    }

    .pdf-table .line {
        border-top: 4px solid black;
        margin-top: 10px;
    }

    .pdf-table .quotation-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 12px;
    }

    .pdf-table .quotation-table th {
        background-color: #d3d3d3;
        padding: 6px;
        border: 1px solid black;
        text-align: center;
    }

    .pdf-table .quotation-table td {
        padding: 5px;
        border: 1px solid black;
        text-align: center;
    }

    .pdf-table .quotation-header {
        background-color: #034892;
        color: white;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        padding: 6px;
    }

    .pdf-table .terms-section {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .pdf-table .terms {
        width: 60%;
        font-size: 12px;
    }

    .pdf-table .terms h3 {
        font-size: 18px;
        font-weight: bold
    }

    .pdf-table .subtotal-box {
        width: 40%;
        border: 1px solid black;
        font-size: 12px;
        line-height: 15px;
    }

    .pdf-table .approval-section {
        display: flex;
        justify-content: space-evenly;
        text-align: center;
        margin-top: 20px;
        font-size: 12px;
    }

    .pdf-table .approval-section div {
        width: 30%;
    }

    nav {
        background-color: #122444;
    }

    /* USER FILL UP */
    .payment-details {
        background-color: #f1f5f9;
        width: 480px;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
    }

    .payment-details h3 {
        color: #122444;
        font-weight: bold;
    }

    .quote-form-container {
        width: 100%;
        height: auto;
    }

    .quote-form-container h4 {
        color: #112240;
        font-weight: bold;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        color: #112240;
    }

    .payment-details label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .payment-details input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn-container {
        display: flex;
        justify-content: end;
    }

    .payment-details .submit-btn {
        width: 220px;
        background-color: transparent;
        --color: #122444;
        padding: 0.5em 1em;
        border-radius: 999px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: 0.5s;
        font-weight: 600;
        font-size: 15px;
        border: 1px solid;
        color: var(--color);
        z-index: 1;
    }

    .payment-details .submit-btn::before,
    .payment-details .submit-btn::after {
        content: "";
        display: block;
        width: 50px;
        height: 50px;
        transform: translate(-50%, -50%);
        position: absolute;
        border-radius: 50%;
        z-index: -1;
        background-color: var(--color);
        transition: 0.8s ease;
    }

    .payment-details .submit-btn::before {
        top: -1em;
        left: -1em;
    }

    .payment-details .submit-btn::after {
        left: calc(100% + 1em);
        top: calc(100% + 1em);
    }

    .payment-details .submit-btn:hover::before,
    .payment-details .submit-btn:hover::after {
        height: 410px;
        width: 410px;
    }

    .payment-details .submit-btn:hover {
        color: #f1f5f9;
    }

    .payment-details .submit-btn:active {
        filter: brightness(1);
    }

    /* END OF USER FILL UP */
</style>







{{--
<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image" style=" background-image: url('/storage/{{ $contents['Payment-background']->value ?? ''}}');">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['Payment-title']->value ?? '' }}</h1>
                        <p>{{ $contents['Payment-tagline']->value ?? '' }}</p>
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
<!-- END OF HEADER --> --}}


<!-- CONTENTS -->

<section id="contents">
    <form action="{{ route('SubmitQuotationRequest') }}" method="POST" style="margin-top: 100px">
        @csrf

        @php
        $rate = $quotationData['rate'] ?? 0;
        $quantity = $quotationData['hours'] ?? $quotationData['qty'] ?? 0;
        $totalPrice = $rate * $quantity;
        $rateFormatted = number_format($rate, 2);
        $subtotal = $totalPrice + ($quotationData['individual'] ?? 0);
        @endphp
        <input type="hidden" name="service_id" value="{{ $quotationData['service_id'] }}">
        <input type="hidden" name="service_type" value="{{ $quotationData['service_type'] }}">
        <input type="hidden" name="service_name" value="{{ $quotationData['service_name'] }}">
        <input type="hidden" name="rate_type" value="{{ $quotationData['rate_type'] }}">
        <input type="hidden" name="rate" value="{{ $quotationData['rate'] }}">
        <input type="hidden" name="hours" value="{{ $quotationData['hours'] ?? 0 }}">
        <input type="hidden" name="qty" value="{{ $quotationData['qty'] ?? 0 }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        <input type="hidden" name="individual_base" value="{{ $quotationData['individual_base'] ?? 0 }}">
        <input type="hidden" name="individual" value="{{ $quotationData['individual'] ?? 0 }}">
        <input type="hidden" name="guest" value="{{ $quotationData['guest'] ?? 0 }}">
        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
        <input type="hidden" name="date" value="{{ $quotationData['date'] ?? 0 }}">
        <input type="hidden" name="start_time" value="{{ $quotationData['start_time'] ?? 0 }}">
        <input type="hidden" name="end_time" value="{{ $quotationData['end_time'] ?? 0 }}">


        <div class="container content-container">
            <!-- Tab Content -->
            <div class="d-flex gap-3 tab-content">

                <section class="my-5 pdf-table shadow-sm">
                    <div class="header">
                        <div class="logo">
                            <img src="{{asset('/images/logo/inspire-logo-black.png')}}" alt="INSPIRE Sports Academy" />
                        </div>

                        <div class="company-details">
                            <strong>NU SPORTS ACADEMY, INC.</strong><br />
                            NU Laguna, KM 53 Pan Philippine Highway<br />
                            Brgy. Milagrosa, Calamba City 4027<br />
                            NON-VAT: 009-697-538-000<br />
                            <strong>Email:</strong> jdperez@inspire-sportsacademy.com
                            <strong>Phone:</strong> 0939-986-4897<br />
                            <strong>Website:</strong> www.inspiresportsacademy.ph
                        </div>
                    </div>

                    <div class="line"></div>

                    {{-- <div class="info">
                        <div class="info-left">
                            <p><strong>Quotation No.:</strong></p>
                            <p><strong>Event Start:</strong></p>
                            <p><strong>Event End:</strong></p>
                        </div>
                        <div class="info-right">
                            <p><strong>Quotation No.:</strong></p>
                            <p><strong>Quotation Date:</strong></p>
                            <p><strong>Quote Validity:</strong></p>
                        </div>
                    </div> --}}

                    <table class="quotation-table">
                        <tr>
                            <td colspan="5" class="quotation-header">QUOTATION</td>
                        </tr>
                        <tr>
                            <th style="text-transform: uppercase">{{ $quotationData['service_type'] }}</th>
                            <th>DESCRIPTION</th>
                            <th>HOURS/QTY</th>
                            <th>UNIT PRICE</th>
                            <th>AMOUNT</th>
                        </tr>
                        <tr>

                            <td>{{ $quotationData['service_name'] }}</td>
                            <td>{{ $quotationData['rate_type'] }}</td>
                            <td>
                                @if($quotationData['hours'])
                                {{ $quotationData['hours'] }} Hours
                                @else
                                {{ $quotationData['qty'] }} Pax
                                @endif
                            </td>
                            <td>₱{{ $rateFormatted }}</td>
                            <td>₱{{ number_format($totalPrice, 2) }}</td>
                        </tr>

                        @if (isset($quotationData['individual']) && $quotationData['individual'] > 0)
                        <tr>
                            <td></td>
                            <td>Individual Rate</td>
                            <td>{{ $quotationData['guest'] }} Pax</td>
                            <td>₱{{ number_format($quotationData['individual_base'], 2) }}</td>
                            <td>₱{{ number_format($quotationData['individual'], 2) }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td colspan="4" style="text-align: right">
                                <strong>Subtotal</strong>
                            </td>
                            <td><strong>₱{{ number_format($subtotal, 2) }}</strong></td>
                        </tr>
                    </table>




                    <div class="terms-section">
                        <div class="terms">
                            <h3>Terms & Conditions</h3>
                            <ol>
                                <li>
                                    The deposit is required to confirm the reservation (50%
                                    non-refundable).
                                </li>
                                <li>
                                    Accepted payment methods: credit/debit cards, bank
                                    transfers, cash.
                                </li>
                                <li>
                                    Remaining 50% balance due 7 days after final billing.
                                </li>
                                <li>
                                    Payment to
                                    <strong>NU SPORTS ACADEMY, INC.</strong>:<br />
                                    {{-- Account No: 0509-1801-9654<br />
                                    Account Name: NU Sports Academy, Inc.<br />
                                    Bank: BDO Unibank, Inc. --}}
                                </li>
                                <li>All fees subject to change based on actual usage.</li>
                                <li>
                                    Send proof of payment to
                                    <strong>jdperez@inspire-sportsacademy.com</strong>.
                                </li>
                                <li>
                                    Late payments incur 3% monthly interest starting the day
                                    after due date.
                                </li>
                                <li>
                                    Cancellation less than 7 days before event: 25%
                                    downpayment fee.
                                </li>
                                <li>Cancellation within 24 hours: 25% downpayment fee.</li>
                                <li>
                                    Re-booking allowed if notified at least 7 days before
                                    original date.
                                </li>
                            </ol>
                        </div>

                        {{-- <div class="subtotal-box">
                            <p><strong>Subtotal:</strong> ₱4,800.00</p>
                            <p><strong>Discount for Facilities (10%):</strong> ₱480.00</p>
                            <p><strong>Sales Tax:</strong> ₱ -</p>
                            <p><strong>Penalty:</strong> ₱ -</p>
                            <p><strong>Cancellation Fee:</strong> ₱ -</p>
                            <hr />
                            <p><strong>Total Amount:</strong> ₱4,320.00</p>
                            <p><strong>Amount Paid:</strong> ₱ -</p>
                            <p><strong>Balance Due:</strong> ₱ -</p>
                        </div> --}}
                    </div>

                    <div class="approval-section">
                        <div>
                            <p><strong>Proposed by:</strong></p>
                            <br />
                            <p>JHANICA D. PEREZ</p>
                            <p>Sales Associate II</p>
                        </div>
                        <div>
                            <p><strong>Recommending Approval:</strong></p>
                            <br />
                            <p>JACQUELINE B. TE</p>
                            <p>Accounting Supervisor</p>
                            <br />
                            <p><strong>CONFORME:</strong></p>
                            <p>Name & Signature of Client Representative</p>
                            <p>Date:</p>
                        </div>
                        <div>
                            <p><strong>Approved by:</strong></p>
                            <br />
                            <p>BENJAMIN F. UICHICO</p>
                            <p>Managing Director</p>
                        </div>
                    </div>
                </section>

                <div class="my-5 payment-details">
                    <h3 class="text-center">User Details</h3>
                    <div class="mt-3 quote-form-container">
                        <div class="user-info">
                            <!-- Event Title -->
                            <div class="mb-3 form-group">
                                <label for="event">Event Title</label>
                                <input type="text" id="event" name="event" placeholder="REQUIRED" required />
                            </div>
                            <!-- Full Name -->
                            <div class="mb-3 form-group">
                                <label for="fullname">Full Name</label>
                                <input type="text" id="fullname" name="fullname" placeholder="REQUIRED" required />
                            </div>

                            <!-- Quoted Date -->
                            <div class="mb-3 form-group">
                                <label for="date">Quoted Date</label>
                                <input type="date" id="date" name="date" placeholder="AUTO FILL"
                                    value="{{  $quotationData['date'] }}" readonly />
                            </div>

                            <!-- Quoted Time Start -->
                            <div class="mb-3 form-group">
                                <label for="time">Time Start</label>
                                <input type="time" id="time" name="time" placeholder="AUTO FILL"
                                    value="{{  $quotationData['start_time'] }}" readonly />
                            </div>

                            <!-- Quoted Time End -->
                            <div class="mb-3 form-group">
                                <label for="time">Time End</label>
                                <input type="time" id="time" name="time" placeholder="AUTO FILL"
                                    value="{{  $quotationData['end_time'] }}" readonly />
                            </div>

                            <!-- Duration -->
                            <div class="mb-3 form-group">
                                <label for="time">Duration</label>
                                <input id="time" name="time" value="{{  $quotationData['hours'] }} Hours" readonly />
                            </div>

                            <!-- Quoted Amount -->
                            <div class="mb-3 form-group">
                                <label for="amount">Quoted Amount</label>
                                <input type="amount" id="amount" name="amount" placeholder="AUTO FILL"
                                    value="{{number_format($subtotal)}}" readonly />
                            </div>
                            @Auth
                            <div class="btn-container">
                                <button class="submit-btn" type="submit">Submit for
                                    Approval</button>
                            </div>
                            @else
                            <div class="btn-container">
                                <button class="submit-btn" type="button"
                                    onclick="window.location.href='/register';">Submit for
                                    Approval</button>
                            </div>


                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </form>

</section>
{{-- <script src="{{asset('js/details.js')}}"></script> --}}
@endsection
@push('css')
<link href="{{ asset('/css/quote-page.css') }}?v={{ time() }}" rel="stylesheet">
@endpush