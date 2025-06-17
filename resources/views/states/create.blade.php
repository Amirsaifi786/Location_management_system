@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New state</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('states.store') }}" method="POST">
        @csrf
          <div class="mb-3">
          <select class="form-select" id="country" name="country_id">
            <option value="">-- Select Country --</option>

            @foreach ($countries as $country)
                
            <option value="{{ $country->id}}">{{ $country->country_name }}</option>
            @endforeach

    <!-- Add more countries as needed -->
  </select>
          </div>
        <div class="mb-3">
            <label for="state_name" class="form-label">state Name *</label>
            <input type="text" name="state_name" id="state_name" class="form-control" value="{{ old('state_name') }}" required>
        </div>

        {{-- <div class="mb-3">
            <label for="sortname" class="form-label">Sort Name</label>
            <input type="text" name="sortname" id="sortname" class="form-control" value="{{ old('sortname') }}">
        </div>

        <div class="mb-3">
            <label for="phoneCode" class="form-label">Phone Code</label>
            <input type="number" name="phoneCode" id="phoneCode" class="form-control" value="{{ old('phoneCode') }}">
        </div> --}}

        <button type="submit" class="btn btn-success">Add state</button>
        <a href="{{ route('states.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
