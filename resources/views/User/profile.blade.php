@extends('User.layouts.app')
@section('content')
<!-- HEADER -->

<section id="image" class="position-relative text-white">
    <div class="bg-image" style=" background-image: url({ $contents['profile-background']->value ?? ''}});">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['profile-title']->value ?? '' }}</h1>
                        <p>{{ $contents['profile-tagline']->value ?? '' }}</p>
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
<!-- END OF HEADER -->


<div class="container my-5 settings">
    <div class="sidebar" role="tablist">
        <!-- USER IMAGE -->
        <div class="profile-section">
            @if (Auth::user()->image)
            <img src="{{asset('storage/' . Auth::user()->image)}}" alt="Profile Picture" class="profile-img" />
            @else
            <img src="{{asset('images/profile.webp')}}" alt="Profile Picture" class="profile-img" />
            @endif
            <div class="profile-info">
                <p class="username">{{Auth::user()->fname}} {{Auth::user()->lname}}</p>
            </div>
        </div>
        <hr style="
          border: 1px solid #64748b;
          opacity: 1;
          width: 100%;
          margin: 25px 0;
        " />

        <!-- SIDEBAR TABS -->
        <a class="sidetabs active" href="" onclick="showTab(event, 'settings')">
            <i class="bi bi-gear-fill"></i> Account
        </a>

        <a class="sidetabs" href="#" onclick="showTab(event, 'notification')">
            <i class="bi bi-bell-fill"></i> Notifications
        </a>

        <a class="sidetabs" href="#" onclick="showTab(event, 'transactions')">
            <i class="bi bi-cash"></i> Transactions
        </a>
    </div>

    <!-- TAB CONTENTS -->
    <div class="content-container">
        <!-- ACCOUNT SETTINGS -->
        <div class="content active" id="settings">
            <h1>Account Settings</h1>
            <p>Manage your account information here.</p>
            <hr style="
            border: 1px solid #64748b;
            opacity: 1;
            width: 100%;
            margin: auto;
          " />

            <!-- ACCOUNT -->
            <div class="form-containers">
                <form class="user-info form" action="{{route('EditProfile')}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 names d-flex justify-content-between">
                        <!-- First Name -->
                        <div class="mb-3 form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="fname" value="{{Auth::user()->fname}}"
                                placeholder="Anthony" />
                        </div>
                        <!-- Last Name -->
                        <div class="mb-3 form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lname" value="{{Auth::user()->lname}}"
                                placeholder="Jennings" />
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="mb-3 form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="{{Auth::user()->email}}" disabled
                            placeholder="anthonyjennings@gmail.com" />
                    </div>
                    <!-- Phone Number -->
                    <div class="mb-3 form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{Auth::user()->phone}}"
                            placeholder="09123456789" />
                    </div>
                    <!-- User Image -->
                    <div class="form-group">
                        <label for="imageUpload">Profile Image:</label>
                        <div class="mb-3 image-preview" id="imagePreview">
                            @if (Auth::user()->image)
                            <img src="{{asset('storage/' . Auth::user()->image)}}" alt="Profile Picture"
                                class="profile-img" />
                            @else
                            <span>No image selected</span>
                            @endif

                        </div>
                        <input type="file" id="imageUpload" name="image" accept="image/*" />
                    </div>

                    <div class="btn-container">
                        <button class="save-btn" type="submit">Save Changes</button>
                    </div>
                </form>

                <!-- Change Password -->
                <form action="{{route('ChangePassword')}}" class="mt-3 change-password form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 form-group">
                        <label for="password">Enter old password</label>
                        <input type="password" id="old_password" name="old_password" placeholder="Enter old password" />
                    </div>
                    <div class="mb-3 form-group">
                        <label for="password">Enter new password</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" />
                    </div>
                    <div class="mb-3 form-group">
                        <label for="password">Confirm password</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                            placeholder="Confirm password" />
                    </div>
                    <div class="btn-container">
                        <button class="save-btn" type="submit">Save Changes</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- NOTIFICATIONS -->
        <div class="content" id="notification">
            <h1>Notifications</h1>
            <p>View your notifications here.</p>
            <hr style="
            border: 1px solid #64748b;
            opacity: 1;
            width: 100%;
            margin: auto;
          " />
            <div class="notif-containerr" style="height: 600px; overflow: auto">
                @foreach($notif as $item)
                <!-- APPROVED -->
                @if($item->status === 'Approved')
                <div class="mt-3 notif-container">
                    <div class="notif-header message-accept" onclick="toggleAccordion(this)">
                        <h3>Request Approved!</h3>
                    </div>
                    <div class="notif-content">
                        <p><strong>{{$item->request->Quotation_ref}}</strong> {{$item->message}}</p>
                        <div class="btn-container">

                            <a class="transac-btn text-white" href="{{url('Payment/' .$item->quotation_id)}}"
                                style="text-decoration:none">Proceed to payment</a>
                        </div>
                    </div>
                </div>
                @elseif($item->status === 'Rejected')
                <!-- DENIED -->
                <div class="mt-3 notif-container" data-id="{{$item->id}}">
                    <div class="notif-header message-deny d-flex " onclick="toggleAccordion(this)"
                        style="justify-content: space-between">
                        <h3>Request Denied!</h3>
                        <button class="btn" onclick="deleteNotification(this)" style="margin-top: -5px "><i
                                class="bi bi-x-circle" style="font-size: 20px"></i></button>
                    </div>
                    <div class="notif-content">
                        <p>
                            <strong>{{$item->request->Quotation_ref}}</strong> {{$item->message}}
                        </p>
                        <div class="btn-container">
                            <button class="transac-btn" onclick="window.location.href='/Quotation';">Request
                                Again</button>

                        </div>
                    </div>
                </div>
                @elseif($item->status === 'Cancelled')
                <!-- DENIED -->
                <div class="mt-3 notif-container" data-id="{{$item->id}}">
                    <div class="notif-header message-deny d-flex " onclick="toggleAccordion(this)"
                        style="justify-content: space-between">
                        <h3>Request Cancelled!</h3>
                        <button class="btn" onclick="deleteNotification(this)" style="margin-top: -5px "><i
                                class="bi bi-x-circle" style="font-size: 20px"></i></button>
                    </div>
                    <div class="notif-content">
                        <p>
                            <strong>{{$item->request->Quotation_ref}}</strong> {{$item->message}}
                        </p>
                        <div class="btn-container">
                            <button class="transac-btn" onclick="window.location.href='/Quotation';">Request
                                Again</button>
                        </div>
                    </div>
                </div>
                @elseif($item->status === 'Verified')
                <!-- VERIFIED -->
                <div class="mt-3 notif-container">
                    <div class="notif-header message-accept" onclick="toggleAccordion(this)">
                        <h3>Payment Verified Successfully!</h3>
                    </div>
                    <div class="notif-content">
                        <p>
                            <strong>{{$item->request->Quotation_ref}}</strong> {{$item->message}}
                        </p>
                        <div class="btn-container">
                            <a class="transac-btn" style="text-decoration:none; color:white"
                                href="{{url('/Reservation/Confirmed/'. $item->quotation_id )}}"
                                target="__blank">Download Payment
                                Receipt</a>
                        </div>
                    </div>
                </div>
                @endif


                @endforeach
            </div>



        </div>

        <!-- TRANSACTIONS -->
        <div class="content" id="transactions">
            <h1>Transactions</h1>
            <p>View your history of transactions.</p>
            <hr style="
            border: 1px solid #64748b;
            opacity: 1;
            width: 100%;
            margin: auto;
          " />

            <!-- TABLE -->
            <div class="table-container">
                <label for="date-filter">Filter by Date:</label>
                <input type="date" id="date-filter" />

                <label for="filter">Filter Transactions:</label>
                <select id="filter">
                    <option value="all">All</option>
                    <option value="Payment">Payments</option>
                    <option value="Quotation">Quotation Requests</option>
                </select>

                <label for="status-filter">Filter by Status:</label>
                <select id="status-filter">
                    <option value="all">All</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Denied</option>
                </select>

                <div class="transaction-table" style="height: 350px; overflow: auto">
                    <table>
                        <thead class="sticky-top">
                            <tr>
                                <th>Date & Time</th>
                                <th>Reference No.</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="transaction-table">

                            @foreach ($items as $item)
                            @php
                            // Determine the status text using if/elseif
                            if ($item->status === 1) {
                            $statusText = 'New';
                            } elseif ($item->status === 2) {
                            $statusText = 'Pending';
                            } elseif ($item->status === 3) {
                            $statusText = 'Approved';
                            } elseif ($item->status === 4) {
                            $statusText = 'Pending';
                            } elseif ($item->status === 5) {
                            $statusText = 'Completed';
                            } else {
                            $statusText = 'Rejected';
                            }

                            // Set the data type based on the status.
                            $dataType = $item->status < 4 ? 'Quotation' : 'Payment' ; $dateFormatted=$item->
                                created_at->format('Y-m-d');
                                $dateTimeFormatted = $item->created_at->format('Y-m-d H:i');
                                @endphp

                                <tr data-type="{{ $dataType }}" data-status="{{ $statusText }}"
                                    data-date="{{ $dateFormatted }}">
                                    <td>{{ $dateTimeFormatted }}</td>
                                    <td>{{ $item->Quotation_ref }}</td>
                                    <td>{{ $dataType }}</td>
                                    <td>₱ {{ number_format($item->total) }}</td>
                                    <td>{{ $statusText }}</td>
                                    @if( $item->status == 5)
                                    <td>
                                        <button class="shadow-none view-btn" onclick="ViewPayments({{$item}})">View
                                            More</button>
                                    </td>
                                    @else
                                    <td>
                                        <button class="shadow-none view-btn" onclick="ViewQuote({{$item}})">View
                                            More</button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function deleteNotification(button) {
      // Try to find the closest .notif-container element
      const container = button.closest('.notif-container');
      
      // If container is not found, log an error and exit the function
      if (!container) {
        console.error("Notification container not found.");
        return;
      }
      
      // Hide the container immediately
      container.style.display = 'none';
      
      // Retrieve the item ID from the data attribute
      const id = container.getAttribute('data-id');
      
      // Send AJAX (using Fetch API) to delete the item
      fetch('/Delete/Notification/Api', { // Replace with your actual delete URL
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id: id })
      })
      .then(response => response.json())
      .then(data => {
        console.log('Item deleted successfully:', data);
      })
      .catch((error) => {
        console.error('Error deleting item:', error);
        // Optionally, revert the hide action or notify the user
      });
    }
