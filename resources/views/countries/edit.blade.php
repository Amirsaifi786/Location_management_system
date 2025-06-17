@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Country</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('countries.update', $country->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="country_name" class="form-label">Country Name *</label>
            <input type="text" name="country_name" id="country_name" class="form-control" value="{{ old('country_name', $country->country_name) }}" required>
        </div>

       
        <button type="submit" class="btn btn-primary">Update Country</button>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
