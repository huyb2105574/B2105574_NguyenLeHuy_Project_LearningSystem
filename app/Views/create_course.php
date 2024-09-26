<form action="/create_course" method="POST" enctype="multipart/form-data">
    <label for="course_name">Tên khóa học:</label>
    <input type="text" id="course_name" name="course_name" required><br>

    <label for="description">Mô tả:</label>
    <textarea id="description" name="description"></textarea><br>

    <label for="lecturer_id">Giảng viên:</label>
    <input type="text" id="lecturer_id" name="lecturer_id"><br>

    <label for="start_date">Ngày bắt đầu:</label>
    <input type="date" id="start_date" name="start_date"><br>

    <label for="end_date">Ngày kết thúc:</label>
    <input type="date" id="end_date" name="end_date"><br>

    <label for="image">Hình ảnh minh họa:</label>
    <input type="file" id="image" name="image"><br>

    <button type="submit">Tạo khóa học</button>
</form>