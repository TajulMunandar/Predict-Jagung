<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logos/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <title>Register | Predict Jagung</title>
</head>

<body class="bg-light">
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">

                <div class="row">
                    <div class="col-sm-6 col-md">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif (session()->has('failed'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('failed') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card -->
                <div class="card smooth-shadow-md">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <a href="#" class="d-flex justify-content-center">
                                <dotlottie-player
                                    src="https://lottie.host/7511d062-015a-4337-a071-478cabad0435/gnvoCveMOK.json"
                                    background="transparent" speed="1" style="width: 250px; height: 250px;" loop
                                    autoplay></dotlottie-player>
                            </a>
                            <p class="mb-5">Please enter your user information.</p>
                        </div>
                        <!-- Form -->
                        <form action="/register" method="post">
                            @csrf
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" name="name"
                                    id="name" placeholder="Enter your name" value="{{ old('name') }}" required
                                    autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input class="form-control @error('username') is-invalid @enderror" name="username"
                                    id="username" placeholder="Enter your username" value="{{ old('username') }}"
                                    required autofocus>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" type="password" placeholder="••••••••" name="password"
                                    id="password" required>
                            </div>
                            <!-- Checkbox -->
                            <div class="d-lg-flex justify-content-between align-items-center mb-4">
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" id="showpsd">
                                    <label class="form-check-label" for="showpsd">Show Password</label>
                                </div>
                                <a href="/login">Sign In</a>
                            </div>
                            <div>
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('js/theme.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#showpsd').click(function() {
                $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type',
                    'password');
            });
        });
    </script>
</body>

</html>
