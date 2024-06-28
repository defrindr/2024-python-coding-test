@extends('layouts.master')

@section('title', 'Manual Books')

@section('main')
<div class="container">
    <h1>Manual Books</h1>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Role</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th style="width: 7%;">No</th>
                        <th style="width: 33%;">Nama Role</th>
                        <th style="width: 60%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if ($manualBook = $role->manualBook)
                                    <div class="mb-2">
                                        <strong>{{ $manualBook->nama }}</strong>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('manualbook.download', $manualBook->id) }}" class="btn btn-primary mr-2">Download</a>
                                        <form action="{{ route('manualbook.destroy', $manualBook->id) }}" method="POST" class="mr-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <form action="{{ route('manualbook.store') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                            @csrf
                                            <div class="form-group mb-0 mr-3 flex-grow-1">
                                                <label for="file" class="sr-only">Upload {{ $role->name }} Manual Book</label>
                                                <input type="file" name="file" class="form-control" required>
                                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            </div>
                                            <button type="submit" class="btn btn-success ml-2">Upload</button>
                                        </form>
                                    </div>
                                @else
                                    <form action="{{ route('manualbook.store') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                        @csrf
                                        <div class="form-group mb-0 mr-3 flex-grow-1">
                                            <label for="file" class="sr-only">Upload {{ $role->name }} Manual Book</label>
                                            <input type="file" name="file" class="form-control" required>
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-3">Upload</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
