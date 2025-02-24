<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- FAVICON -->
    <link rel="shortcut icon" href="images/logo/logo.png" type="image/x-icon" />

    <!-- FOR BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- STYLES -->
    <link rel="stylesheet" href="{{asset('css/payment-confirm.css')}}" />

    <!-- JS -->
    <script src="js/bootstrap.js"></script>
    <script src="js/navbar-color-scroll.js"></script>

    <title>Payment Confirmation - ISA</title>
</head>

<body>
    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg fixed-top p-md-3">
        <div class="container">
            <!-- ISA LOGO -->
            <a class="navbar-brand" href="index.html">
                <img src="{{asset('images/logo/inspire-logo.png')}}" class="img-fluid" alt="Logo" />
            </a>

            <!-- NAVBAR TABS -->
            <div class="justify-content-end">
                <h2 style="color: #f1f5f9">Payment Confirmation</h2>
            </div>
        </div>
    </nav>

    <!-- CONFIRMATION -->
    <section id="confirmation">
        <div class="container confirm-box">
            <div class="confirm-message">
                <div class="header">
                    <h1 class="mb-4 text-center">
                        <i class="bi bi-hourglass-split"></i>Payment Pending
                    </h1>
                    <p>
                        We have received your payment submission along with your proof of
                        payment. Your transaction is currently under verification. Once
                        confirmed, we will notify you, and your selected date will be
                        officially reserved.
                    </p>
                </div>

                <hr style="border: 1px solid #64748b; opacity: 1; width: 100%" />

                <div class="row info">
                    <div class="col-lg-7" style="border-right: 1px solid #64748b">
                        <h4>Summary</h4>
                        <div class="summary">
                            <p>Payment Reference: <strong>{{$quotation->Quotation_ref}}</strong></p>
                            <p>Date & Time: <strong>{{$quotation->date}} {{$quotation->start_time}} -
                                    {{$quotation->end_time}}</strong></p>
                            <p>
                                Payment Terms: <strong> @if($payment->payment_term === 'fullpayment')
                                    Full Payment
                                    @else
                                    Half Payment
                                    @endif
                                </strong>
                            </p>
                            <p>Paid Amount: ₱<strong>{{number_format($quotation->total)}}</strong></p>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <h4>Billing Address</h4>
                        <div class="summary">
                            <p>{{$payment->name}}</p>
                            <p>{{$payment->address}}</p>
                            <p>{{$payment->email}}</p>
                            <p>{{$payment->phone}}</p>
                        </div>
                    </div>
                </div>

                <div class="my-5 btn-container">
                    <button class="view-btn" onclick="window.location.href='/Profile';">View Transaction</button>
                    <button class="return-btn" onclick="window.location.href='/';">Return to home</button>
                </div>

                <hr style="border: 1px solid #64748b; opacity: 1; width: 100%" />

                <p>All rights reserved Inspire Sports Academy</p>
            </div>
        </div>
    </section>

    <!-- END OF CONFIRMATION -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>