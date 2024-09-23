
<?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="/courses/create" class="btn btn-primary">Tạo khóa học</a>
<?php endif; ?>

<h1>Danh sách khóa học</h1>
<p>Danh sách các khóa học hiện có.</p>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên khóa học</th>
            <th>Mô tả</th>
            <th>Giảng viên</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <th>Thao tác</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                <td><?php echo htmlspecialchars($course['description']); ?></td>
                <td><?php echo htmlspecialchars($course['lecturer_name']); ?></td>
                <td><?php echo htmlspecialchars($course['start_date']); ?></td>
                <td><?php echo htmlspecialchars($course['end_date']); ?></td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <td>
                        <a href="/courses/edit/<?php echo htmlspecialchars($course['course_id']); ?>" class="btn btn-warning">Sửa</a>
                        <a href="/courses/delete/<?php echo htmlspecialchars($course['course_id']); ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?');">Xóa</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>