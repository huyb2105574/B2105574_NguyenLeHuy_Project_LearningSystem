<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success_message'];
        unset($_SESSION['success_message']); ?>
    </div>
<?php elseif (isset($_SESSION['error_message'])) : ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 text-center">
            <div class="profile-avatar"
                style="width: 100px; height: 100px; background-color: #ddd; border-radius: 50%; line-height: 100px; font-size: 36px;">
                <?php
                echo strtoupper(substr($userData['full_name'], 0, 1));
                ?>
            </div>
            <h4 class="mt-3"><?php echo htmlspecialchars($userData['full_name']); ?></h4>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chi tiết người dùng</h5>
                    <p><strong>Địa chỉ thư điện tử:</strong>
                        <?php echo htmlspecialchars($userData['email'] ?? 'Không có'); ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($userData['address'] ?? 'Không có'); ?></p>
                    <p><strong>Số điện thoại:</strong>
                        <?php echo htmlspecialchars($userData['phone_number'] ?? 'Không có'); ?>
                    </p>
                    </p>
                    <p><strong>Ngày sinh:</strong>
                        <?php echo htmlspecialchars($userData['date_of_birth'] ?? 'Không có'); ?></p>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Cập nhật tài khoản</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                Đổi mật khẩu
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#updateInfoModal">
                                Cập nhật thông tin
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Khóa học đã ghi danh</h5>
                    <?php if (!empty($coursesEnrollments)) : ?>
                        <ul>
                            <?php foreach ($coursesEnrollments as $course) : ?>
                                <li><?php echo htmlspecialchars($course['course_name']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>Không có khóa học nào.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>


        <!-- Modal Đổi Mật Khẩu -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="changePasswordForm" method="post"
                            action="/user/change_password/<?php echo $userData['user_id'] ?>">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Cập Nhật Thông Tin -->
        <div class="modal fade" id="updateInfoModal" tabindex="-1" aria-labelledby="updateInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateInfoModalLabel">Cập Nhật Thông Tin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateInfoForm" method="post"
                            action="/user/update_info/<?php echo $userData['user_id'] ?>">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    value="<?php echo htmlspecialchars($userData['full_name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Địa Chỉ Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="<?php echo htmlspecialchars($userData['phone_number']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo htmlspecialchars($userData['address']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Ngày Sinh</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    value="<?php echo htmlspecialchars($userData['date_of_birth']); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Cập Nhật Thông Tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    window.onload = function() {

        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000);
        }
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 5000);
        }
    };
</script>