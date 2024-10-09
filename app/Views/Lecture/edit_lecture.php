<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sửa Bài Giảng</title>
    <!-- Liên kết với tệp CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Sửa Bài Giảng</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" class="form-control" name="title"
                    value="<?php echo htmlspecialchars($lecture['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea class="form-control" name="content" rows="5"
                    required><?php echo htmlspecialchars($lecture['content']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="file">Tài liệu đính kèm:</label>
                <input type="file" class="form-control-file" name="file">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật bài giảng</button>
            <a href="/courses/details?id=<?php echo $lecture['course_id']; ?>" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <!-- Liên kết với tệp JavaScript Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>