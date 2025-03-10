@extends('admin.layouts.master')

@section('title')
    <title>Update Logo</title>
@endsection

@section('content')
    <div class="container">
        <h1>Update Logo</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($setting)
            <form action="{{ route('update.logo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="logo">Upload New Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>

                <div class="form-group mt-3">
                    <label for="logo_heading">Logo Heading</label>
                    <input type="text" name="logo_heading" id="logo_heading" class="form-control"
                        value="{{ $setting->logo_heading ?? '' }}">
                </div>

                @if ($setting && $setting->logo)
                    <img src="{{ asset($setting->logo) }}" alt="Current Logo" width="150">
                @endif

                <button class="btn btn-primary mt-3">Update Logo</button>
            </form>
        @else
            <p>No logo found.</p>
        @endif
    </div>
@endsection