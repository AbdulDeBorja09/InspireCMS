@extends('admin.layouts.app')
@section('content')
<!-- Dashboard Content -->
<div class="content active" id="dashboard">
    <h1>Dashboard</h1>
    <p>Monitor overall transactions.</p>

    <div class="form-container">
        <h4 class="mb-3">Summary</h4>
        <div class="dashboard">
            <div class="card">
                <i class="bi bi-clipboard-data"></i> Overall Transactions
                <h2>{{$total}}</h2>
            </div>
            <div class="card">
                <i class="bi bi-clock-history"></i> Pending Payment
                <h2>{{$approved }}</h2>
            </div>
            <div class="card">
                <i class="bi bi-hourglass-split"></i> Pending Approval
                <h2>{{$pending}}</h2>
            </div>
            <div class="card">
                <i class="bi bi-check-circle"></i> Complete Transactions
                <h2>{{$completed}}</h2>
            </div>
        </div>

        <!-- Recent Transaction -->
        <h4 class="mb-3">Recent Transactions</h4>
        <div class="mb-3 filters">
            <button class="filter-btn" onclick="filterTable('all')">All</button>
            <button class="filter-btn" onclick="filterTable('quotations')">
                Quotations
            </button>
            <button class="filter-btn" onclick="filterTable('payments')">
                Payments
            </button>
        </div>
        <!-- Table of recent transaction -->
        <table id="transactionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date & Time</th>
                    <th>Reference No.</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr class="quotations">
                    <td>{{$index + 1}}</td>
                    <td>2025-02-15 14:30</td>
                    <td>{{$item->Quotation_ref}}</td>
                    <td>Quotation</td>
                    <td>500</td>

                    @if ($item->status === 1)
                    <td class="new">New</td>

                    @elseif($item->status === 2)
                    <td class="pending">Pending</td>

                    @elseif($item->status === 3)
                    <td class="approved">Approved</td>
                    @elseif($item->status === 4)
                    <td class="new">Paid</td>
                    @endif
                    <td>
                        <button class="details-btn" onclick="window.location.href='/Admin/Requests';">
                            Details
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- DASHBOARD TABLE FILTER -->
<script>
    function filterTable(type) {
      let rows = document.querySelectorAll("tbody tr");
      rows.forEach((row) => {
        row.style.display = "table-row";
        if (type !== "all" && !row.classList.contains(type)) {
          row.style.display = "none";
        }
      });
    }
</script>
@endsection