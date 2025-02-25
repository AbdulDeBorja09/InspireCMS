@extends('Admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<div class="content" id="request">
    <h1>Payments</h1>
    <p>Manage user payments here.</p>

    <div class="form-container">
        <h4 class="mb-3">Payments</h4>

        <div class="mb-3 filter-container">
            <label for="dateFilter">Date & Time:</label>
            <input type="datetime-local" id="dateFilter" oninput="filterTable()" />

            <label for="statusFilter">Status:</label>
            <select id="statusFilter" onchange="filterTable()">
                <option value="">All</option>
                <option value="Paid">Paid</option>
                <option value="Completed">Completed</option>
            </select>

            <label for="refFilter">Reference No.:</label>
            <input type="text" id="refFilter" placeholder="Enter Reference No" oninput="filterTable()" />
        </div>
        <!-- Table of recent transaction -->
        <table id="transactionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date & Time</th>
                    <th>Payment No.</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr class="quotations">
                    <td>{{$index + 1}}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{$item->Quotation_ref}}</td>
                    <td>₱ {{number_format($item->total)}}</td>
                    @if ($item->status === 4)
                    <td class="new">Paid</td>
                    <td>
                        <button class="view-btn" onclick="ViewPayment({{$item}})">View</button>
                        <button class="approve-btn" onclick="ConfirmBookings({{$item}})">Confirm</button>
                    </td>
                    @elseif($item->status === 5)
                    <td class="pending">Confirm</td>
                    <td>
                        <button class="view-btn" onclick="ViewPayment({{$item}})">View</button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



<div class="modal fade" id="ConfirmBookings" tabindex="-1" aria-labelledby="ConfirmBookingsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteFAQForm" method="POST" action="{{ route('admin.ApprovePayment') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="ConfirmBookingsLabel">Confirm Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to Confirm this payment?
                    <input type="hidden" name="id" id="ConfirmBookings_id">
                </div>
                <div class="mb-3 p-3">
                    <label for="rate-inclusions" class="form-label">Message:</label>
                    <textarea class="form-control" id="editrate-inclusions" name="message" rows="3"
                        required>Your payment has been verified and your reservation is confirmed</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn reject-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn approve-btn">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="viewpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="staticBackdropLabel">
                    View Payment
                </h1>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h4>User Details</h4>
                        <div class="user-details">
                            <h5>First Name</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_fname" readonly
                                placeholder="Fetching...">

                            <h5>Last Name</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_lname" readonly
                                placeholder="Fetching...">

                            <h5>Address</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_address" readonly
                                placeholder="Fetching...">

                            <h5>Email</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_email" readonly
                                placeholder="Fetching...">

                            <h5>Phone Number</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_phone" readonly
                                placeholder="Fetching...">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h4>Payment Details</h4>
                        <div class="user-transaction">
                            <h5>Payment Reference</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_reference" readonly
                                placeholder="Fetching...">

                            <h5>Date & Time</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_time" readonly
                                placeholder="Fetching...">

                            <h5>Payment Terms</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_terms" readonly
                                placeholder="Fetching..." style="text-transform: capitalize">

                            <h5>Paid Amount</h5>
                            <input class="mb-3 w-100" type="text" id="view_payment_amount" readonly
                                placeholder="Fetching...">

                            <h5>Proof of Payment</h5>
                            <button class="mb-3 w-100  btn btn-outline-light view-btn " id="view_payment_proof">View
                                Image</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="modal-btn" id="view_paymentbtn">
                    View PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<script>
    function ViewPayment(Item) {
        // document.getElementById('ViewPaymentID').value = Item.id;
        $.ajax({
            url: '/Admin/Payments/Details/api', 
            type: 'GET', 
            data: { id: Item.id },
            dataType: 'json', 
            success: function(response) {
                var paymentName = response.payment.name;
                let parts = paymentName.split(",");
                const proof = response.payment.proof;


                proofUrl = '/storage/' + proof;
                PDF = '/Reservation/Confirmed/' + Item.id;
                document.getElementById('view_payment_reference').value = Item.Quotation_ref;
                document.getElementById('view_payment_time').value = moment(response.user.created_at).format("MMM D y, hh:mm A");
                document.getElementById('view_payment_terms').value = response.payment.payment_term;
                document.getElementById('view_payment_fname').value = parts[1].trim();
                document.getElementById('view_payment_lname').value = parts[0].trim();
                document.getElementById('view_payment_address').value = response.payment.address;
                document.getElementById('view_payment_email').value = response.payment.email;
                document.getElementById('view_payment_phone').value = response.payment.phone;
                document.getElementById('view_payment_amount').value = response.payment.total;
                document.getElementById('view_payment_proof').addEventListener('click', function() {
                    window.open(proofUrl, '_blank');
                });
                document.getElementById('view_paymentbtn').addEventListener('click', function() {
                    window.open(PDF, '_blank');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching quotation orders:", error);
            }
        });


        let modal = new bootstrap.Modal(document.getElementById('viewpayment'));
        modal.show();
    }

    function ConfirmBookings(Item) {
        document.getElementById('ConfirmBookings_id').value = Item.id;

        let modal = new bootstrap.Modal(document.getElementById('ConfirmBookings'));
        modal.show();
    }
    
    function filterTable() {
      const dateFilter = document.getElementById("dateFilter").value;
      const statusFilter = document
        .getElementById("statusFilter")
        .value.toLowerCase();
      const refFilter = document
        .getElementById("refFilter")
        .value.toLowerCase();
      const rows = document.querySelectorAll("#transactionsTable tbody tr");

      rows.forEach((row) => {
        const date = row.cells[1].textContent.trim();
        const status = row.cells[4].textContent.trim().toLowerCase();
        const ref = row.cells[2].textContent.trim().toLowerCase();

        const dateMatch = !dateFilter || date.includes(dateFilter);
        const statusMatch = !statusFilter || status === statusFilter;
        const refMatch = !refFilter || ref.includes(refFilter);

        if (dateMatch && statusMatch && refMatch) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }
</script>

@endsection