</script>


<div class="modal fade" id="userpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="staticBackdropLabel">
                    Your Payment Transaction
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
                <button type="button" class="modal-btn" id="download_btn">
                    Download Quotation
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userquote" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="staticBackdropLabel">
                    Your Quotation Request
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
            </div>
        </div>
    </div>
</div>

<script>
    function ViewQuote(Item) {
        $.ajax({
            url: "/User/Request/Details/api",  
            type: 'GET',
            data: { id: Item.id },
            dataType: 'json',
            success: function(response) {
                document.getElementById('view_quotaion_ref').value = Item.Quotation_ref;
                document.getElementById('view_date_created').value = moment(Item.created_at).format("MMM D y, hh:mm A");
                
                document.getElementById('view_service_name').value = response.items.service_name;
                document.getElementById('view_service_fname').value = response.user.fname;
                document.getElementById('view_service_lname').value = response.user.lname;
                document.getElementById('view_user_email').value = response.user.email;
                document.getElementById('view_user_phone').value = response.user.phone || ' ';

              
                if(Item.service_type == "Facility"){
                    document.getElementById('veiw_service_hours').value = `${Item.start_time} - ${Item.end_time}`;
                }
                
            
                document.getElementById('view_date_time').value =   moment(response.items.date).format("MMM D y");
                document.getElementById('view_date_time').value =   moment(response.items.date).format("MMM D y");
                document.getElementById('view_service_total').value = Item.total;
     

            },
            error: function(xhr, status, error) {
                console.error("Error fetching quotation orders:", error);
            }
        });


        let modal = new bootstrap.Modal(document.getElementById('userquote'));
        modal.show();
    }

    function ViewPayments(Item) {
        $.ajax({
            url: 'User/Payments/Details/api/', 
            type: 'GET', 
            data: { id: Item.id },
            dataType: 'json', 
            success: function(response) {
                var paymentName = response.payment.name;
                let parts = paymentName.split(",");
                const proof = response.payment.proof;


                // proofUrl = '/storage/' + proof;
                proofUrl =  proof;
                DownloadURL = '/Reservation/Confirmed/' + Item.id
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

                document.getElementById('download_btn').addEventListener('click', function() {
                    window.open(DownloadURL, '_blank');
                });


                
                
            },
            error: function(xhr, status, error) {
                console.error("Error fetching quotation orders:", error);
            }
        });

        let modal = new bootstrap.Modal(document.getElementById('userpayment'));
        modal.show();

    }

