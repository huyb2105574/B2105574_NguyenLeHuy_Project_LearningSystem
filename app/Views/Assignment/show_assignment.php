<div class="container mt-4">
    <h2>Chi Tiết Bài Tập</h2>
    <p><strong>Tiêu đề:</strong> <?php echo htmlspecialchars($assignment['title']); ?></p>
    <p><strong>Mô tả:</strong> <?php echo nl2br(htmlspecialchars($assignment['description'])); ?></p>
    <p><strong>Ngày hết hạn:</strong> <?php echo $assignment['due_date']; ?></p>
    <p><strong>Ngày tạo:</strong> <?php echo $assignment['created_at']; ?></p>

    <a href="/courses/show/<?php echo $assignment['course_id']; ?>" class="btn btn-secondary mt-3">Quay lại khóa học</a>
    <a href="/assignment/edit/<?php echo $assignment['assignment_id']; ?>" class="btn btn-warning mt-3">Chỉnh sửa</a>
    <a href="/assignment/delete/<?php echo $assignment['assignment_id']; ?>" class="btn btn-danger mt-3"
        onclick="return confirm('Bạn có chắc muốn xóa bài tập này?');">Xóa</a>

    <?php if ($submission): ?>
    <!-- Hiển thị thông tin bài nộp hiện tại -->
    <h4 class="mt-4">Bài Nộp Hiện Tại</h4>
    <div class="alert alert-info">
        <strong>Tên Bài Nộp:</strong> <?php echo htmlspecialchars(basename($submission['file_path'])); ?><br>
        <strong>Ngày Nộp:</strong> <?php echo htmlspecialchars($submission['submitted_at']); ?>
    </div>

    <!-- Nếu đã nộp bài, hiển thị nút Sửa bài làm và Xóa bài làm -->
    <a href="/submission/edit/<?php echo $submission['submission_id']; ?>" class="btn btn-primary mt-3">Sửa bài làm</a>
    <a href="/submission/delete/<?php echo $submission['submission_id']; ?>" class="btn btn-danger mt-3"
        onclick="return confirm('Bạn có chắc muốn xóa bài làm này?');">Xóa bài làm</a>
    <?php else: ?>
    <!-- Nút Nộp bài và Form nộp bài -->
    <a href="/submission/submit/<?php echo $assignment['assignment_id']; ?>" class="btn btn-success mt-3">Nộp bài</a>
    <?php endif; ?>

    <h3 class="mt-4">Danh Sách Bài Nộp</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Bài Nộp</th>
                <th>Ngày Nộp</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($submissions)): ?>
            <?php foreach ($submissions as $index => $sub): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars(basename($sub['file_path'])); ?></td>
                <td><?php echo htmlspecialchars($sub['created_at']); ?></td>
                <td>
                    <a href="/submission/edit/<?php echo $sub['submission_id']; ?>"
                        class="btn btn-warning btn-sm">Sửa</a>
                    <a href="/submission/delete/<?php echo $sub['submission_id']; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Bạn có chắc muốn xóa bài làm này?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Không có bài nộp nào.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>