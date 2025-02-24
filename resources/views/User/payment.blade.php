@extends('user.layouts.app')
@section('content')
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
<!-- PAYMENT -->
<div class="container payment" style="margin-top: 150px">
    <div class="my-5 pdf-container">
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

        <div class="info">
            <div class="info-left d-none">
                <p><strong>Bill to:</strong></p>
                <p><strong>Address & TIN No.:</strong></p>
                <p><strong>Event Date & Title:</strong></p>
                <p><strong>Event Time:</strong></p>
            </div>
            <div class="info-right">
                <p><strong>Quotation No.: {{$quotations->Quotation_ref}}</strong></p>
                <p><strong>Quotation Date: {{ \Carbon\Carbon::parse($quotations->created_at)->format('M d, y')
                        }}</strong></p>
                <p> <strong>Valid Until: {{ \Carbon\Carbon::parse($quotations->created_at)->addDays(7)->format('M d, y')
                        }}</strong></p>
            </div>
        </div>

        <table class="quotation-table">
            <tr>
                <td colspan="5" class="quotation-header">QUOTATION</td>
            </tr>
            <tr>
                <th>FACILITIES</th>
                <th>DESCRIPTION</th>
                <th>HOURS/QTY</th>
                <th>UNIT PRICE</th>
                <th>AMOUNT</th>
            </tr>
            <tr>
                <td>{{$data['service_name']}}</td>
                <td>{{$data['rate_name']}}</td>
                <td>
                    @if($data['total_hours'] > 0)
                    {{$data['total_hours']}} Hours
                    @else
                    {{$data['guest_qty']}} Pax
                    @endif
                </td>
                <td>₱{{number_format($data['rate_value'])}}</td>
                <td>₱{{number_format($data['total_price'])}}</td>
            </tr>
            @if($data['guest_count'] > 0)
            <tr>
                <td></td>
                <td>Individual Rate</td>
                <td>{{ $data['guest_count'] }} Pax</td>
                <td>₱{{ number_format($data['individual_rate'], 2) }}</td>
                <td>₱{{ number_format($data['individual_total'], 2) }}</td>
            </tr>



            @endif
            <tr>
                <td colspan="4" style="text-align: right">
                    <strong>Subtotal</strong>
                </td>
                <td><strong>₱{{number_format($data['subtotal'])}}</strong></td>
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
                <h6><strong>Terms & Conditions</strong></h6>
                <ol>
                    <li>
                        The deposit is required to confirm the reservation (50%
                        non-refundable).
                    </li>
                    <li>
                        Accepted payment methods: credit/debit cards, bank transfers,
                        cash.
                    </li>
                    <li>Remaining 50% balance due 7 days after final billing.</li>
                    <li>
                        Payment to <strong>NU SPORTS ACADEMY, INC.</strong>:<br />
                        Account No: 0509-1801-9654<br />
                        Account Name: NU Sports Academy, Inc.<br />
                        Bank: BDO Unibank, Inc.
                    </li>
                    <li>All fees subject to change based on actual usage.</li>
                    <li>
                        Send proof of payment to
                        <strong>jdperez@inspire-sportsacademy.com</strong>.
                    </li>
                    <li>
                        Late payments incur 3% monthly interest starting the day after
                        due date.
                    </li>
                    <li>
                        Cancellation less than 7 days before event: 25% downpayment fee.
                    </li>
                    <li>Cancellation within 24 hours: 25% downpayment fee.</li>
                    <li>
                        Re-booking allowed if notified at least 7 days before original
                        date.
                    </li>
                </ol>
            </div>

            <div class="subtotal-box ">
                @php

                $discountAmount = ($data['subtotal'] * $quotations->discount) / 100;
                $total = $data['subtotal'] + $quotations->tax + $quotations->penalty + $quotations->Cancellation -
                $discountAmount;
                @endphp
                <div class="px-2 pt-2">
                    <p><strong>Subtotal:</strong> ₱{{number_format($data['subtotal'])}}</p>
                    <p><strong>Discount for Facilities ({{ $quotations->discount}}%):</strong> ₱{{
                        number_format(($data['subtotal'] *
                        $quotations->discount) / 100, 2) }}
                    </p>
                    <p><strong>Sales Tax:</strong> ₱ {{number_format($quotations->tax)}}</p>
                    <p><strong>Penalty:</strong> ₱ {{number_format($quotations->penalty)}}</p>
                    <p><strong>Cancellation Fee:</strong> ₱ {{number_format($quotations->Cancellation)}}</p>
                </div>
                <p style="background-color: #034892; color: white; padding: 5px">
                    <strong>Total Amount: ₱{{ number_format($total, 2) }}</strong>
                </p>
                <div class="px-2">

                    <p><strong>Amount Paid:</strong> ₱ -</p>
                    <p><strong>Balance Due:</strong> ₱ -</p>
                </div>
            </div>
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
    </div>

    <div class="my-5 payment-details">
        <h3 class="text-center">User Details</h3>
        <div class="mt-3 form-container">
            <form class="user-info" action="{{route('SubmitPayment')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$quotations->id}}">
                {{-- @if($quotations->service_type === "Facility")
                <!-- Event Title -->
                <div class="mb-3 form-group">
                    <label for="firstname">Event Title</label>
                    <input type="text" id="firstname" name="title" placeholder="Milo camp" required />
                </div>
                @else

                @endif --}}
                <input type="hidden" id="firstname" name="title" />
                <!-- First Name -->
                <div class="mb-3 form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="fname" placeholder="Anthony" required />
                </div>
                <!-- Last Name -->
                <div class="mb-3 form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lname" placeholder="Jennings" required />
                </div>

                <!-- Address -->
                <div class="mb-3 form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="anthonyjennings@gmail.com" required />
                </div>


                <!-- Email -->
                <div class="mb-3 form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="anthonyjennings@gmail.com" required />
                </div>

                <!-- Phone Number -->
                <div class="mb-3 form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="09123456789" required />
                </div>

                <!-- Payment Plan -->
                <div class="mb-3 form-group">
                    <label for="payment_term">Payment Terms</label>
                    <select name="payment_term" id="payment_term" required>
                        <option value="fullpayment" selected>Full Payment</option>
                        <option value="downpayment">Down Payment</option>
                    </select>
                </div>

                <!-- Proof of Payment -->
                <div class="mb-3 form-group">
                    <label for="imageUpload">Proof of payment</label>
                    <div class="mb-3 image-preview" id="imagePreview">
                        <span>No image selected</span>
                    </div>
                    <input type="file" id="imageUpload" name="image" accept="image/*" required />
                </div>

                <div class="btn-container">
                    <button class="submit-btn" type="submit">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- END OF PAYMENT -->
@endsection
@push('css')
<link href="{{ asset('/css/payment.css') }}?v={{ time() }}" rel="stylesheet">
@endpush