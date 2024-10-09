<form action="/courses/store" method="POST" enctype="multipart/form-data" class="container mt-4">
    <h2>Tạo Khóa Học</h2>

    <div class="form-group">
        <label for="course_name">Tên khóa học:</label>
        <input type="text" id="course_name" name="course_name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="lecturer_id">Giảng viên:</label>
        <input type="text" id="lecturer_id" name="lecturer_id" class="form-control">
    </div>

    <div class="form-group">
        <label for="start_date">Ngày bắt đầu:</label>
        <input type="date" id="start_date" name="start_date" class="form-control">
    </div>

    <div class="form-group">
        <label for="end_date">Ngày kết thúc:</label>
        <input type="date" id="end_date" name="end_date" class="form-control">
    </div>

    <div class="form-group">
        <label for="image">Hình ảnh minh họa:</label>
        <input type="file" id="image" name="image" class="form-control-file">
    </div>

    <button type="submit" class="btn btn-primary">Tạo khóa học</button>
</form>