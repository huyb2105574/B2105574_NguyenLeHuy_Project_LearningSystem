<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tạo tài khoản mới</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Họ và tên:</label>
                <input type="text" id="full_name" name="full_name" class="form-control"
                    value="<?= isset($registrationData) ? htmlspecialchars($registrationData['full_name']) : '' ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="<?= isset($registrationData) ? htmlspecialchars($registrationData['email']) : '' ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Số điện thoại:</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control"
                    value="<?= isset($registrationData) ? htmlspecialchars($registrationData['phone_number']) : '' ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" id="address" name="address" class="form-control"
                    value="<?= isset($registrationData) ? htmlspecialchars($registrationData['address']) : '' ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Ngày sinh:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                    value="<?= isset($registrationData) ? htmlspecialchars($registrationData['date_of_birth']) : '' ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Vai trò:</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="admin"
                        <?= isset($registrationData) && $registrationData['role'] === 'admin' ? 'selected' : '' ?>>Admin
                    </option>
                    <option value="lecturer"
                        <?= isset($registrationData) && $registrationData['role'] === 'lecturer' ? 'selected' : '' ?>>
                        Giảng viên</option>
                    <option value="student"
                        <?= isset($registrationData) && $registrationData['role'] === 'student' ? 'selected' : '' ?>>
                        Sinh viên</option>
                </select>
            </div>


            <button type="submit" class="btn btn-success">Tạo tài khoản</button>
        </form>
    </div>

    <!-- Liên kết Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>