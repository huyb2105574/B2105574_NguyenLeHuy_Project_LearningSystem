<h1>Thêm bài giảng</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="title">Tiêu đề:</label>
    <input type="text" name="title" required>
    <label for="content">Nội dung:</label>
    <textarea name="content" required></textarea>
    <label for="file">Tài liệu đính kèm:</label>
    <input type="file" name="file">
    <button type="submit">Thêm bài giảng</button>
</form>
<a href="/courses/details/<?php echo $courseId; ?>">Hủy</a>