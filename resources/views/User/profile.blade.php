@extends('user.layouts.app')
@section('content')
<!-- HEADER -->

<section id="image" class="position-relative text-white">
    <div class="bg-image" style=" background-image: url('/storage/{{ $contents['profile-background']->value ?? ''}}');">
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

<!-- USER SETTINGS -->
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

            <div class="form-container">
                <!-- Top Page Section -->
                <form action="{{route('EditProfile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 names d-flex gap-2">
                        <!-- First Name -->
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="fname" value="{{Auth::user()->fname}}"
                                placeholder="Anthony" />
                        </div>
                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lname" value="{{Auth::user()->lname}}"
                                placeholder="Jennings" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="{{Auth::user()->email}}" disabled
                            placeholder="anthonyjennings@gmail.com" />
                    </div>
                    <!-- Phone Number -->
                    <div class="form-group">
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

                    <button class="mt-3 save-btn" type="submit">Save Changes</button>
                </form>

                <!-- About Section -->
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
            <!-- APPROVED -->
            <div class="mt-3 notif-container">
                <div class="message-accept">
                    <h3>Request Approved!</h3>
                    <p>Your request for quotation has been approved.</p>
                </div>
                <button class="payment-btn shadow-none">Proceed to payment</button>
            </div>
            <!-- VERIFIED -->
            <div class="notif-container">
                <div class="message-accept">
                    <h3>Payment Verified Successfully!</h3>
                    <p>
                        Your payment has been verified and your schedule is now set.
                    </p>
                </div>
                <button class="payment-btn shadow-none">
                    Download Payment Receipt
                </button>
            </div>
            <!-- DENIED -->
            <div class="notif-container">
                <div class="message-deny">
                    <h3>Request Denied!</h3>
                    <p>
                        Your request for quotation has been denied, due to same date
                        conflict.
                    </p>
                </div>
                <button class="payment-btn shadow-none">Request again</button>
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
                    <option value="payment">Payments</option>
                    <option value="quotation">Quotation Requests</option>
                </select>

                <label for="status-filter">Filter by Status:</label>
                <select id="status-filter">
                    <option value="all">All</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="denied">Denied</option>
                </select>

                <table>
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Reference No.</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-table">
                        <tr data-type="payment" data-status="completed" data-date="2025-02-15">
                            <td>2025-02-15 14:30</td>
                            <td>REF123456</td>
                            <td>Payment</td>
                            <td>$150.00</td>
                            <td>Completed</td>
                        </tr>
                        <tr data-type="quotation" data-status="pending" data-date="2025-02-16">
                            <td>2025-02-16 10:15</td>
                            <td>REF789012</td>
                            <td>Quotation Request</td>
                            <td>$0.00</td>
                            <td>Pending</td>
                        </tr>
                        <tr data-type="payment" data-status="completed" data-date="2025-02-17">
                            <td>2025-02-17 09:45</td>
                            <td>REF345678</td>
                            <td>Payment</td>
                            <td>$200.00</td>
                            <td>Completed</td>
                        </tr>
                        <tr data-type="quotation" data-status="approved" data-date="2025-02-18">
                            <td>2025-02-18 16:00</td>
                            <td>REF901234</td>
                            <td>Quotation Request</td>
                            <td>$0.00</td>
                            <td>Approved</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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



@endsection
@push('css')
<link href="{{ asset('/css/user-settings.css') }}?v={{ time() }}" rel="stylesheet">
@endpush