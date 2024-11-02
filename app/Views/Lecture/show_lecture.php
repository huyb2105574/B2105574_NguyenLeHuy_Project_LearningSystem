<div class="container mt-4">
    <h2><?php echo htmlspecialchars($lecture['title']); ?></h2>
    <p>Nội dung: <?php echo nl2br(htmlspecialchars($lecture['content'])); ?></p>

    <?php if (!empty($lecture['file_path'])): ?>
    <h3>Tài liệu</h3>
    <div class="pdf-viewer-container">
        <iframe class="pdf-viewer" src="/uploads/<?php echo htmlspecialchars($lecture['file_path']); ?>"
            allowfullscreen></iframe>
    </div>
    <?php endif; ?>

    <div class="mt-3">
        <a href="/courses/show/<?php echo $lecture['course_id']; ?>" class="btn btn-secondary">Trở lại danh sách bài
            giảng</a>
    </div>
</div>

<style>
.pdf-viewer-container {
    width: 100%;
    height: 600px;
    overflow: hidden;
    border: 1px solid #ccc;

    border-radius: 5px;

}

.pdf-viewer {
    width: 100%;
    height: 100%;
    border: none;

}
</style>