@extends('layout.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Disease History Types</h3>
            <div class="card-toolbar">
                <a href="{{ route('klinik.disease_history_types.create') }}" class="btn btn-sm btn-primary">
                    Add New Disease History Type
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diseaseHistoryTypes as $type)
                        <tr>
                            <td>{{ $type->code }}</td>
                            <td>{{ $type->name }}</td>
                            <td>
                                <a href="{{ route('klinik.disease_history_types.edit', $type) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('klinik.disease_history_types.destroy', $type) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $diseaseHistoryTypes->links() }}
        </div>
    </div>
@endsection
