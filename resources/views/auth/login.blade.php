<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login | Url Shortner</title>

  {{-- {{ dd(request()->getSchemeAndHttpHost().'/test/url') }} --}}

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  {{-- <!-- Font Awesome Icons --> --}}
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?v=3.2.0') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    {{-- @include('alert') --}}
    <div class="card-header text-center">
      <a href="javascript:void(0);" class="h1"><b>Url Shortner</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Login here</p>

      <form id="login_form">

        <div class="input-group mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Email">
          <p class="errors"></p>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password">
          <p class="errors"></p>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember_me" name="remember_me">
                  <label for="remember_me">
                    Remember Me
                  </label>
                </div>
            </div>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      {{-- <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> --}}
      {{-- <a href="{{ route('admin.reg_index') }}" class="text-center">Don't have an account ?</a> --}}
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
{{-- <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        const $loginForm = $("#login_form");
        const $submitButton = $("button[type=submit]");
        const $inputs = $("input[type='email'], input[type='password']");

        // Basic client-side validation before submission
        function validateForm() {
            let isValid = true;
            const errors = {};

            // Email validation
            const email = $("#email").val().trim();
            if (!email) {
                errors.email = "Email is required";
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errors.email = "Please enter a valid email address";
                isValid = false;
            }

            // Password validation
            const password = $("#password").val();
            if (!password) {
                errors.password = "Password is required";
                isValid = false;
            }

            if (!isValid) {
                handleFormErrors(errors);
            }

            return isValid;
        }

        // Error handling and auto-focus functionality
        function handleFormErrors(errors) {
            // Reset previous error states
            $(".errors").removeClass('invalid-feedback').html('');
            $inputs.removeClass('is-invalid');

            // If errors exist
            if (Object.keys(errors).length > 0) {
                // Find the first error field
                const firstErrorKey = Object.keys(errors)[0];
                const $firstErrorField = $(`#${firstErrorKey}`);

                // Focus on the first error field
                $firstErrorField.focus();

                // Display errors
                $.each(errors, function(key, value) {
                    const $field = $(`#${key}`);
                    $field.addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(value);
                });
            }
        }

        // Real-time error removal
        $inputs.on('input change', function() {
            const $this = $(this);

            // Remove error styling when user starts typing
            if ($this.val().trim() !== '') {
                $this.removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
            }
        });

        // Form submission handler
        $loginForm.on('submit', function(event) {
            event.preventDefault();

            // Perform client-side validation first
            if (!validateForm()) {
                return false;
            }

            const $form = $(this);

            // Disable submit button and show loading state
            $submitButton
                .prop('disabled', true)
                .html('<span class="inline-block animate-spin mr-2">⌛</span> Logging in...');

            $.ajax({
                url: '{{ route("admin.login_store") }}',
                type: 'POST',
                data: $form.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    // Reset button state
                    $submitButton
                        .prop('disabled', false)
                        .text('Login');

                    if (response.status === true) {
                        // Show success message briefly before redirect
                        let Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        Toast.fire({
                            icon: 'success',
                            title: response.message || 'Login successful!'
                        });

                        // Redirect to dashboard after success message
                        setTimeout(function() {
                            window.location.href = response.redirect || "{{ route('dashboard.index') }}";
                        }, 2000);
                    } else {
                        // Handle validation errors
                        if (response.errors) {
                            handleFormErrors(response.errors);
                        }

                        if(response.unauthorized === true) {
                            let Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'warning',
                                title: response.message || 'Invalid credentials'
                            });
                        }

                        // Handle credential errors
                        if (response.credential === true) {
                            let Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'error',
                                title: response.message || 'Invalid credentials'
                            });

                            // If remaining attempts info is available, show it
                            if (response.remainingAttempts) {
                                $("#password").siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(`Invalid password. ${response.remainingAttempts} attempts remaining.`);
                            }
                        }

                        // Handle too many attempts
                        if (response.tooManyAttempts) {
                            let Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000
                            });

                            Toast.fire({
                                icon: 'warning',
                                title: response.message
                            });

                            // Disable form for retry period
                            $inputs.prop('disabled', true);
                            $submitButton.prop('disabled', true);

                            // Enable form after retry period
                            if (response.retryAfter) {
                                setTimeout(function() {
                                    $inputs.prop('disabled', false);
                                    $submitButton.prop('disabled', false);
                                }, response.retryAfter * 1000);
                            }
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Reset button state
                    $submitButton
                        .prop('disabled', false)
                        .text('Login');

                    let errorMessage = "An error occurred. Please try again.";

                    // Handle rate limiting error
                    if (jqXHR.status == 429) {
                        errorMessage = jqXHR.responseJSON?.message || "Too many login attempts. Please try again later.";

                        let Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000
                        });

                        Toast.fire({
                            icon: 'warning',
                            title: errorMessage
                        });
                    } else {
                        // Handle other errors
                        let Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }

                    // Log detailed error for debugging
                    console.error("Login Error:", {
                        status: jqXHR.status,
                        statusText: jqXHR.statusText,
                        responseText: jqXHR.responseText
                    });
                }
            });
        });
    });


</script> --}}
</body>
</html>







{{-- Start Old Code. --}}
