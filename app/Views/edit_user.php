<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản</title>
    <!-- Liên kết Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Chỉnh sửa tài khoản</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?= $user['username'] ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Họ và tên:</label>
                <input type="text" id="full_name" name="full_name" class="form-control"
                    value="<?= $user['full_name'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Vai trò:</label>
                <select id="role" name="role" class="form-select">
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="lecturer" <?= $user['role'] === 'lecturer' ? 'selected' : '' ?>>Giảng viên</option>
                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Sinh viên</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>

    <!-- Liên kết Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>