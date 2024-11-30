<div class="container mt-4">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h2 class="mb-4 font-weight-bold-center">Quản lý tài khoản</h2>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button"
                role="tab" aria-controls="users" aria-selected="true">Danh sách tài khoản</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="registrations-tab" data-bs-toggle="tab" data-bs-target="#registrations"
                type="button" role="tab" aria-controls="registrations" aria-selected="false">Danh sách đơn đăng
                ký</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-4" id="myTabContent">
        <!-- Tab Danh sách tài khoản -->
        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
            <div class="mb-3">
                <a href="/user/create" class="btn btn-success">Tạo tài khoản mới</a>
            </div>
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead class="table-info">
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ngày sinh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['user_id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td>
                                    <?php
                                    switch ($user['role']) {
                                        case 'admin':
                                            echo 'Quản trị viên';
                                            break;
                                        case 'lecturer':
                                            echo 'Giảng viên';
                                            break;
                                        case 'student':
                                            echo 'Sinh viên';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?= $user['phone_number'] ?></td>
                                <td><?= $user['address'] ?></td>
                                <td><?= $user['date_of_birth'] ?></td>
                                <td>
                                    <a href="/user/edit/<?= $user['user_id'] ?>" class="btn btn-primary btn-sm">Chỉnh
                                        sửa</a>
                                    <a href="/user/delete/<?= $user['user_id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Danh sách đơn đăng ký -->
        <div class="tab-pane fade" id="registrations" role="tabpanel" aria-labelledby="registrations-tab">
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead class="table-info">
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ngày sinh</th>
                            <th>Vai trò</th>
                            <th>Ngày đăng ký</th>
                            <th>Tình trạng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $registration): ?>
                            <tr>
                                <td><?= $registration['registration_id'] ?></td>
                                <td><?= $registration['full_name'] ?></td>
                                <td><?= $registration['email'] ?></td>
                                <td><?= $registration['phone_number'] ?></td>
                                <td><?= $registration['address'] ?></td>
                                <td><?= $registration['date_of_birth'] ?></td>
                                <td>
                                    <?php
                                    switch ($registration['role']) {
                                        case 'admin':
                                            echo 'Quản trị viên';
                                            break;
                                        case 'lecturer':
                                            echo 'Giảng viên';
                                            break;
                                        case 'student':
                                            echo 'Sinh viên';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?= $registration['submitted_at'] ?></td>
                                <td>
                                    <?php
                                    switch ($registration['status']) {
                                        case 'approved':
                                            echo '<span class="badge bg-success">Chấp nhận</span>';
                                            break;
                                        case 'rejected':
                                            echo '<span class="badge bg-danger">Từ chối</span>';
                                            break;
                                        case 'pending':
                                            echo '<span class="badge bg-primary">Chờ duyệt</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary">Không xác định</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($registration['status'] === 'pending'): ?>
                                        <a href="/user/create/<?= $registration['registration_id'] ?>"
                                            class="btn btn-success btn-sm">Tạo tài khoản</a>
                                    <?php endif; ?>
                                    <a href="/registration/delete/<?= $registration['registration_id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn đăng ký này không?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table-wrapper table {
        font-size: 90%;
    }

    .font-weight-bold-center {
        text-align: center;
        font-weight: bold;
    }
</style>