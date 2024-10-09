<h1>Chi tiết khóa học</h1>

<div class="course-detail">
    <img src="/uploads/<?php echo htmlspecialchars($course['image_path']); ?>" alt="Hình minh họa cho khóa học"
        style="width: 100%; height: 300px; object-fit: cover;">
    <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
    <p>ID Giảng viên: <?php echo htmlspecialchars($course['lecturer_id']); ?></p>
    <p>Mô tả: <?php echo htmlspecialchars($course['description']); ?></p>
    <p>Ngày bắt đầu: <?php echo htmlspecialchars($course['start_date']); ?></p>
    <p>Ngày kết thúc: <?php echo htmlspecialchars($course['end_date']); ?></p>
    <a href="/lecture/create/<?php echo $course['course_id']; ?>" class="btn btn-primary">Thêm bài giảng</a>
    <h3>Bài giảng</h3>
    <ul class="list-group">
        <?php if (!empty($lectures)): ?>
        <?php foreach ($lectures as $lecture): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>
                <a href="/lecture/show/<?php echo $lecture['lecture_id']; ?>" class="btn btn-link">
                    <strong><?php echo htmlspecialchars($lecture['title']); ?></strong>
                </a>
            </span>
            <span>
                <a href="/lecture/edit/<?php echo $lecture['lecture_id']; ?>" class="btn btn-link p-0">
                    <i class="fas fa-pencil-alt"></i> <!-- Pencil icon for edit -->
                </a>
                <a href="/lecture/delete/<?php echo $lecture['lecture_id']; ?>" class="btn btn-link text-danger p-0"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài giảng này?');">
                    <i class="fas fa-times"></i> <!-- 'X' icon for delete -->
                </a>
            </span>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <li class="list-group-item">Không có bài giảng nào cho khóa học này.</li>
        <?php endif; ?>
    </ul>
    <a href="/courses" class="btn btn-primary">Trở lại danh sách khóa học</a>
</div>