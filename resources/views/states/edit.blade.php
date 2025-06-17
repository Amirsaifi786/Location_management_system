@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit state</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('states.update', $state->id) }}" method="POST">
        @csrf
        @method('PUT')
  <div class="mb-3">
        <select name="country_id" id="country" class="form-control">
    <option value="">-- Select Country --</option>
   @foreach ($countries as $country)
    <option value="{{ $country->id }}" 
        {{ (old('country_id', $state->country_id ?? '') == $country->id) ? 'selected' : '' }}>
        {{ $country->country_name }}
    </option>
@endforeach

</select>

          </div>
        <div class="mb-3">
            <label for="state_name" class="form-label">state Name *</label>
            <input type="text" name="state_name" id="state_name" class="form-control" value="{{ old('state_name', $state->state_name) }}" required>
        </div>

        {{-- <div class="mb-3">
            <label for="sortname" class="form-label">Sort Name</label>
            <input type="text" name="sortname" id="sortname" class="form-control" value="{{ old('sortname', $state->sortname) }}">
        </div>

        <div class="mb-3">
            <label for="phoneCode" class="form-label">Phone Code</label>
            <input type="number" name="phoneCode" id="phoneCode" class="form-control" value="{{ old('phoneCode', $state->phoneCode) }}">
        </div> --}}

        <button type="submit" class="btn btn-primary">Update state</button>
        <a href="{{ route('states.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
