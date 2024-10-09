<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-primary text-white py-2">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand text-white" href="/home">Learning</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <!-- Hiển thị nút quản lý tài khoản nếu người dùng là admin -->
                        <?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/user">Quản lý tài khoản</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/home">Trang Chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/courses">Khóa Học</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/profile">Hồ Sơ</a>
                        </li>
                        <?php if (isset($userData['full_name'])): ?>
                        <li class="nav-item">
                            <span class="nav-link text-white">Chào,
                                <?= htmlspecialchars($userData['full_name']); ?>!</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/logout">Đăng Xuất</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="mb-4">Danh sách tài khoản</h2>

        <!-- Nút Tạo Tài Khoản -->
        <div class="mb-3">
            <a href="/user/create" class="btn btn-success">Tạo tài khoản mới</a>
        </div>

        <!-- Bảng danh sách tài khoản -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['full_name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <a href="/user/edit/<?= $user['user_id'] ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                        <a href="/user/delete/<?= $user['user_id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>