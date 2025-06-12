@extends('admin.layout.main')
@section('title', 'Change Password');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <h4 class="error">{{ $error }}</h4>
                @endforeach
            @endif
        </div>

        <form method="post" action="{{ route('Admin.UpdatePassword') }}" id="changePasswordForm"
            class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            @csrf

            <div class="card card-sec-bg-main">
                <div class="card-body">
                    <h2 class="card-title text-center">Change Password</h2>

                    <!-- Current Password -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="currentpassword" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="currentpassword" id="currentpassword"
                                    required>
                                <span class="input-group-text">
                                    <i class="bi bi-eye-slash toggle-password" data-target="#currentpassword"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">Please enter current password</div>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 position-relative form-input-wrap mt-3">
                            <label for="newpassword" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                                <span class="input-group-text">
                                    <i class="bi bi-eye-slash toggle-password" data-target="#newpassword"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">Please enter new password</div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 position-relative form-input-wrap mt-3">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword"
                                    required>
                                <span class="input-group-text">
                                    <i class="bi bi-eye-slash toggle-password" data-target="#confirmpassword"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">Please confirm your password</div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </div>

        </form>
    </section>

@endsection
@push('js')
    <script>
        var propurl = "{{ route('Admin.GetUserProperties') }}";
    </script>
    <script>
        $(document).ready(function() {
            const $form = $('#changePasswordForm');
            const $newPassword = $('#newpassword');
            const $confirmPassword = $('#confirmpassword');

            $form.on('submit', function(e) {
                let valid = true;

                // Reset custom validation messages
                $newPassword[0].setCustomValidity('');
                $confirmPassword[0].setCustomValidity('');

                // Check minimum length
                if ($newPassword.val().length < 8) {
                    $newPassword[0].setCustomValidity('Password must be at least 8 characters.');
                    $newPassword[0].reportValidity();
                    valid = false;
                }

                // Check if passwords match
                if ($newPassword.val() !== $confirmPassword.val()) {
                    $confirmPassword[0].setCustomValidity('Passwords do not match.');
                    $confirmPassword[0].reportValidity();
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault(); // Stop form submission
                }
            });

            // Toggle password visibility
            $('.toggle-password').on('click', function() {
                const $targetInput = $($(this).data('target'));
                const isPassword = $targetInput.attr('type') === 'password';
                $targetInput.attr('type', isPassword ? 'text' : 'password');
                $(this).toggleClass('bi-eye bi-eye-slash');
            });
        });
    </script>
@endpush
