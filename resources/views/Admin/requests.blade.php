@extends('admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<div class="content" id="request">
    <h1>Requests</h1>
    <p>Manage user requests here.</p>

    <div class="form-container">
        <h4 class="mb-3">Quotation Requests</h4>

        <div class="mb-3 filter-container">
            <label for="dateFilter">Date & Time:</label>
            <input type="datetime-local" id="dateFilter" oninput="filterTable()" />

            <label for="statusFilter">Status:</label>
            <select id="statusFilter" onchange="filterTable()">
                <option value="">All</option>
                <option value="New">New</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
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
                    <th>Quotation No.</th>
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
                    @if ($item->status === 1)
                    <td class="new">New</td>
                    <td>
                        <button class="view-btn" onclick="ViewRequest({{$item}})">View</button>
                        <button class="approve-btn" onclick="ApproveRequest({{$item}})">Approve</button>
                        <button class="reject-btn" onclick="RejectRequest({{$item}})">Reject</button>
                    </td>
                    @elseif($item->status === 2)
                    <td class="pending">Pending</td>
                    <td>
                        <button class="view-btn" onclick="ViewRequest({{$item}})">View</button>
                        <button class="approve-btn" onclick="ApproveRequest({{$item}})">Approve</button>
                        <button class="reject-btn" onclick="RejectRequest({{$item}})">Reject</button>
                    </td>
                    @elseif($item->status === 3)
                    <td class="approved">Approved</td>
                    <td>
                        <button class="view-btn" onclick="ViewRequest({{$item}})">View</button>
                        <button class="reject-btn" onclick="CancelRequest({{$item}})">Cancel</button>
                    </td>
                    @else

                    <td class="rejected">Rejected</td>
                    <td>
                        <button class="view-btn">View</button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- <div class="modal fade" id="ViewRequest" tabindex="-1" aria-labelledby="ViewRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="editFAQForm" method="POST" action="{{ route('admin.ApproveRequest') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewRequestLabel">Approve Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="ViewRequestID">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label for="service_name">Service Name:</label>
                                <input id="view_service_name" type="text" name="view_service_name"
                                    class="form-control mb-2" placeholder="Fetching..." readonly>
                            </div>
                            <div class="mb-3">
                                <label for="service_desc">Description:</label>
                                <input id="view_service_desc" type="text" name="view_service_desc"
                                    class="form-control mb-2" placeholder="Fetching..." readonly>
                            </div>
                            <div class="mb-3">
                                <label for="service_total">Total:</label>
                                <input id="view_service_total" type=" text" name="view_service_total"
                                    class="form-control mb-2" placeholder="Fetching..." readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">

                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Cancell Request</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

<div class="modal fade" id="ApproveRequest" tabindex="-1" aria-labelledby="RequestApproveLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <form id="editFAQForm" method="POST" action="{{ route('admin.ApproveRequest') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RequestApproveLabel">Approve Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="ApproveID">
                    <div class="row">
                        <div class="col-lg-3 col-md-12">
                            <div class="mb-3">
                                <label for="quotation_ref">Service Name:</label>
                                <input id="approve_quotation_ref" type="text" name="service_name"
                                    class="form-control mb-2" placeholder="Fetching..." readonly>
                            </div>
                            <div class="mb-3">
                                <label for="service_name">Service Name:</label>
                                <input id="service_name" type="text" name="service_name" class="form-control mb-2"
                                    placeholder="Fetching..." readonly>
                            </div>
                            <div class="mb-3">
                                <label for="service_desc">Description:</label>
                                <input id="service_desc" type="text" name="service_desc" class="form-control mb-2"
                                    placeholder="IFetching..." readonly>
                            </div>
                            <div class="mb-3">
                                <label for="service_total">Total:</label>
                                <input id="service_total" type=" text" name="service_total" class="form-control mb-2"
                                    placeholder="Fetching..." readonly>
                            </div>

                            <div class="mb-3">
                                <label for="editrate-type">Discount:</label>
                                <input id="editrate-type" type="text" name="discount" class="form-control mb-2"
                                    placeholder="10%">
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Sales Tax:</label>
                                <input id="editrate-type" type="text" name="tax" class="form-control mb-2"
                                    placeholder="Input Here">
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Penalty:</label>
                                <input id="editrate-type" type="text" name="penalty" class="form-control mb-2"
                                    placeholder="Input Here">
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Cancellation Fee:</label>
                                <input id="editrate-type" type="text" name="cancelation" class="form-control mb-2"
                                    placeholder="Input Here">
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-12" id="View_calendar">

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Approve Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="RejectRequest" tabindex="-1" aria-labelledby="RejectRequestLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteFAQForm" method="POST" action="{{ route('admin.RejectRequest') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="RejectRequestLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to reject this request?
                    <input type="hidden" name="id" id="rejectrequest_id">
                </div>
                <div class="mb-3 p-3">
                    <label for="rate-inclusions" class="form-label">Reason:</label>
                    <textarea class="form-control" id="editrate-inclusions" name="reason"
                        rows="3">Your request for quotation has been denied due to</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn approve-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn reject-btn">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="CancelRequest" tabindex="-1" aria-labelledby="CancelRequestLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="CancelRequestForm" method="POST" action="{{ route('admin.CancelRequest') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="CancelRequestLabel">Confirm Cancel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel this request?
                    <input type="hidden" name="id" id="cancelrequest_id">
                </div>
                <div class="mb-3 p-3">
                    <label for="rate-inclusions" class="form-label">Reason:</label>
                    <textarea class="form-control" id="editrate-inclusions" name="reason"
                        rows="3">Your request for quotation has been Cancelled due to</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn approve-btn" data-bs-dismiss="modal">Return</button>
                    <button type="submit" class="btn reject-btn">Cancel Rquest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ViewRequest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="ViewRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="staticBackdropLabel">
                    View Quotation Request
                </h1>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4>Summary</h4>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="user-transaction">
                                    <h5>Quotation Reference</h5>
                                    <input class="w-100 mb-3" id="view_quotaion_ref" type="text" readonly
                                        value="Fetching...">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="user-transaction">
                                    <h5>Date & Time</h5>
                                    <input class="w-100 mb-3" id="view_date_created" type="text" readonly
                                        value="Fetching...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h4>User Details</h4>
                        <div class="user-details">
                            <h5>First Name</h5>
                            <input class="w-100 mb-3" id="view_service_fname" type="text" readonly value="Fetching...">

                            <h5>Last Name</h5>
                            <input class="w-100 mb-3" id="view_service_lname" type="text" readonly value="Fetching...">

                            <h5>Email</h5>
                            <input class="w-100 mb-3" id="view_user_email" type="text" readonly value=" ">

                            <h5>Phone Number</h5>
                            <input class="w-100 mb-3" id="view_user_phone" type="text" readonly value="Fetching...">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12">

                        <h4>Quotation Details</h4>
                        <div class="user-transaction">
                            <h5>Service Name</h5>
                            <input class="w-100 mb-3" id="view_service_name" type="text" readonly value="Fetching...">


                            <h5>Quoted Date & Time</h5>
                            <input class="w-100 mb-3" id="view_date_time" type="text" readonly value="Fetching...">


                            <h5>Duration</h5>
                            <input class="w-100 mb-3" id="veiw_service_hours" type="text" readonly value="Fetching...">

                            <h5>Total Amount Quoted</h5>
                            <input class="w-100 mb-3" id="view_service_total" type="text" readonly value="Fetching...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="modal-btn" data-bs-dismiss="modal">
                    View PDF
                </button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<script>
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
                initialView: 'dayGridWeek',
                events: blockedDates.map(date => {
                    return {
                        title: ` <strong >MILO MILOMILO MILOMILO MILO MILOMILO MILO </strong><br>(${moment(date.start_date).format('hh:mm A')} - ${moment(date.end_date).format('hh:mm A')})`, 
                        start: moment(date.start_date).toISOString(),  
                        end: moment(date.end_date).toISOString(), 
                        color: '#064e3b',
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

    function ApproveRequest(Item) {
        document.getElementById('ApproveID').value = Item.id;
        document.getElementById('approve_quotation_ref').value = Item.Quotation_ref;

        $.ajax({
            url: "/Admin/Request/Details/api",  // Directly use the route without Blade syntax
            type: 'GET',
            data: { id: Item.id },
            dataType: 'json',
            success: function(response) {
                console.log("Response Data:", response); // Debugging
            
                if (response.items) {
                    document.getElementById('service_name').value = response.items.service_name || "";
                    document.getElementById('service_desc').value = response.items.rate_name || "";
                    document.getElementById('service_total').value = response.items.subtotal || "";
                } else {
                    console.warn("No 'items' data in response.");
                }

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

        let modal = new bootstrap.Modal(document.getElementById('ApproveRequest'));
        modal.show();
    }

    function ViewRequest(Item) {
        // document.getElementById('ViewRequestID').value = Item.id;

        $.ajax({
            url: "/Admin/Request/Details/api",  
            type: 'GET',
            data: { id: Item.id },
            dataType: 'json',
            success: function(response) {
                document.getElementById('view_quotaion_ref').value = Item.Quotation_ref;
                document.getElementById('view_date_created').value = moment(Item.created_at).format("MMM D y, hh:mm A");

                
                document.getElementById('view_service_fname').value = response.user.fname;
                document.getElementById('view_service_lname').value = response.user.lname;
                document.getElementById('view_user_email').value = response.user.email;
                document.getElementById('view_user_phone').value = response.user.phone || ' ';

                
                document.getElementById('view_date_time').value =   moment(response.items.date).format("MMM D y");
                document.getElementById('view_date_time').value =   moment(response.items.date).format("MMM D y");
                document.getElementById('veiw_service_hours').value = `${Item.start_time} - ${Item.end_time}`;
                document.getElementById('view_service_total').value = Item.total;
                // document.getElementById('veiw_service_hours').value = response.items.total_hours;
     

            },
            error: function(xhr, status, error) {
                console.error("Error fetching quotation orders:", error);
            }
        });


        let modal = new bootstrap.Modal(document.getElementById('ViewRequest'));
        modal.show();
    }

    function RejectRequest(Item) {
        document.getElementById('rejectrequest_id').value = Item.id;

        let modal = new bootstrap.Modal(document.getElementById('RejectRequest'));
        modal.show();
    }

    function CancelRequest(Item) {
        document.getElementById('cancelrequest_id').value = Item.id;

        let modal = new bootstrap.Modal(document.getElementById('CancelRequest'));
        modal.show();
    }
</script>
<script>
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