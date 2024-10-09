<form method="POST" action="/courses/update/<?php echo $course['course_id']; ?>" enctype="multipart/form-data">
    <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
    <label for="course_name">Tên khóa học:</label>
    <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>

    <label for="description">Mô tả:</label>
    <textarea name="description" required><?php echo htmlspecialchars($course['description']); ?></textarea>

    <label for="lecturer_id">Giảng viên:</label>
    <input type="text" name="lecturer_id" value="<?php echo htmlspecialchars($course['lecturer_id']); ?>" required>

    <label for="start_date">Ngày bắt đầu:</label>
    <input type="date" name="start_date" value="<?php echo htmlspecialchars($course['start_date']); ?>" required>

    <label for="end_date">Ngày kết thúc:</label>
    <input type="date" name="end_date" value="<?php echo htmlspecialchars($course['end_date']); ?>" required>

    <button type="submit">Lưu thay đổi</button>
</form>