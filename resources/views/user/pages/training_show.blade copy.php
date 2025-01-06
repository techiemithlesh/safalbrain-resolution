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
                How We Generated 173 High-Ticket Clients Last Month Totalling ₹1,98,01,580 In Sales Using The
            </h1>
            <h2 class="text-2xl md:text-3xl text-blue-600 font-bold">
                "Legacy Flywheel Matrix & Latest AI Technology"
            </h2>
        </div>

        <!-- Video Section -->


        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <div class="aspect-w-16 aspect-h-9 bg-gray-800 relative">
                <!-- Custom Video Player -->
                <video id="mainVideo" class="absolute inset-0 w-full h-full object-cover" preload="metadata">
                    <source src="{{ asset('uploads/test.mp4') }}" type="video/mp4">
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
                    Book a Call Now
                </button>
            </div>
        </div>

        <!-- Getting Started Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">How to get started</h3>
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold">1</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Watch the Complete Video</h4>
                        <p class="text-gray-600">Learn about our proven methodology and success stories</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold">2</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Book a Strategy Call</h4>
                        <p class="text-gray-600">Schedule a one-on-one session with our experts</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold">3</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Implement the Strategy</h4>
                        <p class="text-gray-600">Follow our proven framework to scale your business</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('mainVideo');
            const playButton = document.getElementById('playButton');
            const bookCallButton = document.getElementById('bookCallButton');

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
                // Check if video has played for at least 30 seconds
                if (video.currentTime >= 10) {
                    bookCallButton.classList.remove('hidden');
                    // Remove the listener after showing the button to prevent multiple calls
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
        });

        razorpayButton.addEventListener('click', function(e) {
            e.preventDefault();

            
            
            fetch('http://localhost/landing1/create-razorpay-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: 500,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const options = {
                        key: "{{ env('RAZORPAY_KEY') }}",
                        amount: data.amount,
                        currency: "INR",
                        name: "Your Company Name",
                        description: "Strategy Call Booking",
                        order_id: data.order_id,
                        handler: function(response) {
                            
                            fetch('http://localhost/landing1/verify-payment', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        
                                        window.location.href = '/payment-success';
                                    }
                                })
                                .catch(error => {
                                    console.error('Payment verification failed:', error);
                                    alert('Payment verification failed. Please contact support.');
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
                })
                .catch(error => {
                    console.error('Order creation failed:', error);
                    alert('Unable to initiate payment. Please try again.');
                });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            const video = document.getElementById('mainVideo');
            const playButton = document.getElementById('playButton');
            const bookCallButton = document.getElementById('bookCallButton');

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
            bookCallButton.addEventListener('click', function(e) {
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
                    success: function(response) {
                        console.log("data", response);
                        if (response.status === 'success') {
                            const options = {
                                key: "{{ env('RAZORPAY_KEY') }}",
                                amount: response.amount,
                                currency: "INR",
                                name: "safalbrain",
                                description: "Strategy Call Booking",
                                order_id: response.order_id,
                                handler: function(response) {

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
                                                    .razorpay_signature
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {

                                                window.location.href =
                                                    '/payment-success';
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
                    error: function(error) {
                        console.error('Order creation failed:', error);
                        alert('Unable to initiate payment. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
