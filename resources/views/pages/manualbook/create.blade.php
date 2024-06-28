@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload Manual Book</h1>
    <form action="{{ route('manualbook.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
