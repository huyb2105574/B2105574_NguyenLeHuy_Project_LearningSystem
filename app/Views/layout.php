<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Học Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Thanh điều hướng */
    .navbar {
        background-color: #fff;
        padding: 10px 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Tăng kích thước logo */
    .navbar-brand img {
        height: 60px;
        /* Thay đổi từ 40px thành 60px để logo lớn hơn */
        margin-right: 10px;
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        display: flex;
        align-items: center;
    }

    /* Menu items */
    .navbar-nav .nav-link {
        color: #333 !important;
        font-size: 1rem;
        font-weight: bold;
        text-transform: uppercase;
        padding: 0 15px;
        position: relative;
    }

    /* Loại bỏ mũi tên */
    .navbar-nav .nav-link::after {
        display: none;
        /* Ẩn mũi tên sau các mục menu */
    }

    .navbar-nav .nav-link:hover {
        color: #555 !important;
    }

    /* Icon tìm kiếm */
    .search-icon {
        font-size: 1.2rem;
        color: #333;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <!-- Logo bên trái -->
                <a class="navbar-brand" href="/home">

                    Learning
                </a>
                <!-- Nút toggle trên thiết bị di động -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu căn giữa -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- Hiển thị nút tạo tài khoản nếu người dùng là admin -->
                        <?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/user">Quản lý tài khoản</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/courses">Trang Chủ</a>
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
                <!-- Icon tìm kiếm bên phải -->
                <div class="search-icon ml-auto">
                    <i class="fas fa-search"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Nội dung chính -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>