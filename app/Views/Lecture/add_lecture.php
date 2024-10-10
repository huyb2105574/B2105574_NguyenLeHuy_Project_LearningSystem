<body>
    <div class="container mt-4">
        <h2>Thêm Bài Giảng Mới</h2>
        <form action="/lecture/create/<?php echo $courseId; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="file">Tệp bài giảng:</label>
                <input type="file" class="form-control-file" id="file" name="file"
                    accept=".pdf, .doc, .docx, .ppt, .pptx">
            </div>

            <button type="submit" class="btn btn-primary">Thêm Bài Giảng</button>
        </form>
    </div>
</body>