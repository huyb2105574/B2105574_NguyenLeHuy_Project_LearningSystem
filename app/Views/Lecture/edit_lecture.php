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
</body>