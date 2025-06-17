@extends('layouts.app')

@section('content')
<div class="container">
    <h1>States</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('states.create') }}" class="btn btn-primary mb-3">Add New State</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Country Id</th>
                <th>State Name</th>
       
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($states as $state)
            <tr>
                {{-- @dd($state); --}}
                <td>{{ $state->id }}</td>
                <td>{{ $state->country->country_name }}</td>
                <td>{{ $state->state_name }}</td>
                
                <td>
                    <a href="{{ route('states.edit', $state->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('states.destroy', $state->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No states found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $states->links() }}
</div>
@endsection
