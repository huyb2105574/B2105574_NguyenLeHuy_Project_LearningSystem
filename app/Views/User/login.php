<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/uploads/favicon.ico" type="image/png">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('uploads/background_login.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <h1 class="form-title">Đăng nhập</h1>
            <div id="message" class="mb-3"></div>
            <form id="loginForm" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Nhập mật khẩu" required>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="showPassword">
                        <label class="form-check-label" for="showPassword">Hiện mật khẩu</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </form>
            <div class="mt-3 text-center">
                <p>Bạn chưa có tài khoản? <a href="/registration/register">Đăng ký ngay!</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hiện/ẩn mật khẩu
            $('#showPassword').on('change', function() {
                const passwordField = $('#password');
                passwordField.attr('type', this.checked ? 'text' : 'password');
            });

            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Ngăn form gửi yêu cầu truyền thống

                $.ajax({
                    type: 'POST',
                    url: '/login',
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#message').html(''); // Xóa thông báo cũ
                        if (response.status === 'success') {
                            $('#message').html(
                                `<div class="alert alert-success">✔️ ${response.message}</div>`
                            );
                            setTimeout(function() {
                                window.location.href = '/home';
                            }, 2000); // Chuyển trang sau 2 giây
                        } else {
                            $('#message').html(
                                `<div class="alert alert-danger">❌ ${response.message}</div>`
                            );
                        }
                    },
                    error: function() {
                        $('#message').html(
                            '<div class="alert alert-danger">❌ Đã xảy ra lỗi, vui lòng thử lại!</div>'
                        );
                    }
                });
            });
        });
    </script>

</body>

</html>