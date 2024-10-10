<h1>Trang chủ</h1>
<h2>Danh sách Khóa học</h2>
<ul class="list-group">
    <?php foreach ($courses as $course): ?>
        <li class="list-group-item">
            <a href="/courses/show/<?php echo $course['course_id']; ?>">
                <?php echo htmlspecialchars($course['course_name']); ?>
            </a>
            <span class="badge badge-primary"><?php echo htmlspecialchars($course['lecturer_name']); ?></span>
        </li>
    <?php endforeach; ?>
</ul>