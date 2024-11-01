<form action="/registration/register" method="post">
    <input type="text" name="full_name" required placeholder="Họ và tên">
    <input type="email" name="email" required placeholder="Email">
    <input type="text" name="phone_number" placeholder="Số điện thoại">
    <input type="text" name="address" placeholder="Địa chỉ">
    <input type="date" name="date_of_birth" placeholder="Ngày sinh">
    <select name="role" required>
        <option value="student">Sinh viên</option>
        <option value="lecturer">Giảng viên</option>
    </select>
    <button type="submit">Gửi Đăng Ký</button>
</form>