<h1>Sửa bài giảng</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="title">Tiêu đề:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($lecture['title']); ?>" required>
    <label for="content">Nội dung:</label>
    <textarea name="content" required><?php echo htmlspecialchars($lecture['content']); ?></textarea>
    <label for="file">Tài liệu đính kèm:</label>
    <input type="file" name="file">
    <button type="submit">Cập nhật bài giảng</button>
</form>
<a href="/courses/details?id=<?php echo $lecture['course_id']; ?>">Hủy</a>