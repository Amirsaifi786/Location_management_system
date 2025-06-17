@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New City</h1>

    <form action="{{ route('cities.store') }}" method="POST">
        @csrf

        <!-- state Dropdown -->
        <div class="mb-3">
            <label for="state_id" class="form-label">state *</label>
            <select class="form-select" id="state_id" name="state_id" required>
                <option value="">-- Select state --</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- <!-- State Dropdown (Populated by JS) -->
        <div class="mb-3">
            <label for="state_id" class="form-label">State *</label>
            <select class="form-select" id="state_id" name="state_id" required>
                <option value="">-- Select State --</option>
            </select>
        </div> --}}

        <!-- City Input -->
        <div class="mb-3">
            <label for="city_name" class="form-label">City Name *</label>
            <input type="text" name="city_name" id="city_name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add City</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country_id').on('change', function () {
            var countryId = $(this).val();
            $('#state_id').html('<option value="">Loading...</option>');

            if (countryId) {
                $.ajax({
                    url: "{{ url('get-states') }}/" + countryId,

                    type: 'GET',
                    success: function (data) {
                        $('#state_id').empty().append('<option value="">-- Select State --</option>');
                        $.each(data, function (key, value) {
                            $('#state_id').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                    },
                    error: function () {
                        $('#state_id').html('<option value="">Error loading states</option>');
                    }
                });
            } else {
                $('#state_id').html('<option value="">-- Select State --</option>');
            }
        });
    });
</script>
@endsection
