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

        .navbar-nav .nav-link:hover {
            color: #555 !important;
        }

        /* Tìm kiếm */
        .suggestions {
            border: 1px solid #ccc;
            background: white;
            z-index: 1000;
            max-height: 150px;
            overflow-y: auto;
            width: 100%;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <!-- Logo bên trái -->
                <a class="navbar-brand" href="/home">Learning</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
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
                <div class="ml-auto position-relative">
                    <input type="text" id="search-input" class="form-control" placeholder="Tìm khóa học..."
                        autocomplete="off">
                    <div id="suggestions" class="suggestions position-absolute" style="display:none;"></div>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mt-4">
        <div class="content">
            <?php echo $content; ?>
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

    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value;

            if (query.length > 0) {
                fetch(`/courses/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        const suggestionsContainer = document.getElementById('suggestions');
                        suggestionsContainer.innerHTML = ''; // Xóa gợi ý cũ
                        suggestionsContainer.style.display = 'none'; // Ẩn nếu không có gợi ý

                        if (data.length > 0) {
                            data.forEach(course => {
                                const div = document.createElement('div');
                                div.classList.add('suggestion-item');
                                div.textContent = course
                                    .course_name;
                                div.onclick = () => {
                                    window.location.href =
                                        `/courses/show/${course.course_id}`;
                                };
                                suggestionsContainer.appendChild(div);
                            });
                            suggestionsContainer.style.display = 'block';
                        }
                    });
            } else {
                document.getElementById('suggestions').innerHTML = '';
            }
        });
    </script>
</body>

</html>