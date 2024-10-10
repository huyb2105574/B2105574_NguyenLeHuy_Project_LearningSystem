<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 text-center">
            <div class="profile-avatar"
                style="width: 100px; height: 100px; background-color: #ddd; border-radius: 50%; line-height: 100px; font-size: 36px;">
                <?php
                echo strtoupper(substr($userData['full_name'], 0, 1));
                ?>
            </div>
            <h4 class="mt-3"><?php echo htmlspecialchars($userData['full_name']); ?></h4>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chi tiết người dùng</h5>
                    <p><strong>Địa chỉ thư điện tử:</strong>
                        <?php echo htmlspecialchars($userData['email'] ?? 'Không có'); ?></p>
                    <p><strong>Múi giờ:</strong> Asia/Ho_Chi_Minh</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Chi tiết khóa học</h5>
                    <p><strong>Mô tả sơ lược khóa học:</strong> Khóa học công nghệ thông tin</p>
                    <!-- Bạn có thể thay đổi nội dung khóa học tùy theo dữ liệu thực tế -->
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Nội dung khác</h5>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Báo cáo</h5>
                </div>
            </div>
        </div>
    </div>
</div>