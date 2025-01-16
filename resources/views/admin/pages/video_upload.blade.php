@extends('admin.layouts.master')

@section('title')
    <title>Admin - Video Upload</title>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Upload Video</h1>

        <!-- Display success message -->
        <div id="uploadSuccess" class="alert alert-success" style="display: none;"></div>

        <!-- Display error message -->
        <div id="uploadError" class="alert alert-danger" style="display: none;"></div>

        <form id="videoUploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="video">Select Video</label>
                <input type="file" name="video" id="video" class="form-control" required>
                <span id="videoError" class="text-danger"></span>
                <small class="form-text text-muted">
                    Supported formats: MP4, MOV, AVI, WMV (Max size: 20MB)
                </small>
            </div>

            @if ($setting && $setting->video_link)
                <div class="form-group">
                    <label>Current Video:</label>
                    <video width="320" height="240" controls>
                        <source src="{{ asset($setting->video_link) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endif

            <div class="form-group">
                <button type="button" id="uploadBtn" class="btn btn-primary">Upload Video</button>
            </div>

            <!-- Progress Bar -->
            <div class="progress mt-3" style="height: 20px; display: none;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Script loaded');

            const uploadBtn = document.getElementById('uploadBtn');
            if (!uploadBtn) {
                console.error('Upload button not found');
                return;
            }

            uploadBtn.addEventListener('click', function() {
                console.log('Upload button clicked');

                const form = document.getElementById('videoUploadForm');
                const formData = new FormData(form);
                const videoInput = document.getElementById('video');
                const progressBar = document.querySelector('.progress');
                const progressBarInner = document.querySelector('.progress-bar');
                const uploadSuccess = document.getElementById('uploadSuccess');
                const uploadError = document.getElementById('uploadError');
                const videoError = document.getElementById('videoError');

                // Reset previous states
                videoError.innerHTML = '';
                uploadSuccess.style.display = 'none';
                uploadError.style.display = 'none';
                progressBar.style.display = 'block';
                progressBarInner.style.width = '0%';
                progressBarInner.setAttribute('aria-valuenow', '0');

                if (!videoInput.files[0]) {
                    videoError.innerHTML = 'Please select a video file.';
                    progressBar.style.display = 'none';
                    return;
                }

                // Log the route URL
                const uploadUrl = '{{ route('video.upload') }}';
                console.log('Upload URL:', uploadUrl);

                // Make the AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open('POST', uploadUrl, true);

                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                if (!token) {
                    console.error('CSRF token not found');
                    uploadError.style.display = 'block';
                    uploadError.innerHTML = 'CSRF token not found';
                    return;
                }

                xhr.setRequestHeader('X-CSRF-TOKEN', token);

                // Update the progress bar
                xhr.upload.addEventListener('progress', function(e) {
                    console.log('Upload progress:', e.loaded, '/', e.total);
                    if (e.lengthComputable) {
                        const percentComplete = Math.round((e.loaded / e.total) * 100);
                        progressBarInner.style.width = percentComplete + '%';
                        progressBarInner.setAttribute('aria-valuenow', percentComplete);
                        progressBarInner.innerHTML = percentComplete + '%';
                    }
                });

                // Handle upload completion
                xhr.onload = function() {
                    console.log('Response status:', xhr.status);
                    console.log('Response text:', xhr.responseText);

                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                progressBarInner.classList.add('bg-success');
                                uploadSuccess.style.display = 'block';
                                uploadSuccess.innerHTML = response.message;
                                // Reload page to show new video
                                setTimeout(() => window.location.reload(), 2000);
                            } else {
                                progressBarInner.classList.add('bg-danger');
                                uploadError.style.display = 'block';
                                uploadError.innerHTML = response.message;
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            uploadError.style.display = 'block';
                            uploadError.innerHTML = 'Error processing server response';
                        }
                    } else {
                        progressBarInner.classList.add('bg-danger');
                        uploadError.style.display = 'block';
                        uploadError.innerHTML = 'Error uploading video. Please try again.';
                    }
                };

                // Handle errors
                xhr.onerror = function(e) {
                    console.error('XHR error:', e);
                    progressBarInner.classList.add('bg-danger');
                    uploadError.style.display = 'block';
                    uploadError.innerHTML = 'Network error. Please check your connection.';
                };

                // Log before sending
                console.log('Sending form data...');

                // Send the form data
                try {
                    xhr.send(formData);
                } catch (e) {
                    console.error('Error sending form data:', e);
                    uploadError.style.display = 'block';
                    uploadError.innerHTML = 'Error sending form data';
                }
            });
        });
    </script>
@endsection
