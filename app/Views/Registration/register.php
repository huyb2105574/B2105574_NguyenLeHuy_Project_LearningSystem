<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <!-- Liên kết Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../uploads/background_login.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .registration-container {
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

        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group label {
            flex: 1;
            margin-right: 10px;
        }

        .form-group input,
        .form-group select {
            flex: 2;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="registration-container">
            <h1 class="form-title">Đăng Ký Tài Khoản</h1>
            <div id="message" class="mb-3"></div>
            <form id="registrationForm" method="POST">
                <div class="form-group">
                    <label for="full_name">Họ và tên:</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" required
                        placeholder="Họ và tên">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control"
                        placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Địa chỉ">
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Ngày sinh:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                </div>
                <div class="form-group">
                    <label for="role">Vai trò:</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="student">Sinh viên</option>
                        <option value="lecturer">Giảng viên</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi Đăng Ký</button>
            </form>
            <div class="mt-3 text-center">
                <p>Bạn đã có tài khoản? <a href="/login">Đăng nhập ngay!</a></p>
            </div>
        </div>
    </div>

    <!-- Liên kết Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(event) {
                event.preventDefault(); // Ngăn form gửi yêu cầu truyền thống

                $.ajax({
                    type: 'POST',
                    url: '/registration/register',
                    data: {
                        full_name: $('#full_name').val(),
                        email: $('#email').val(),
                        phone_number: $('#phone_number').val(),
                        address: $('#address').val(),
                        date_of_birth: $('#date_of_birth').val(),
                        role: $('#role').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#message').html(''); // Xóa thông báo cũ
                        if (response.status === 'success') {
                            $('#message').html(
                                `<div class="alert alert-success">✔️ ${response.message}</div>`
                            );
                            setTimeout(function() {
                                window.location.href =
                                    '/login'; // Chuyển hướng đến trang đăng nhập sau 2 giây
                            }, 2000);
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