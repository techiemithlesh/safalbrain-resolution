@extends('admin.layouts.master')

@section('title')
    <title>Edit Page Content</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Training Page Content</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.page-content.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <textarea name="subtitle" id="subtitle" class="form-control" rows="3">{{ old('subtitle', $content->subtitle) }}</textarea>
                    @error('subtitle')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="non_target_text">Non-Target Text</label>
                    <input type="text" name="non_target_text" id="non_target_text" class="form-control" 
                           value="{{ old('non_target_text', $content->non_target_text) }}">
                    @error('non_target_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="main_title">Main Title</label>
                    <input type="text" name="main_title" id="main_title" class="form-control" 
                           value="{{ old('main_title', $content->main_title) }}">
                    @error('main_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="highlighted_text">Highlighted Text</label>
                    <input type="text" name="highlighted_text" id="highlighted_text" class="form-control" 
                           value="{{ old('highlighted_text', $content->highlighted_text) }}">
                    @error('highlighted_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Content</button>
            </form>
        </div>
    </div>
</div>
@endsection