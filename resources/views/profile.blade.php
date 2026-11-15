@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-page-avatar">
                    {{ strtoupper(substr($user->username ?? 'U', 0, 1)) }}
                </div>

                <div>
                    <h1 class="profile-name">{{ $user->username }}</h1>
                    <p class="profile-role">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="profile-body">
                <div class="profile-row">
                    <span class="profile-label">Nama</span>
                    <span class="profile-value">{{ $user->username }}</span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">Email</span>
                    <span class="profile-value">{{ $user->email }}</span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">NIS</span>
                    <span class="profile-value">{{ $user->nis }}</span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">Role</span>
                    <span class="profile-value">{{ ucfirst($user->role) }}</span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">Room Token</span>
                    <span class="profile-value">
                        {{ $user->room_id }}
                    </span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">Bergabung</span>
                    <span class="profile-value">
                        {{ $user->created_at?->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    @vite(['resources/css/profile.css'])
@endpush
