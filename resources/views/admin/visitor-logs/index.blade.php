@extends('layouts.admin')

@section('title', 'Visitor Logs')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Visitor Logs</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form class="row g-3 mb-4" method="GET" action="{{ route('admin.visitor-logs.index') }}">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search name / IC" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-2">
                <select name="visitor_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="Occasional" {{ request('visitor_type') == 'occasional' ? 'selected' : '' }}>Occasional</option>
                    <option value="Frequent" {{ request('visitor_type') == 'frequent' ? 'selected' : '' }}>Frequent</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Checked-In" {{ request('status') == 'Checked-In' ? 'selected' : '' }}>Checked-In</option>
                    <option value="Checked-Out" {{ request('status') == 'Checked-Out' ? 'selected' : '' }}>Checked-Out</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>IC Number</th>
                        <th>Type</th>
                        <th>House</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitorLogs as $log)
                        <tr>
                            <td>{{ $log->visitor->name_printed ?? '-' }}</td>
                            <td>{{ $log->visitor->ic_number ?? '-' }}</td>
                            <td>{{ $log->visitor->visitor_type ?? '-' }}</td>
                            <td>{{ $log->visitor->house_number ?? '-' }}</td>
                            <td>{{ $log->check_in }}</td>
                            <td>{{ $log->check_out ?? '-' }}</td>
                            <td>
                                @php
                                    $status = $log->check_out ? 'Checked-Out' : 'Checked-In';
                                @endphp
                                <span class="badge bg-{{ $status == 'Checked-In' ? 'success' : 'secondary' }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No visitor logs found.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            @foreach ($visitorLogs as $log)
                <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1" aria-labelledby="logModalLabel{{ $log->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content border border-primary">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="logModalLabel{{ $log->id }}">Visitor Log Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Name:</strong> {{ $log->visitor->name_printed ?? '-' }}</p>
                                <p><strong>IC Number:</strong> {{ $log->visitor->ic_number ?? '-' }}</p>
                                <p><strong>Type:</strong> {{ $log->visitor->visitor_type ?? '-' }}</p>
                                <p><strong>House:</strong> {{ $log->visitor->house_number ?? '-' }}</p>
                                <p><strong>Vehicle Plate:</strong> {{ $log->visitor->vehicle_plate ?? 'N/A' }}</p>
                                <p><strong>RFID Used:</strong> {{ $log->visitor->rfid->rfid_string ?? 'N/A' }}</p>

                                <hr>
                                <h6>Recent Visit History:</h6>
                                <ul>
                                    @foreach($log->visitor->visits->sortByDesc('check_in')->take(5) as $v)
                                        <li>{{ $v->check_in }} → {{ $v->check_out ?? 'Still inside' }}</li>
                                    @endforeach
                                </ul>

                                <hr>
                                <p><strong>Current Check-In:</strong> {{ $log->check_in }}</p>
                                <p><strong>Check-Out:</strong> {{ $log->check_out ?? 'Still Inside' }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $log->check_out ? 'secondary' : 'success' }}">
                                        {{ $log->check_out ? 'Checked-Out' : 'Checked-In' }}
                                    </span>
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

       {{ $visitorLogs->withQueryString()->links('pagination::bootstrap-5') }}

    </div>
</div>
@endsection
