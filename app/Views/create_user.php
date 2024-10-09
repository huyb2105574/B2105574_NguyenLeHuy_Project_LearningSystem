<form action="/user/create" method="POST">
    <label for="username">Tên đăng nhập:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="full_name">Họ và tên:</label>
    <input type="text" id="full_name" name="full_name"><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br>

    <label for="role">Vai trò:</label>
    <select id="role" name="role">
        <option value="admin">Admin</option>
        <option value="lecturer">Lecturer</option>
        <option value="student">Student</option>
    </select><br>

    <button type="submit">Tạo tài khoản</button>
</form>