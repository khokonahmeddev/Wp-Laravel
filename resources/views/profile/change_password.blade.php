@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Change Password</h5>
                    </div>

                    <div class="card-body">
                        {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Change Password Form --}}
                        <form method="POST" action="{{ route('password.update') }}" class="needs-validation d-flex flex-column gap-3" novalidate>
                            @csrf

                            {{-- Current Password --}}
                            <div class="mb-1">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password"
                                       name="current_password"
                                       placeholder="Enter your current password"
                                       required autocomplete="current-password">
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="mb-1">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password"
                                       name="new_password"
                                       placeholder="Enter new password"
                                       required autocomplete="new-password">
                                @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-1">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                                       id="confirm_password"
                                       name="confirm_password"
                                       placeholder="Confirm new password"
                                       required>
                                @error('confirm_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            let forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>
@endsection
