@extends('user.layouts.app')
@section('content')
<style>
    .tab-content {
        display: flex;
        justify-content: center;
    }

    .pdf-table {
        font-family: Arial, sans-serif;
        margin: 20px;
        width: 8.5in;
        height: max-content;
        background-color: white
    }

    .pdf-table .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .pdf-table .header img {
        width: 180px;
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
        padding-left: 50px;

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
        border-top: 2px solid black;
        margin-top: 5px;
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
        background-color: #0056b3;
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
        font-size: 11px;
    }

    .pdf-table .subtotal-box {
        width: 35%;
        border: 1px solid black;
        padding: 6px;
        font-size: 12px;
    }

    .pdf-table .approval-section {
        display: flex;
        justify-content: space-around;
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
        <div class="container py-5 mb-5 content-container">
            <!-- Tab Content -->
            <div class="tab-content mt-4" style="min-height: 50vh">

                <section class="pdf-table shadow-sm p-5">
                    <div class="header">
                        <img src="{{asset('../images/logo/inspire-logo.png')}}" alt="INSPIRE Sports Academy" />
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


                    <p>
                        <em>* The first 150 spectators will be admitted free of charge.</em>
                    </p>
                    <p>
                        <em>** For any additional attendees beyond 150, there will be a 50
                            pesos per head admission fee.</em>
                    </p>

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
            </div>
            <hr>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-success w-50 btn-quote m-5"> SUBMIT</button>
            </div>
        </div>

        </div>

    </form>

</section>
{{-- <script src="{{asset('js/details.js')}}"></script> --}}
@endsection
@push('css')
<link href="{{ asset('../css/quote-page.css') }}?v={{ time() }}" rel="stylesheet">
@endpush