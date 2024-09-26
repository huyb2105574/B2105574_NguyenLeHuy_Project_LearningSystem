<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Học Tập</title>
    <link rel="stylesheet" href="/public/styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-primary text-white py-2">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand text-white" href="/home">Learning</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <!-- Hiển thị nút tạo tài khoản nếu người dùng là admin -->
                        <?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/create_user">Tạo Tài Khoản</a>
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
                                <?php echo htmlspecialchars($userData['full_name']); ?>!</span>
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

    <main class="container mt-4">
        <div class="content">
            <?php echo $content; // Nội dung động 
            ?>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        <p>&copy; 2024 Hệ thống Quản lý Học Tập</p>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>