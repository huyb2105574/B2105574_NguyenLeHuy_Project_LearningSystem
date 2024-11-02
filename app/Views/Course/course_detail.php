<div class="container mt-4">
    <h1>Chi tiết khóa học</h1>
    <div class="course-detail row">
        <div class="col-md-6">
            <img src="/uploads/<?php echo htmlspecialchars($course['image_path']); ?>" alt="Hình minh họa cho khóa học"
                class="img-fluid" style="object-fit: cover;">
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
            <p>Giảng viên: <?php echo htmlspecialchars($lecturerName); ?></p> <!-- Thay ID bằng tên giảng viên -->
            <p>Mô tả: <?php echo htmlspecialchars($course['description']); ?></p>
            <p>Ngày bắt đầu: <?php echo htmlspecialchars($course['start_date']); ?></p>
            <p>Ngày kết thúc: <?php echo htmlspecialchars($course['end_date']); ?></p>

            <?php if ($userData['role'] === 'student' && !$isEnrolled): ?>
                <form action="/courses/enroll/<?php echo $course['course_id']; ?>" method="post">
                    <button type="submit" class="btn btn-success">Ghi danh</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <?php if ($isEnrolled || ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id'])): ?>
        <a href="/lecture/create/<?php echo $course['course_id']; ?>" class="btn btn-success mb-3">Thêm Bài Giảng</a>
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
                        <?php if ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id']): ?>
                            <span>
                                <a href="/lecture/edit/<?php echo $lecture['lecture_id']; ?>" class="btn btn-link p-0">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="/lecture/delete/<?php echo $lecture['lecture_id']; ?>" class="btn btn-link text-danger p-0"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài giảng này?');">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">Không có bài giảng nào cho khóa học này.</li>
            <?php endif; ?>
        </ul>

        <hr>

        <a href="/assignment/create/<?php echo $course['course_id']; ?>" class="btn btn-success mb-3">Thêm Bài Tập</a>
        <h3>Bài tập</h3>
        <ul class="list-group">
            <?php if (!empty($assignments)): ?>
                <?php foreach ($assignments as $assignment): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <a href="/assignment/show/<?php echo $assignment['assignment_id']; ?>" class="btn btn-link">
                                <strong><?php echo htmlspecialchars($assignment['title']); ?></strong>
                            </a>
                        </span>
                        <?php if ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id']): ?>
                            <span>
                                <a href="/assignment/edit/<?php echo $assignment['assignment_id']; ?>" class="btn btn-link p-0">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="/assignment/delete/<?php echo $assignment['assignment_id']; ?>"
                                    class="btn btn-link text-danger p-0"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài tập này?');">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">Không có bài tập nào cho khóa học này.</li>
            <?php endif; ?>
        </ul>

        <hr>

        <?php if (isset($userData['role']) && ($userData['role'] === 'admin' || $userData['role'] === 'lecture')): ?>
            <h3>Học viên đã ghi danh</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['status']); ?></td>
                                    <td>
                                        <?php if ($student['status'] === 'pending'): ?>
                                            <form action="/enrollment/approve/<?php echo $student['enrollment_id']; ?>" method="post"
                                                class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                                            </form>
                                            <form action="/enrollment/reject/<?php echo $student['enrollment_id']; ?>" method="post"
                                                class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-danger">Từ chối</button>
                                            </form>
                                        <?php else: ?>
                                            <?php echo ucfirst($student['status']); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">Chưa có học sinh nào ghi danh</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <a href="/courses" class="btn btn-primary">Trở lại danh sách khóa học</a>
</div>