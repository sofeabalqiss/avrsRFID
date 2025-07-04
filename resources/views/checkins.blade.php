@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('checkins.index') }}" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-filter me-2"></i> Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control"
                               value="{{ request('search') }}" placeholder="Name, IC, or House No.">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="inside" {{ request('status') == 'inside' ? 'selected' : '' }}>Inside</option>
                            <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="date_from" class="form-control"
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="date_to" class="form-control"
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Visitor Type</label>
                        <select name="visitor_type" class="form-select">
                            <option value="">All Types</option>
                            @foreach(['occassional','technician', 'food_delivery', 'parcel_delivery', 'others'] as $type)
                                <option value="{{ $type }}" {{ request('visitor_type') == $type ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('checkins.index') }}" class="btn btn-outline-secondary me-auto">Reset</a>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-list-check me-2"></i> Visitor Check-In Records
                </h5>
                <div class="d-flex">
                    <form action="{{ route('checkins.index') }}" method="GET" class="d-flex">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control"
                                   value="{{ request('search') }}" placeholder="Search visitors...">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </form>
                    <button class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-1"></i> Filters
                        @if(count(array_filter(request()->except('page'))) > 0)
                            <span class="badge bg-danger ms-1">!</span>
                        @endif
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="visitorsTable">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Visitor</th>
                            <th class="py-3 px-4">IC Number</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">House No.</th>
                            <th class="py-3 px-4">Check-In</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkins as $visit)
                            <tr class="border-bottom" data-visit-id="{{ $visit->id }}">
                                <td class="py-3 px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            <span class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                                {{ substr($visit->visitor->name_printed, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $visit->visitor->name_printed }}</h6>
                                            <small class="text-muted">ID: {{ $visit->visitor->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-muted align-middle">{{ $visit->visitor->ic_number }}</td>
                                <td class="py-3 px-4 align-middle">
                                    <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase">
                                        {{ $visit->visitor->visitor_type }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 align-middle">{{ $visit->visitor->house_number }}</td>
                                <td class="py-3 px-4 align-middle">
                                    @if($visit->check_in)
                                        <span class="d-block">{{ \Carbon\Carbon::parse($visit->check_in)->format('d M Y') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($visit->check_in)->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 align-middle visitor-status">
                                    @if($visit->check_out)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="fas fa-sign-out-alt me-1"></i> Checked Out
                                        </span>
                                        <small class="d-block text-muted mt-1">
                                            {{ \Carbon\Carbon::parse($visit->check_out)->format('d M Y H:i') }}
                                        </small>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-circle-check me-1"></i> Inside
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 align-middle">
                                <div class="d-flex gap-2">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-info view-details-btn"
                                            data-visit-id="{{ $visit->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <form action="{{ route('checkins.checkout', $visit->id) }}" method="POST" class="user-checkout-form">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger checkout-btn" title="Permanent Check-out">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            @if($checkins->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing <span class="fw-semibold">{{ $checkins->firstItem() }}</span> to
                        <span class="fw-semibold">{{ $checkins->lastItem() }}</span> of
                        <span class="fw-semibold">{{ $checkins->total() }}</span> entries
                    </div>
                    {{ $checkins->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- User Confirmation Modal -->
<div class="modal fade" id="userCheckoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-sign-out-alt me-2"></i> Confirm Check-out</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to permanently check out this visitor?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="userConfirmCheckout">Yes, Check Out</button>
      </div>
    </div>
  </div>
</div>

<!-- Visitor Detail Modal -->
<div class="modal fade" id="visitorDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-id-card me-2"></i> Visitor Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visitorDetailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3">Loading visitor details...</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    window.csrfToken = "{{ csrf_token() }}";

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script loaded successfully');
        console.log('Polling system initialized');

        const POLLING_INTERVAL = 5000; // 5 seconds
        let lastUpdateTime = null;
        let pollingInterval = null;

        async function fetchVisits() {
            try {
                const params = new URLSearchParams(window.location.search);
                if (lastUpdateTime) params.append('last_update', lastUpdateTime);

                const response = await fetch(`/api/visits-polling?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken
                    }
                });

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const data = await response.json();
                console.log('Polling response:', data);

                if (data.visits.length > 0) {
                    lastUpdateTime = data.last_updated;
                    updateUI(data.visits);
                }
            } catch (error) {
                console.error('Polling error:', error);
            }
        }

        let userForm = null;
        const modalEl = document.getElementById('userCheckoutModal');
        const modal = new bootstrap.Modal(modalEl);
        const confirmBtn = document.getElementById('userConfirmCheckout');

        function attachCheckoutListeners() {
            document.querySelectorAll('.user-checkout-form .checkout-btn').forEach(btn => {
                btn.removeEventListener('click', handleCheckoutClick); // prevent duplicates
                btn.addEventListener('click', handleCheckoutClick);
            });
        }

        function handleCheckoutClick(e) {
            e.preventDefault();
            userForm = this.closest('form');
            modal.show();
        }

        attachCheckoutListeners();

        confirmBtn.addEventListener('click', function () {
            if (userForm) userForm.submit();
        });

        function updateUI(visits) {
            console.log('Updating UI with', visits.length, 'visits');
            const tbody = document.querySelector('#visitorsTable tbody');

            // Clear existing rows
            tbody.innerHTML = '';

            visits.forEach(visit => {
                const row = document.createElement('tr');
                row.className = 'border-bottom';
                row.dataset.visitId = visit.id;

                const checkInDate = visit.check_in ? new Date(visit.check_in) : null;
                const checkOutDate = visit.check_out ? new Date(visit.check_out) : null;

                row.innerHTML = `
                    <td class="py-3 px-4 align-middle">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-3">
                                <span class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                    ${visit.visitor.name_printed.charAt(0)}
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">${visit.visitor.name_printed}</h6>
                                <small class="text-muted">ID: ${visit.visitor.id}</small>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-muted align-middle">${visit.visitor.ic_number}</td>
                    <td class="py-3 px-4 align-middle">
                        <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase">
                            ${visit.visitor.visitor_type}
                        </span>
                    </td>
                    <td class="py-3 px-4 align-middle">${visit.visitor.house_number}</td>
                    <td class="py-3 px-4 align-middle">
                        ${checkInDate ? `
                            <span class="d-block">${formatDate(checkInDate)}</span>
                            <small class="text-muted">${formatTime(checkInDate)}</small>
                        ` : '<span class="text-muted">N/A</span>'}
                    </td>
                    <td class="py-3 px-4 align-middle visitor-status">
                        ${checkOutDate ? `
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-sign-out-alt me-1"></i> Checked Out
                            </span>
                            <small class="d-block text-muted mt-1">
                                ${formatDateTime(checkOutDate)}
                            </small>
                        ` : `
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-circle-check me-1"></i> Inside
                            </span>
                        `}
                    </td>
                    <td class="py-3 px-4 align-middle">
                        <div class="checkout-form">
                            <form action="/checkins/${visit.id}/checkout" method="POST" class="user-checkout-form">
                                <input type="hidden" name="_token" value="${window.csrfToken}">
                                <button type="submit" class="btn btn-sm btn-outline-danger checkout-btn" title="Permanent Check-out">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                `;

                tbody.appendChild(row);
            });

            // Re-attach modal confirmation to new checkout buttons
            attachCheckoutListeners();
        }

        // Helper functions for date formatting
        function formatDate(date) {
            return date.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
        }

        function formatTime(date) {
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        function formatDateTime(date) {
            return formatDate(date) + ' ' + formatTime(date);
        }

        // Uncomment these lines if you want polling enabled:
        // fetchVisits();
        // pollingInterval = setInterval(fetchVisits, POLLING_INTERVAL);

    });

    // Visitor Detail Modal Logic
    const visitorDetailModal = new bootstrap.Modal(document.getElementById('visitorDetailModal'));
    const detailContent = document.getElementById('visitorDetailContent');

    document.querySelectorAll('.view-details-btn').forEach(button => {
        button.addEventListener('click', function () {
            const visitId = this.getAttribute('data-visit-id');
            detailContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3">Loading visitor details...</p>
                </div>`;
            visitorDetailModal.show();

            fetch(`/checkins/${visitId}`)
                .then(response => response.text())
                .then(html => {
                    detailContent.innerHTML = html;
                })
                .catch(error => {
                    detailContent.innerHTML = `<div class="alert alert-danger">Failed to load details.</div>`;
                    console.error('Detail fetch error:', error);
                });
        });
    });

</script>
@endsection



