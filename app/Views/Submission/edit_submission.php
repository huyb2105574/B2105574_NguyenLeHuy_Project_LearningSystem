<div class="container mt-4">
    <h2>Chỉnh Sửa Bài Nộp</h2>

    <?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <p><strong>Bài nộp hiện tại:</strong> <?php echo htmlspecialchars(basename($submission['file_path'])); ?></p>

    <form action="/submission/edit/<?php echo htmlspecialchars($submission['submission_id']); ?>" method="POST"
        enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Chọn tệp mới:</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập nhật bài nộp</button>
    </form>

    <a href="/assignments/show/<?php echo htmlspecialchars($submission['assignment_id']); ?>"
        class="btn btn-secondary mt-3">Quay lại bài tập</a>
</div>