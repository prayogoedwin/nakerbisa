<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN NAKERBISA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #339BF1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 100%;
        }

        .btn-primary {
            background-color: #005c99;
            border-color: #005c99;
        }

        .btn-primary:hover {
            background-color: #00487a;
            border-color: #00487a;
        }

        .captcha-image {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            height: 50px;
            background-color: #ddd;
            text-align: center;
            line-height: 50px;
            font-size: 24px;
            font-weight: bold;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="text-center mb-4">Login</h2>
        <form action="{{ route('login.action') }}" method="POST">
            @csrf <!-- Laravel CSRF token for security -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <input type="checkbox" id="show-password"><small>Lihat Kata Sandi</small>
            </div>
            <!-- <div class="mb-3">
        <div class="captcha-image">AB12CD</div>
        <label for="captcha" class="form-label">Captcha</label>
        <input type="text" class="form-control" id="captcha" placeholder="Enter the text shown" required>
      </div> -->

            <div class="mb-3">
                <label for="captcha" class="form-label">Captcha</label>
                <div>
                    <img src="{{ captcha_src() }}" id="captchaImage" alt="captcha" class="mb-2">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="refreshCaptcha()">Refresh</button>
                </div>
                <input type="text" name="captcha" class="form-control" id="captcha" required
                    placeholder="Enter the text shown">
                @if ($errors->has('captcha'))
                    <span class="text-danger">{{ $errors->first('captcha') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function refreshCaptcha() {
            location.reload(); // Fungsi untuk menyegarkan halaman
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#show-password").change(function() {
                $(this).prop("checked") ? $("#password").prop("type", "text") : $("#password").prop("type",
                    "password");
            });
        });
    </script>
</body>

</html>
