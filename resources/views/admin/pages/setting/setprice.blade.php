@extends('admin.layouts.master')

@section('title')
    <title>Update Price</title>
@endsection

@section('content')
    <div class="container">
        <h1>Update Price</h1>

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
    
    @if ($price)
            <form action="{{route('updateprice')}}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" value="{{ $price->price }}">
                </div>

                <button class="btn btn-primary">Update Price</button>
            </form>
        @else
            <p>No settings found.</p>
        @endif
    
    </div>
@endsection