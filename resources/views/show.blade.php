<div>
    <h5>{{ $visit->visitor->name_printed }}</h5>
    <p><strong>IC:</strong> {{ $visit->visitor->ic_number }}</p>
    <p><strong>House:</strong> {{ $visit->visitor->house_number }}</p>
    <p><strong>Type:</strong> {{ ucwords(str_replace('_', ' ', $visit->visitor->visitor_type)) }}</p>
    <p><strong>Check-In:</strong> {{ $visit->check_in ?? '-' }}</p>
    <p><strong>Check-Out:</strong> {{ $visit->check_out ?? '-' }}</p>
    <hr>
    <h6>Visit History:</h6>
    <ul>
        @foreach($visit->visitor->visits as $v)
            <li>{{ $v->check_in }} → {{ $v->check_out ?? 'Still inside' }}</li>
        @endforeach
    </ul>
</div>
