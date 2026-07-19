<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Saree-Info') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

            <!-- Scripts -->
            @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <style>
            body, html {
                height: 100%;
                font-family: 'Nunito', sans-serif;
            }

            .login-wrapper {
                padding: 40px 20px;
                background-color: #f8f9fa;
                min-height: 82vh;
            }

            .login-card {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .login-image {
                height: 100%;
                width: 100%;
                object-fit: cover;
            }

            .form-section {
                padding: 40px;
            }

            .toggle-password {
                position: absolute;
                top: 50px;
                right: 12px;
                transform: translateY(-50%);
                cursor: pointer;
                color: #888;
            }

            .password-wrapper {
                position: relative;
            }

            .btn-primary {
                background-color: #38B2AC;
                border-color: #38B2AC;
            }

            .btn-primary:hover {
                background-color: #2c9a98;
                border-color: #2c9a98;
            }
            input:invalid {
                background-image: none !important;
            }

            input.is-invalid {
                background-image: none !important;
            }

        </style>
    </head>

    <body>
        <div class="container">
            <div class="login-wrapper">
                <h2 class="text-center mb-4"><strong>Welcome to Saree Portal</strong></h2>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row login-card">
                            <!-- Left: Form -->
                             <!-- Success/Error messages -->
                             <div id="loginMessage" class="mt-3"></div>
                             
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-section w-100">
                                <h3 class="text-center mb-5">Sign in to Saree Portal</h3>
                                    <form id="login_form">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email or Username</label>
                                            <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                           
                                        </div>

                                        <div class="mb-3 password-wrapper">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                                            <span class="toggle-password">
                                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                            </span>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">Remember me</label>
                                            </div>
                                            <a href="{{-- route('password.request') --}}" >Forgot password?</a>
                                        </div>

                                        <div class="d-grid mb-3">
                                            <button type="submit" class="btn btn-primary">Sign in</button>
                                        </div>

                                        <div class="d-grid mb-3">
                                            <button class="btn btn-light border">
                                                <i class="fab fa-google me-2"></i> Sign in with Google
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Right: Image -->
                            <div class="col-md-6 d-none d-md-block p-0">
                                <img src="{{ asset('images/side_img.png') }}" alt="Login Illustration" class="login-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<script>
    // <!-- JS: Password Toggle -->
    const togglePassword = document.getElementById('togglePasswordIcon');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') == 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    $(document).ready(function () {

        $('#login_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 7,
                }
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address",
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Your password must be at least 7 characters long",
                }
            },
            errorElement: 'strong',
            errorPlacement: function (error, element) {
                if (element.attr("name") == "email") {
                    $('.email-error').show().html(error);
                } else if (element.attr("name") == "password") {
                    $('.password-error').show().html(error);
                }
                element.addClass('is-invalid');
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // Clear previous errors
                $('.email-error, .password-error').hide().html('');
                $('input').removeClass('is-invalid');

                let email       = $('#email').val();
                let password    = $('#password').val();
                let remember    = $('#remember').is(':checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('admin.auth.login') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },  
                    data: {
                        email: email,
                        password: password,
                        remember: remember,
                    },

                    success: function (response) {
                        if(response.success) {
                            window.location.href = response.redirect_url || "{{ route('admin.dashboard') }}";
                        } else {
                            $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                                $('.email-error').show().html('<strong>' + errors.email[0] + '</strong>');
                            }
                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                                $('.password-error').show().html('<strong>' + errors.password[0] + '</strong>');
                            }
                        } else if (xhr.status == 401 || xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message || "Login failed");
                        } else {
                            alert("Something went wrong");
                        }
                    }
                });
            }
        });
    });
</script>
