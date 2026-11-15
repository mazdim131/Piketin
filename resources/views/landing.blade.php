@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 420px;">
            <div class="card-body">
                <h3 class="mb-3 text-center">Masuk ke Room Piket</h3>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('room.join') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="token" class="form-label">Token Room</label>
                        <input type="text" name="token" id="token"
                            class="form-control @error('token') is-invalid @enderror"
                            value="{{ old('token') }}" required autofocus>
                        @error('token')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
@endsection
