<div class="container mt-5">
    <h2>Chỉnh Sửa Khóa Học</h2>
    <form method="POST" action="/courses/update/<?php echo $course['course_id']; ?>" enctype="multipart/form-data">
        <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">

        <div class="form-group">
            <label for="course_name">Tên Khóa Học:</label>
            <input type="text" class="form-control" name="course_name"
                value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Mô Tả:</label>
            <textarea class="form-control" name="description"
                required><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="lecturer_id">Giảng Viên:</label>
            <input type="text" class="form-control" name="lecturer_id"
                value="<?php echo htmlspecialchars($course['lecturer_id']); ?>" required>
        </div>

        <div class="form-group">
            <label for="start_date">Ngày Bắt Đầu:</label>
            <input type="date" class="form-control" name="start_date"
                value="<?php echo htmlspecialchars($course['start_date']); ?>" required>
        </div>

        <div class="form-group">
            <label for="end_date">Ngày Kết Thúc:</label>
            <input type="date" class="form-control" name="end_date"
                value="<?php echo htmlspecialchars($course['end_date']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
        <a href="/courses" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>