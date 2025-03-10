@extends('user.layout.master')

<style>
    .aspect-w-16.aspect-h-9 {
        position: relative;
        padding-bottom: 56.25%;
        /* 9/16 = 0.5625 */
        height: 0;
    }
</style>


@section('content')
    @include('user.layout.navbar')
    <div class="max-w-4xl mx-auto">
        <!-- Title Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                {{ $content->main_title }}
            </h1>
            <h2 class="text-2xl md:text-3xl text-blue-600 font-bold">
                {{ $content->subtitle }}
            </h2>
        </div>

        <!-- Video Section -->


        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <div class="aspect-w-16 aspect-h-9 bg-gray-800 relative">
                <!-- Custom Video Player -->
                <video id="mainVideo" class="absolute inset-0 w-full h-full object-cover" preload="metadata">
                    <source src="{{ asset($settings->video_link ?? 'uploads/test.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <div id="playButton" class="absolute inset-0 flex items-center justify-center cursor-pointer">
                    <div
                        class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div id="bookCallButton" class="hidden p-4 text-center">
                <button id="razorpayButton" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ $content->book_call_button_text }}
                </button>
            </div>
        </div>

        <!-- Getting Started Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">How to get started</h3>
            <div class="space-y-6">
                @foreach ($content->getFormattedSteps() as $step)
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold">{{ $step['number'] }}</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $step['title'] }}</h4>
                            <p class="text-gray-600">{{ $step['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Thank You Modal --}}

    <div id="successModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-green-500 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Thank You for Your Payment!</h3>
                    <p class="text-gray-600 mb-6">Your strategy call has been booked successfully. We'll be in touch shortly
                        with next steps.</p>
                    <button onclick="closeModal()"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function closeModal() {
            // console.log("Close");
            document.getElementById('successModal').classList.add('hidden');
        }

        $(document).ready(function () {
            const video = document.getElementById('mainVideo');
            const playButton = document.getElementById('playButton');
            const bookCallButton = document.getElementById('bookCallButton');

            function showSuccessModal() {
                document.getElementById('successModal').classList.remove('hidden');
            }

            // showSuccessModal();

            if (!video || !playButton || !bookCallButton) {
                console.error('Required elements not found');
                return;
            }

            // Play button click handler
            playButton.addEventListener('click', () => {
                video.play().then(() => {
                    playButton.style.display = 'none';
                }).catch((error) => {
                    console.error('Error playing video:', error);
                    playButton.style.display = 'flex';
                });
            });

            // Time update handler for showing the book call button
            video.addEventListener('timeupdate', () => {
                if (video.currentTime >= 10) {
                    bookCallButton.classList.remove('hidden');
                    video.removeEventListener('timeupdate', arguments.callee);
                }
            });

            // Handle video completion
            video.addEventListener('ended', () => {
                playButton.style.display = 'flex';
                bookCallButton.classList.remove('hidden');
            });

            // Optional: Add play/pause toggle on video click
            video.addEventListener('click', () => {
                if (video.paused) {
                    video.play();
                    playButton.style.display = 'none';
                } else {
                    video.pause();
                    playButton.style.display = 'flex';
                }
            });


            // Book call button click handler
            bookCallButton.addEventListener('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/create-razorpay-order',
                    method: 'POST',
                    data: {
                        amount: 500
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log("data", response);
                        if (response.status === 'success') {
                            const options = {
                                key: "{{ env('RAZORPAY_KEY') }}",
                                amount: response.amount,
                                currency: "INR",
                                name: "safalbrain",
                                description: "Strategy Call Booking",
                                order_id: response.order_id,
                                handler: function (response) {

                                    fetch('/verify-payment', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document
                                                .querySelector(
                                                    'meta[name="csrf-token"]')
                                                .content
                                        },
                                        body: JSON.stringify({
                                            razorpay_payment_id: response
                                                .razorpay_payment_id,
                                            razorpay_order_id: response
                                                .razorpay_order_id,
                                            razorpay_signature: response
                                                .razorpay_signature,
                                            name: 'User Name',
                                            email: 'user@example.com',
                                            phone: '1234567890'
                                        })
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log("SUCCEJFJFJ", data);
                                            if (data.success && data.showModal) {
                                                showSuccessModal();
                                            } else {
                                                alert(data.message);
                                            }
                                        })
                                        .catch(error => {
                                            console.error(
                                                'Payment verification failed:',
                                                error);
                                            alert(
                                                'Payment verification failed. Please contact support.'
                                            );
                                        });
                                },
                                prefill: {
                                    name: "",
                                    email: "",
                                    contact: ""
                                },
                                theme: {
                                    color: "#3399cc"
                                }
                            };
                            const rzp1 = new Razorpay(options);
                            rzp1.open();

                        } else {
                            alert(
                                'An error occurred while creating the payment order. Please try again.'
                            );
                        }
                    },
                    error: function (error) {
                        console.error('Order creation failed:', error);
                        alert('Unable to initiate payment. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection