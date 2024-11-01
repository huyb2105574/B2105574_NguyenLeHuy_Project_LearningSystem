<div class="container mt-4">
    <h2 class="mb-4">Danh sách tài khoản</h2>

    <!-- Nút Tạo Tài Khoản -->
    <div class="mb-3">
        <a href="/user/create" class="btn btn-success">Tạo tài khoản mới</a>
    </div>

    <!-- Bảng danh sách tài khoản -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên đăng nhập</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Số điện thoại</th> <!-- Thêm số điện thoại -->
                <th>Địa chỉ</th> <!-- Thêm địa chỉ -->
                <th>Ngày sinh</th> <!-- Thêm ngày sinh -->
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
                    <td><?= $user['role'] ?></td>
                    <td><?= $user['phone_number'] ?></td> <!-- Hiển thị số điện thoại -->
                    <td><?= $user['address'] ?></td> <!-- Hiển thị địa chỉ -->
                    <td><?= $user['date_of_birth'] ?></td> <!-- Hiển thị ngày sinh -->
                    <td>
                        <a href="/user/edit/<?= $user['user_id'] ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                        <a href="/user/delete/<?= $user['user_id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2 class="mb-4">Danh sách đơn đăng ký</h2>
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Ngày sinh</th>
                <th>Vai trò</th>
                <th>Ngày đăng ký</th>
                <th>Tình trạng</th> <!-- Cột tình trạng -->
                <th>Hành động</th> <!-- Cột hành động -->
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
                    <td><?= $registration['role'] ?></td>
                    <td><?= $registration['submitted_at'] ?></td>
                    <td><?= $registration['status'] ?></td> <!-- Hiển thị tình trạng -->
                    <td>
                        <a href="/user/create/<?= $registration['registration_id'] ?>" class="btn btn-success btn-sm">Tạo
                            tài khoản</a>
                        <a href="/registration/delete/<?= $registration['registration_id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa đơn đăng ký này không?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>