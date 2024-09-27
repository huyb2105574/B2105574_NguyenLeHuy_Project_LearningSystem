<h1>Chi tiết khóa học</h1>

<div class="course-detail">
    <img src="/uploads/<?php echo htmlspecialchars($course['image_path']); ?>" alt="Hình minh họa cho khóa học"
        style="width: 100%; height: 300px; object-fit: cover;">
    <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
    <p>ID Giảng viên: <?php echo htmlspecialchars($course['lecturer_id']); ?></p>
    <p>Mô tả: <?php echo htmlspecialchars($course['description']); ?></p>
    <p>Ngày bắt đầu: <?php echo htmlspecialchars($course['start_date']); ?></p>
    <p>Ngày kết thúc: <?php echo htmlspecialchars($course['end_date']); ?></p>

    <a href="/courses" class="btn btn-primary">Trở lại danh sách khóa học</a>
</div>