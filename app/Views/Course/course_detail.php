<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']);
    ?>
<?php endif; ?>

<div class="container mt-4">
    <div class="course-detail row">
        <div class="col-md-6">
            <img src="/uploads/<?php echo htmlspecialchars($course['image_path']); ?>" alt="Hình minh họa cho khóa học"
                class="img-fluid course-image">
        </div>
        <div class="col-md-6">
            <h2 class="font-weight-bold"><?php echo htmlspecialchars($course['course_name']); ?></h2>
            <p>Giảng viên: <?php echo htmlspecialchars($lecturerName); ?></p>
            <p>Mô tả: <?php echo htmlspecialchars($course['description']); ?></p>
            <p>Ngày bắt đầu: <?php echo date('d/m/Y', strtotime($course['start_date'])); ?></p>
            <p>Ngày kết thúc: <?php echo date('d/m/Y', strtotime($course['end_date'])); ?></p>

            <?php if ($userData['role'] === 'student' && !$isEnrolled): ?>
                <form action="/courses/enroll/<?php echo $course['course_id']; ?>" method="post">
                    <button type="submit" class="btn btn-success">Ghi danh</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <?php if ($isEnrolled || ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id'])): ?>
        <h3 class="font-weight-bold">Nội dung khóa học</h3>
        <ul class="nav nav-tabs" id="contentTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="lectures-tab" data-toggle="tab" href="#lectures" role="tab"
                    aria-controls="lectures" aria-selected="true">Bài giảng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="assignments-tab" data-toggle="tab" href="#assignments" role="tab"
                    aria-controls="assignments" aria-selected="false">Bài tập</a>
            </li>
        </ul>

        <!-- Nội dung của từng tab -->
        <div class="tab-content" id="contentTabContent">
            <br>
            <!-- Tab "Bài giảng" -->
            <div class="tab-pane fade show active" id="lectures" role="tabpanel" aria-labelledby="lectures-tab">
                <?php if ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id']): ?>
                    <a href="/lecture/create/<?php echo $course['course_id']; ?>" class="btn btn-success mb-3">Thêm Bài
                        Giảng</a>
                <?php endif; ?>
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
                                        <a href="/lecture/delete/<?php echo $lecture['lecture_id']; ?>"
                                            class="btn btn-link text-danger p-0"
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
            </div>

            <!-- Tab "Bài tập" -->
            <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                <?php if ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id']): ?>
                    <a href="/assignment/create/<?php echo $course['course_id']; ?>" class="btn btn-success mb-3">Thêm Bài
                        Tập</a>
                <?php endif; ?>
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
            </div>
        </div>

        <hr>

        <?php if (isset($userData['role']) && ($userData['role'] === 'admin' || $userData['user_id'] === $course['lecturer_id'])): ?>
            <h3 class="font-weight-bold">Học viên đã ghi danh</h3>

            <!-- Thanh điều hướng -->
            <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-students-tab" data-toggle="tab" href="#all-students" role="tab"
                        aria-controls="all-students" aria-selected="true">Danh sách học viên</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pending-students-tab" data-toggle="tab" href="#pending-students" role="tab"
                        aria-controls="pending-students" aria-selected="false">Duyệt học viên</a>
                </li>
            </ul>

            <!-- Nội dung của từng tab -->
            <div class="tab-content" id="studentTabContent">
                <!-- Tab "Danh sách học viên" -->
                <div class="tab-pane fade show active" id="all-students" role="tabpanel" aria-labelledby="all-students-tab">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Tiến độ học tập</th>
                                    <th>Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <?php if ($student['status'] === 'approved'): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                                <td><?php echo htmlspecialchars($student['progress']); ?>%</td>
                                                <td><?php echo htmlspecialchars($student['statusstudy']); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">Chưa có học sinh nào ghi danh</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab "Duyệt học viên" -->
                <div class="tab-pane fade" id="pending-students" role="tabpanel" aria-labelledby="pending-students-tab">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <?php if ($student['status'] != 'approved'): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                                <td>
                                                    <form action="/enrollment/approve/<?php echo $student['enrollment_id']; ?>"
                                                        method="post" class="d-inline">
                                                        <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                                                    </form>
                                                    <form action="/enrollment/reject/<?php echo $student['enrollment_id']; ?>" method="post"
                                                        class="d-inline">
                                                        <button type="submit" class="btn btn-sm btn-danger">Từ chối</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3">Không có học sinh nào cần duyệt</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>


    <a href="/courses" class="btn btn-primary">Trở lại danh sách khóa học</a>
</div>

<style>
    .course-image {
        border-radius: 10px;
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    .font-weight-bold {
        font-weight: bold;
    }
</style>