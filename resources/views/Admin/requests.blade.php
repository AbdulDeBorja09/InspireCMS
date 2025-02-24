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
                        <button class="reject-btn">Cancel</button>
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
<div class="modal fade" id="ViewRequest" tabindex="-1" aria-labelledby="ViewRequestLabel" aria-hidden="true">
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

                            <div class="mb-3">
                                <label for="editrate-type">Discount:</label>
                                <input id="editrate-type" type="text" name="discount" class="form-control mb-2"
                                    placeholder="10%" required>
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Sales Tax:</label>
                                <input id="editrate-type" type="text" name="tax" class="form-control mb-2"
                                    placeholder="Input Here" required>
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Penalty:</label>
                                <input id="editrate-type" type="text" name="penalty" class="form-control mb-2"
                                    placeholder="Input Here" required>
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Cancellation Fee:</label>
                                <input id="editrate-type" type="text" name="cancelation" class="form-control mb-2"
                                    placeholder="Input Here" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">

                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                              var calendarEl = document.getElementById('calendar');
                              var calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'timeGridDay',
                                initialDate: '2025-02-24',
                                events: '/blocked-dates',
                                eventContent: function(arg) {
                                  // Format date and time from the event's start date
                                  let eventDate = arg.event.start.toLocaleDateString();
                                  let eventTime = arg.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                  let customHtml = `<div>
                                                      <strong>${arg.event.title}</strong><br>
                                                      <small>${eventDate} at ${eventTime}</small>
                                                    </div>`;
                                  return { html: customHtml };
                                }
                              });
                              calendar.render();
                            });
                        </script>
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
<div class="modal fade" id="ApproveRequest" tabindex="-1" aria-labelledby="RequestApproveLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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
                        <div class="col-lg-6 col-md-12">
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
                                    placeholder="10%" required>
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Sales Tax:</label>
                                <input id="editrate-type" type="text" name="tax" class="form-control mb-2"
                                    placeholder="Input Here" required>
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Penalty:</label>
                                <input id="editrate-type" type="text" name="penalty" class="form-control mb-2"
                                    placeholder="Input Here" required>
                            </div>
                            <div class="mb-3">
                                <label for="editrate-type">Cancellation Fee:</label>
                                <input id="editrate-type" type="text" name="cancelation" class="form-control mb-2"
                                    placeholder="Input Here" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<script>
    function ApproveRequest(Item) {
        document.getElementById('ApproveID').value = Item.id;

        $.ajax({
            url: '{{ route("admin.GetContactDetails") }}', 
            type: 'GET', 
            data: { id: Item.id },
            dataType: 'json', 
            success: function(response) {
                console.log("Quotation Order Details:", response);
            
                document.getElementById('service_name').value = response.service_name;
                document.getElementById('service_desc').value = response.rate_name;
                document.getElementById('service_total').value = response.subtotal;
            },
            error: function(xhr, status, error) {
                console.error("Error fetching quotation orders:", error);
            }
        });


        let modal = new bootstrap.Modal(document.getElementById('ApproveRequest'));
        modal.show();
    }
    function ViewRequest(Item) {
        document.getElementById('ViewRequestID').value = Item.id;
        $.ajax({
            url: '{{ route("admin.GetContactDetails") }}', 
            type: 'GET', 
            data: { id: Item.id },
            dataType: 'json', 
            success: function(response) {
                console.log("Quotation Order Details:", response);
            
                document.getElementById('view_service_name').value = response.service_name;
                document.getElementById('view_service_desc').value = response.rate_name;
                document.getElementById('view_service_total').value = response.subtotal;
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