<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>RAFIKA | Login</title>
    <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ url('/assets/images/logo.png') }}">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="{{ url('/assets/images/logo.png') }}">

    <!-- style -->
    <link rel="stylesheet" href="{{ url('/assets/animate.css/animate.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('/assets/glyphicons/glyphicons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('/assets/font-awesome/css/font-awesome.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('/assets/material-design-icons/material-design-icons.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ url('/assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" />
    <!-- build:css ../assets/styles/app.min.css -->
    <link rel="stylesheet" href="{{ url('/assets/styles/app.css') }}" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ url('/assets/styles/font.css') }}" type="text/css" />

    <style>
        body {
            background-image: url('/assets/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="app" id="app">

        <!-- ############ LAYOUT START-->
        <div class="center-block w-xxl w-auto-xs p-y-md">
            <div class="navbar">
                <div class="pull-center">
                    <div ui-include="'{{ url('../views/blocks/navbar.brand.html') }}'"></div>
                </div>
            </div>
            <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
                <div class="m-b text-sm">
                    Sign in with your RAFIKA Account
                </div>
                <form name="form" action="{{ url('login') }}" method="POST">
                    @csrf
                    <div class="md-form-group float-label">
                        <input type="text" class="md-input" id="username" name="username" required>
                        <label>Username</label>
                    </div>
                    <div class="md-form-group float-label">
                        <input type="password" class="md-input" id="password" name="password" required>
                        <label>Password</label>
                    </div>
                    {{-- <div class="m-b-md">
                        <label class="md-check">
                            <input type="checkbox" name="keep-session"><i class="primary"></i> Keep me signed in
                        </label>
                    </div> --}}
                    <button type="submit" class="btn primary btn-block p-x-md" style="cursor: pointer;">Sign in</button>
                </form>
                <div class="p-v-lg text-center mt-4">
                    <div><a ui-sref="access.forgot-password" href="#" class="text-primary _600">Forgot password?</a></div>
                </div>
            </div>

        </div>
    </div>

    <!-- ############ LAYOUT END-->

    </div>
    @include('template.footer')
</body>

</html>