@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cities</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<form method="GET" action="{{ route('cities.index') }}" class="mb-3 d-flex" style="max-width: 400px;">
    <input type="text" name="search" class="form-control me-2" placeholder="Search by city or state"
        value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>
</form>

    <a href="{{ route('cities.create') }}" class="btn btn-primary mb-3">Add New City</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>state Id</th>
                <th>city Name</th>
       
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cities as $city)
            <tr>
                {{-- @dd($city); --}}
                <td>{{ $city->id }}</td>
                <td>{{ $city->state->state_name }}</td>
                <td>{{ $city->city_name }}</td>
                
                <td>
                    <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No cities found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

{{-- <div class="d-flex justify-content-center mt-4"> --}}
    {{ $cities->links() }}
{{-- </div> --}}


</div>
@endsection
