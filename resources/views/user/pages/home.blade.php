@extends('user.layout.master')

@section('content')
    <!-- Logo Section -->
    @include('user.layout.navbar')

    <!-- Title Section -->
    <div class="text-center max-w-4xl mx-auto mb-12">
        <h2 class="text-xl text-gray-700 mb-6">
            {{ $content->subtitle }}
        </h2>
        <p class="text-xl font-semibold text-gray-800 mb-8">
            {{ $content->non_target_text }}
        </p>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            {{ $content->main_title }}
        </h1>
        <p class="text-2xl md:text-3xl font-bold text-blue-600">
            "{{ $content->highlighted_text }}"
        </p>
    </div>

    <!-- Registration Form -->
    <div class="max-w-xl mx-auto">
        <form class="space-y-6" id="interestForm">
            <div>
                <input type="text" placeholder="Name" name="full_name" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div>
                <input type="email" placeholder="Email Address" name="email" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div>
                <input type="tel" placeholder="Phone" name="phone"required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <button type="submit" id="submitButton"
                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                Register For The Training Now
            </button>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $('#interestForm').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitButton = $('#submitButton');
            const fullName = $('input[name="full_name"]').val().trim();
            const email = $('input[name="email"]').val().trim();
            const phone = $('input[name="phone"]').val().trim();

            // Regular Expressions for Validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[6-9]\d{9}$/; // Indian mobile number format
            let errors = [];

            // Validate Name
            if (fullName.length < 3) {
                errors.push("Name must be at least 3 characters long.");
            }

            // Validate Email ONLY if entered
            if (email.length > 0 && !emailPattern.test(email)) {
                errors.push("Please enter a valid email address.");
            }

            // Validate Phone (Mandatory)
            if (!phonePattern.test(phone)) {
                errors.push("Please enter a valid 10-digit mobile number.");
            }

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errors.join("\n")
                });
                return;
            }

            // Disable submit button
            $submitButton.prop('disabled', true).text('Processing...');

            $.ajax({
                url: '/register-interest',
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then(() => {
                            setTimeout(() => {
                                window.location.href = "{{ route('training.show') }}";
                            }, 30);
                        });
                    } else {
                        let errorMessage = response.message || 'An error occurred.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage
                        });
                    }
                    $submitButton.prop('disabled', false).text('Register For The Training Now');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage
                        });
                    } else {
                        alert('An error occurred while submitting your interest.');
                    }
                },
                complete: function() {
                    $submitButton.prop('disabled', false).text('Register For The Training Now');
                }
            });
        });
    });
</script>


@endsection
