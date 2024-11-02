<div class="container mt-4">
    <h2>Nộp Bài Tập</h2>

    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <form action="/submission/submit/<?php echo htmlspecialchars($assignmentId); ?>" method="POST"
        enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Chọn tệp để nộp:</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Nộp bài</button>
    </form>

    <a href="/assignment/show/<?php echo htmlspecialchars($assignmentId); ?>" class="btn btn-secondary mt-3">Quay lại
        bài tập</a>
</div>