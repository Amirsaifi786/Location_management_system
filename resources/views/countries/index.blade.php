@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Countries</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('countries.create') }}" class="btn btn-primary mb-3">Add New Country</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Coluntry Name</th>
       
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($countries as $state)
            <tr>
                <td>{{ $state->id }}</td>
                <td>{{ $state->country_name }}</td>
                
                <td>
                    <a href="{{ route('countries.edit', $state->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('countries.destroy', $state->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No countries found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $countries->links() }}
</div>
@endsection
