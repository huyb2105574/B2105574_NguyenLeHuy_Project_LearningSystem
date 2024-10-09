<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa tài khoản</title>
</head>

<body>
    <h2>Chỉnh sửa tài khoản</h2>
    <form method="POST">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required>
        <br>

        <label for="full_name">Họ và tên:</label>
        <input type="text" id="full_name" name="full_name" value="<?= $user['full_name'] ?>" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required>
        <br>

        <label for="role">Vai trò:</label>
        <select id="role" name="role">
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="lecturer" <?= $user['role'] === 'lecturer' ? 'selected' : '' ?>>Giảng viên</option>
            <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Sinh viên</option>
        </select>
        <br><br>

        <input type="submit" value="Lưu thay đổi">
    </form>
</body>

</html>