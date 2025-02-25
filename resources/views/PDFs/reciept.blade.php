<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{asset('/images/logo/logo.png')}}" type="image/x-icon" />
    <title>Official Receipt</title>
    <style>
        .tab-content {
            display: flex;
            justify-content: center;
        }

        .pdf-table {
            font-family: Arial, sans-serif;
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
        }

        .peso {
            font-family: 'DejaVu Sans', 'Noto Sans', 'Arial Unicode MS', sans-serif;
        }

        .pdf-table .header {
            align-items: center;
            margin-bottom: 5px;
            line-height: 25px;
        }

        .logo {
            width: 250px;
        }

        .pdf-table .header img {
            margin-top: -60px;
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
            line-height: 5px;
        }

        .pdf-table .info-right {
            line-height: 5px;

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
            padding: 0px 2px;
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
            margin-top: 10px;
            display: inline-block;
            vertical-align: top;
        }

        .pdf-table .terms {
            font-size: 12px;
            vertical-align: top;

        }

        .pdf-table .subtotal-box {

            border: 1px solid black;
            font-size: 12px;
            line-height: 10px;
            vertical-align: top;
            padding: 4px;
        }

        .pdf-table .terms h3 {
            font-size: 18px;
            font-weight: bold
        }

        .pdf-table .approval-section {
            display: flex;
            justify-content: space-evenly;
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<section class="pdf-table">
    <div class="header">
        <table style="width: 100% ">
            <tr>
                <td>
                    <img src="{{ public_path('/images/logo/inspire-logo-black.png') }}" alt="Logo">
                </td>
                <td>
                    <div class="company-details">
                        <strong>NU SPORTS ACADEMY, INC.</strong><br />
                        NU Laguna, KM 53 Pan Philippine Highway<br />
                        Brgy. Milagrosa, Calamba City 4027<br />
                        NON-VAT: 009-697-538-000<br />
                        <strong>Email:</strong> jdperez@inspire-sportsacademy.com
                        <strong>Phone:</strong> 0939-986-4897<br />
                        <strong>Website:</strong> www.inspiresportsacademy.ph
                    </div>
                </td>
            </tr>
        </table>


    </div>

    <div class="line"></div>

    <div class="info">
        <table style="width: 100%">
            <tr>
                <td style="width: 50%">
                    <div class="info-left">
                        <p><strong>Bill to: </strong>{{$payment->name}}</p>
                        <p><strong>Address & TIN No.: </strong>{{$payment->address}}</p>
                        <p><strong>Event Date & Title: </strong>{{ \Carbon\Carbon::parse($invoice->date)->format('M
                            d, Y')}}{{$invoice->event_title}}</p>
                        <p><strong>Event Time: </strong>{{$invoice->start_time}} - {{$invoice->end_time}} </p>
                    </div>
                </td>
                <td style="width: 50%">
                    <div class="info-right">
                        <p><strong>Reference No.:</strong> {{$invoice->Quotation_ref}}</p>
                        <p><strong>Quotation Date:</strong> {{ \Carbon\Carbon::parse($invoice->created_at)->format('M
                            d, Y')}}</p>
                        <p><strong>Quote Validity:</strong> {{
                            \Carbon\Carbon::parse($invoice->created_at)->addDays(7)->format('M d, Y')
                            }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="quotation-table">
        <tr>
            <td colspan="5" class="quotation-header">QUOTATION</td>
        </tr>
        <tr>
            <th>FACILITIES</th>
            <th>DESCRIPTION</th>
            <th style="width: 5%">HOURS/QTY</th>
            <th style="width: 15%">UNIT PRICE</th>
            <th style="width: 10%">AMOUNT</th>
        </tr>
        <tr>
            <td>{{$item['service_name']}}</td>
            <td>{{$item['rate_name']}}</td>
            <td>
                @if($item['total_hours'] > 0)
                {{$item['total_hours']}} Hours
                @else
                {{$item['guest_qty']}} Pax
                @endif
            </td>
            <td><span class="peso">&#8369;</span>{{number_format($item['rate_value'])}}</td>
            <td><span class="peso">&#8369;</span>{{number_format($item['total_price'])}}</td>

        </tr>
        @if($item['guest_count'] > 0)
        <tr>
            <td></td>
            <td>Individual Rate</td>
            <td>{{ $item['guest_count'] }} Pax</td>
            <td><span class="peso">&#8369;</span>{{ number_format($item['individual_rate'], 2) }}</td>
            <td><span class="peso">&#8369;</span>{{ number_format($item['individual_total'], 2) }}</td>
        </tr>



        @endif
        <tr>
            <td colspan="4" style="text-align: right">
                <strong>Subtotal</strong>
            </td>
            <td><span class="peso">&#8369;</span> <strong> {{number_format($item['subtotal'])}}</strong></td>
        </tr>
    </table>


    <div class="terms-section">
        <table>
            <tr>
                <td>
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
                </td>
                <td>
                    <div class="subtotal-box" style="margin-left: 18px; width: 100%">
                        @php

                        $discountAmount = ($item['subtotal'] * $invoice->discount) / 100;
                        $total = $item['subtotal'] + $invoice->tax + $invoice->penalty + $invoice->Cancellation -
                        $discountAmount;
                        @endphp
                        <p><strong>Subtotal: </strong><span class="peso">&#8369;</span>
                            {{number_format($item['subtotal'])}}</p>

                        <p><strong>Discount for Facilities ({{ $invoice->discount}}%): </strong><span
                                class="peso">&#8369;</span>{{
                            number_format(($item['subtotal'] *
                            $invoice->discount) / 100, 2) }}</p>

                        <p><strong>Sales Tax: </strong> <span
                                class="peso">&#8369;</span>{{number_format($invoice->tax)}}
                        </p>

                        <p><strong>Penalty: </strong> <span
                                class="peso">&#8369;</span>{{number_format($invoice->penalty)}}
                        </p>

                        <p><strong>Cancellation Fee: </strong> <span
                                class="peso">&#8369;</span>{{number_format($invoice->Cancellation)}}</p>

                        <hr />
                        <p><strong>Total Amount: </strong> <span class="peso">&#8369;</span>{{number_format($total)}}
                        </p>

                        <p><strong>Amount Paid: </strong><span
                                class="peso">&#8369;</span>{{number_format($payment->total)}}</p>
                        <p><strong>Balance Due: </strong> <span class="peso">&#8369;</span> -</p>
                    </div>
                </td>
            </tr>
        </table>



    </div>

    <div class="approval-section">
        <table style="width: 100%">
            <tr>
                <td style="text-align: center; width: 30%">
                    <div>
                        <p><strong>Proposed by:</strong></p>
                        <br />
                        <p>JHANICA D. PEREZ</p>
                        <p>Sales Associate II</p>
                    </div>
                </td>
                <td style="text-align: center; width: 30%">
                    <p><strong>Recommending Approval:</strong></p>
                    <br />
                    <p>JACQUELINE B. TE</p>
                    <p>Accounting Supervisor</p>
                </td>
                <td style="text-align: center; width: 30%">
                    <p><strong>Approved by:</strong></p>
                    <br />
                    <p>BENJAMIN F. UICHICO</p>
                    <p>Managing Director</p>
                </td>
            </tr>
        </table>
        <div>
            <p><strong>CONFORME:</strong></p>
            <br />
            <p>Name & Signature of Client Representative</p>
            <p>Date:</p>
        </div>
    </div>
</section>

</html>