</script>

<!-- END OF USER SETTINGS -->

<!-- Change Tab on Click -->
<script>
    function showTab(event, tabId) {
      event.preventDefault();
      document
        .querySelectorAll(".content")
        .forEach((content) => content.classList.remove("active"));
      document
        .querySelectorAll(".sidetabs")
        .forEach((link) => link.classList.remove("active"));
      document.getElementById(tabId).classList.add("active");
      event.currentTarget.classList.add("active");
    }
</script>

<!-- Image Select -->
<script>
    const imageUpload = document.getElementById("imageUpload");
    const imagePreview = document.getElementById("imagePreview");

    imageUpload.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
          imagePreview.innerHTML = `<img src="${event.target.result}" alt="Preview Image">`;
        };
        reader.readAsDataURL(file);
      } else {
        imagePreview.innerHTML = `<span>No image selected</span>`;
      }
    });
</script>


<!-- Notifications -->
<script>
    function toggleAccordion(element) {
      const content = element.nextElementSibling;
      content.style.display =
        content.style.display === "block" ? "none" : "block";
    }
</script>

<!-- FILTERING -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
      const dateFilter = document.getElementById("date-filter");
      const typeFilter = document.getElementById("filter");
      const statusFilter = document.getElementById("status-filter");
      const tableRows = document.querySelectorAll("#transaction-table tr");

      function filterTable() {
        const selectedDate = dateFilter.value;
        const selectedType = typeFilter.value;
        const selectedStatus = statusFilter.value;

        tableRows.forEach((row) => {
          const rowDate = row.getAttribute("data-date");
          const rowType = row.getAttribute("data-type");
          const rowStatus = row.getAttribute("data-status");

          const matchesDate = selectedDate ? rowDate === selectedDate : true;
          const matchesType =
            selectedType === "all" || rowType === selectedType;
          const matchesStatus =
            selectedStatus === "all" || rowStatus === selectedStatus;

          row.style.display =
            matchesDate && matchesType && matchesStatus ? "" : "none";
        });
      }

      dateFilter.addEventListener("input", filterTable);
      typeFilter.addEventListener("change", filterTable);
      statusFilter.addEventListener("change", filterTable);
    });
</script>

@endsection
@push('css')
<link href="{{ asset('/css/user-settings.css') }}?v={{ time() }}" rel="stylesheet">
@endpush