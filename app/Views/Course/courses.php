<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']);
    ?>
<?php endif; ?>

<h1 class="text-center font-weight-bold mb-4">Danh sách khóa học</h1>
<div class="row">
    <?php foreach ($courses as $course): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="uploads/<?php echo htmlspecialchars($course['image_path']); ?>" class="card-img-top"
                    alt="Hình minh họa cho khóa học" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold"><?php echo htmlspecialchars($course['course_name']); ?></h5>
                    <p class="card-text">Giảng viên: <?php echo htmlspecialchars($course['lecturer_name']); ?></p>
                    <a href="/courses/show/<?php echo $course['course_id']; ?>" class="btn btn-info">Xem chi tiết</a>
                </div>
                <?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
                    <div class="card-footer">
                        <a href="/courses/edit/<?php echo $course['course_id']; ?>" class="btn btn-warning">Chỉnh sửa</a>
                        <a href="/courses/delete/<?php echo $course['course_id']; ?>" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa khóa học này?');">Xóa</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php if (isset($userData['role']) && $userData['role'] === 'admin'): ?>
    <a href="/courses/create" class="btn btn-primary">Tạo khóa học</a>
<?php endif; ?>
<style>
    .font-weight-bold {
        font-weight: bold;
    }
</style>