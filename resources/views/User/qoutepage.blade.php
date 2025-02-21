@extends('user.layouts.app')

@section('content')
<div class="container">
    <h1>Facilities & Rates</h1>

    @foreach($facilities as $facility)
    <div class="card mb-4">
        <div class="card-header">
            <h3>{{ $facility->name }}</h3>
        </div>
        <div class="card-body">
            <p>{{ $facility->description }}</p>
            <ul class="list-group">
                @foreach($facility->rates as $rate)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $rate->rate_type }}</strong>: Php {{ number_format($rate->rate, 2) }}
                            <em>({{ $rate->unit }})</em>
                        </div>
                        <div>
                            <!-- Add-to-Cart Form for this rate -->
                            <form action="{{ route('cart.add') }}" method="POST" class="form-inline">
                                @csrf
                                <input type="hidden" name="facility_id" value="{{ $facility->id }}">
                                <input type="hidden" name="rate_id" value="{{ $rate->id }}">

                                <div class="form-group mx-sm-2">
                                    <label for="duration_{{ $rate->id }}" class="sr-only">Duration</label>
                                    <input type="number" name="duration" id="duration_{{ $rate->id }}"
                                        class="form-control" placeholder="Duration" required>
                                </div>

                                @if(stripos($rate->unit, 'per head') !== false)
                                <div class="form-group mx-sm-2">
                                    <label for="participants_{{ $rate->id }}" class="sr-only">Participants</label>
                                    <input type="number" name="participants" id="participants_{{ $rate->id }}"
                                        class="form-control" placeholder="Participants">
                                </div>
                                @endif

                                @if(stripos($rate->unit, 'per court') !== false || stripos($rate->unit, 'half area') !==
                                false)
                                <div class="form-group mx-sm-2">
                                    <label for="courts_{{ $rate->id }}" class="sr-only">Courts/Areas</label>
                                    <input type="number" name="courts" id="courts_{{ $rate->id }}" class="form-control"
                                        placeholder="Courts/Areas">
                                </div>
                                @endif

                                <button type="submit" class="btn btn-success">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach

    <!-- Optionally, display a button to view the current cart quote -->
    <div class="mt-4">
        <a href="{{ route('cart.quote.view') }}" class="btn btn-primary">View Cart & Get Quote</a>
    </div>
</div>
@endsection