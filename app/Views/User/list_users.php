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
                    <td>
                        <a href="/user/edit/<?= $user['user_id'] ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                        <a href="/user/delete/<?= $user['user_id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>