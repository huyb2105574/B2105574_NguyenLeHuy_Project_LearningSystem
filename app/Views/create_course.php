<h1>Tạo Khóa Học Mới</h1>

<form action="/courses/store" method="POST">
    <label for="course_name">Tên khóa học:</label>
    <input type="text" id="course_name" name="course_name" required>
    
    <label for="description">Mô tả khóa học:</label>
    <textarea id="description" name="description" required></textarea>
    
    <label for="lecturer_id">ID Giảng Viên:</label>
    <input type="text" id="lecturer_id" name="lecturer_id" required>
    
    <label for="start_date">Ngày bắt đầu:</label>
    <input type="date" id="start_date" name="start_date" required>
    
    <label for="end_date">Ngày kết thúc:</label>
    <input type="date" id="end_date" name="end_date" required>
    
    <button type="submit" class="btn btn-success">Lưu khóa học</button>
</form>
