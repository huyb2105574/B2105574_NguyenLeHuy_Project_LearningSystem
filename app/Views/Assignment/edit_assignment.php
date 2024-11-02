<div class="container mt-4">
    <h2>Chỉnh Sửa Bài Tập</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" class="form-control" id="title" name="title"
                value="<?php echo htmlspecialchars($assignment['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea class="form-control" id="description" name="description"
                rows="4"><?php echo htmlspecialchars($assignment['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="due_date">Ngày hết hạn:</label>
            <input type="date" class="form-control" id="due_date" name="due_date"
                value="<?php echo $assignment['due_date']; ?>" required>
        </div>
        <div class="form-group">
            <label for="file">Tải lên tài liệu (nếu có):</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
        <?php if (!empty($assignment['file_path'])): ?>
            <p>Tài liệu hiện tại: <a href="/<?php echo htmlspecialchars($assignment['file_path']); ?>" target="_blank">Tải
                    xuống</a></p>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Cập Nhật Bài Tập</button>
    </form>
    <a href="/courses/show/<?php echo $assignment['course_id']; ?>" class="btn btn-secondary mt-3">Quay lại khóa học</a>
</div>