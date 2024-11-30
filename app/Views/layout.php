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
            padding-top: 0px;
        }

        .navbar-top {
            background-color: #0dcaf0;
            padding: 5px 20px;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            display: inline-block;
        }


        .navbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            position: relative;
        }

        .navbar-bottom {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: #333 !important;
            font-size: 1rem;
            font-weight: bold;
            padding: 0 15px;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: #0dcaf0 !important;
        }

        .user-info {
            display: flex;
            align-items: center;
            color: white;
        }

        .navbar-search {
            position: relative;
            width: 300px;
        }

        .navbar-search input {
            width: 100%;
            padding: 5px 10px;
        }

        .navbar-avatar {
            position: relative;
        }

        .dropdown-menu {
            right: -100;
            top: 100%;
            min-width: 200px;
            display: none;
        }

        .suggestions {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            width: 100%;
            z-index: 9999;
            display: none;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f1f1f1;
        }

        .logout-link {
            margin-left: 10px;
            cursor: pointer;
            color: white;
        }

        .footer {
            background-color: #0dcaf0;
            font-weight: bold;
            color: #fff;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="navbar-top d-flex justify-content-between">
                <a class="navbar-brand" href="/home">Learning</a>
                <?php if (isset($userData['full_name'])): ?>
                    <div class="user-info">
                        <div class="navbar-avatar">
                            <?= strtoupper(substr($userData['full_name'], 0, 1)) ?>
                        </div>
                        <div class="user-name"><?= $userData['full_name'] ?></div>
                        <a href="/logout" class="logout-link">Đăng xuất</a>
                    </div>
                <?php endif; ?>
            </div>
            <nav class="navbar navbar-expand-lg navbar-bottom">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <!-- Thay mx-auto thành me-auto để căn trái -->
                        <li class="nav-item">
                            <a class="nav-link" href="/courses" id="courses-link">Khóa học</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile" id="profile-link">Thông tin cá nhân</a>
                        </li>
                        <?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/user" id="user-link">Quản lý tài khoản</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="navbar-search">
                    <input type="text" id="search-input" class="form-control" placeholder="Tìm khóa học..."
                        autocomplete="off">
                    <div id="suggestions" class="suggestions"></div>
                </div>
            </nav>

        </div>
    </header>

    <main class="container mt-4">
        <div class="content">
            <?php echo $content; ?>
        </div>
    </main>

    <footer class="text-center py-3 mt-4 footer">
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