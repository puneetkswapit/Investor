<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='{{ asset('admin/assets/css/login.css') }}'>
    <script src='main.js'></script>
</head>

<body>
    <div class="admin-login-main section-scace-top">
        <div class="admin-login-inner">
            <div class="logo"><img alt="site-logo" src="{{ asset('admin/images/image002.png') }}"> </div>
            <div class="heading">
                <h1>Admin Login</h1>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p style="color: red">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </p>
                </div>
            @endif
            <div class="login-from">
                <form action="{{ route('AuthAdminLogin') }}" method="post">
                    @csrf
                    <div class="form-input">
                        <label>Email address</label>
                        <input type="text" name="email" id="email" placeholder="Enter Email">
                    </div>
                    <div class="form-input">
                        <label>Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password">
                    </div>
                    <div class="form-button ctm-mt-20">
                        <button type="submit" class="common-primary-button">Login</button>
                    </div>
                    <div class="forgot-password ctm-mt-10">
                        <a href="#!" class="forgot-password-btn">Forgot Password</a>
                    </div>
                </form>
            </div>
            <div>
            </div>

            <footer>
                <p class="ctm-mt-10"> &copy; {{ date('Y') }} TAAS Investments, L.L.C.</p>
            </footer>

            <style>

            </style>
</body>

</html>
