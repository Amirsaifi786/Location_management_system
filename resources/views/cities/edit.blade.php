@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit city</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cities.update', $city->id) }}" method="POST">
        @csrf
        @method('PUT')
        
                    {{-- <div class="mb-3">
                <select name="state_id" id="state" class="form-control">
            <option value="">-- Select state --</option>
            @foreach ($states as $state)
            <option value="{{ $state->id }}" 
                {{ (old('state_id', $city->state_id ?? '') == $state->id) ? 'selected' : '' }}>
                {{ $state->state_name }}
            </option>
            @endforeach

            </select>

                    </div> --}}
            <div class="mb-3">
                <select name="state_id" id="state" class="form-control">
            <option value="">-- Select state --</option>
            @foreach ($states as $state)
            <option value="{{ $state->id }}" 
                {{ (old('state_id', $city->state_id ?? '') == $state->id) ? 'selected' : '' }}>
                {{ $state->state_name }}
            </option>
            @endforeach

            </select>

                    </div>
        <div class="mb-3">
            <label for="city_name" class="form-label">city Name *</label>
            <input type="text" name="city_name" id="city_name" class="form-control" value="{{ old('city_name', $city->city_name) }}" required>
        </div>

        {{-- <div class="mb-3">
            <label for="sortname" class="form-label">Sort Name</label>
            <input type="text" name="sortname" id="sortname" class="form-control" value="{{ old('sortname', $city->sortname) }}">
        </div>

        <div class="mb-3">
            <label for="phoneCode" class="form-label">Phone Code</label>
            <input type="number" name="phoneCode" id="phoneCode" class="form-control" value="{{ old('phoneCode', $city->phoneCode) }}">
        </div> --}}

        <button type="submit" class="btn btn-primary">Update city</button>
        <a href="{{ route('states.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
