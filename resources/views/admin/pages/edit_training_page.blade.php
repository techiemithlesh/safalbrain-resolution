@extends('admin.layouts.master')

@section('title')
    <title>Edit Landing Page Content</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Edit Landing Page Content</h6>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStepModal">
                    <i class="fas fa-plus"></i>
                </button>
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

                    <div class="form-group">
                        <label>Steps</label>
                        <div id="steps-container">
                            @foreach($content->steps as $index => $step)
                                <div class="card mb-3 step-item">
                                    <div class="card-body position-relative">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-step">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <h6 class="card-title">Step {{ $index + 1 }}</h6>
                                        <div class="form-group">
                                            <label for="step_title_{{ $index }}">Title</label>
                                            <input type="text" name="steps[{{ $index }}][title]" class="form-control" value="{{ old("steps.$index.title", $step['title']) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="step_description_{{ $index }}">Description</label>
                                            <textarea name="steps[{{ $index }}][description]" class="form-control" rows="2">{{ old("steps.$index.description", $step['description']) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Content</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Step Modal -->
    <div class="modal fade" id="addStepModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Step</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_step_title">Title</label>
                        <input type="text" id="new_step_title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_step_description">Description</label>
                        <textarea id="new_step_description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveStep">Save Step</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (First) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        
        $(document).ready(function () {
            let stepIndex = $(".step-item").length;

            // Add Step
            $("#saveStep").click(function () {
                let title = $("#new_step_title").val();
                let description = $("#new_step_description").val();
                
                if (title && description) {
                    let newStep = `
                        <div class="card mb-3 step-item">
                            <div class="card-body position-relative">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-step">
                                    <i class="fas fa-times"></i>
                                </button>
                                <h6 class="card-title">Step ${stepIndex + 1}</h6>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="steps[${stepIndex}][title]" class="form-control" value="${title}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="steps[${stepIndex}][description]" class="form-control" rows="2">${description}</textarea>
                                </div>
                            </div>
                        </div>`;

                    $("#steps-container").append(newStep);
                    stepIndex++;
                    $("#addStepModal").modal("hide");
                    $("#new_step_title").val("");
                    $("#new_step_description").val("");
                } else {
                    alert("Please fill out both fields.");
                }
            });

            // Remove Step
            $(document).on("click", ".remove-step", function () {
                $(this).closest(".step-item").remove();
            });
        });
    </script>
@endsection
