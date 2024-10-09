<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chi Tiết Bài Giảng</title>
    <!-- Liên kết với tệp CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .pdf-viewer {
            width: 100%;
            height: 80vh;
            /* Chiều cao của iframe */
            border: none;
            /* Không viền */
        }
    </style>
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
                        <?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/user">Quản lý tài khoản</a>
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

    <div class="container mt-4">
        <h2><?php echo htmlspecialchars($lecture['title']); ?></h2>
        <p>Nội dung: <?php echo nl2br(htmlspecialchars($lecture['content'])); ?></p>

        <?php if (!empty($lecture['file_path'])): ?>
            <h3>Tài liệu</h3>
            <iframe class="pdf-viewer" src="/uploads/<?php echo htmlspecialchars($lecture['file_path']); ?>"
                allowfullscreen></iframe>
        <?php endif; ?>

        <div class="mt-3">
            <a href="/courses/show/<?php echo $lecture['course_id']; ?>" class="btn btn-secondary">Trở lại danh sách bài
                giảng</a>
        </div>
    </div>

    <!-- Liên kết với tệp JavaScript Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>