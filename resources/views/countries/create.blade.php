@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Country</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('countries.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="country_name" class="form-label">Country Name *</label>
            <input type="text" name="country_name" id="country_name" class="form-control" value="{{ old('country_name') }}" required>
        </div>

        {{-- <div class="mb-3">
            <label for="sortname" class="form-label">Sort Name</label>
            <input type="text" name="sortname" id="sortname" class="form-control" value="{{ old('sortname') }}">
        </div>

        <div class="mb-3">
            <label for="phoneCode" class="form-label">Phone Code</label>
            <input type="number" name="phoneCode" id="phoneCode" class="form-control" value="{{ old('phoneCode') }}">
        </div> --}}

        <button type="submit" class="btn btn-success">Add Country</button>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
