@extends('admin.layouts.master')

@section('title')
    <title>Edit Landing Page Content</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Landing Page Content</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.page-training-update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="main_title">Main Title</label>
                    <input type="text" name="main_title" id="main_title" class="form-control"
                           value="{{ old('main_title', $content->main_title) }}">
                    @error('main_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control"
                           value="{{ old('subtitle', $content->subtitle) }}">
                    @error('subtitle')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="getting_started_title">Getting Started Title</label>
                    <input type="text" name="getting_started_title" id="getting_started_title" class="form-control"
                           value="{{ old('getting_started_title', $content->getting_started_title) }}">
                    @error('getting_started_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Steps Section -->
                <div class="form-group">
                    <label>Steps</label>
                    @foreach($content->steps as $index => $step)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Step {{ $index + 1 }}</h6>
                                
                                <div class="form-group">
                                    <label for="step_title_{{ $index }}">Title</label>
                                    <input type="text" name="steps[{{ $index }}][title]" id="step_title_{{ $index }}" 
                                           class="form-control" value="{{ old("steps.$index.title", $step['title']) }}">
                                    @error("steps.$index.title")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="step_description_{{ $index }}">Description</label>
                                    <textarea name="steps[{{ $index }}][description]" id="step_description_{{ $index }}" 
                                              class="form-control" rows="2">{{ old("steps.$index.description", $step['description']) }}</textarea>
                                    @error("steps.$index.description")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="book_call_button_text">Book Call Button Text</label>
                    <input type="text" name="book_call_button_text" id="book_call_button_text" class="form-control"
                           value="{{ old('book_call_button_text', $content->book_call_button_text) }}">
                    @error('book_call_button_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Content</button>
            </form>
        </div>
    </div>
</div>
@endsection