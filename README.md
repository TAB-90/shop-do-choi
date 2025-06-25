![Screenshot 2025-06-25 161837](https://github.com/user-attachments/assets/fc4ae2dd-c706-43bd-a4f0-a1b2b7caf74d)

<ul>
    <a href = '' ><li>Đinh Nhật Tân </li></a>
    <a href = '' ><li>Mã số sinh viên: 23013018</li></a>
    <a href = '' ><li>Thiết kế web nâng cao-1-3-24.TH4</li></a>
</ul>

# Tên dự án: Shop đồ chơi

# Giới thiệu dự án:   
    -Là một trang web bán sách trực tuyến được xây dựng bằng Laravel.
    -Người dùng có thể đăng ký, đăng nhập, xem danh sách đồ chơi, tìm kiếm, thêm vào giỏ hàng và đặt hàng.
    -Quản trị viên (Admin) có thể quản lý đồ chơi, danh mục, người dùng và đơn hàng.
    -Hệthống sử dụng các models chính như: User, Toy, Cart, Order, Review, Category.
    -Hướng tới thiết kế MVC rõ ràng, dễ mở rộng trong tương lai.

# Sơ đồ class diagram
![deepseek_mermaid_20250625_34294a](https://github.com/user-attachments/assets/e8544547-1b7d-4319-84cd-4117cc7ced39)

# Sơ đồ Activity Diagram
![deepseek_mermaid_20250625_11d005](https://github.com/user-attachments/assets/c982ca5a-b539-48d0-a12c-1eaaf4ffe560)

# Sơ đồ thuật toán
![deepseek_mermaid_20250625_694871](https://github.com/user-attachments/assets/70615228-577f-4ef8-9d2f-6bec48c6e79f)

# Sơ đồ chức năng
![deepseek_mermaid_20250625_4990d2](https://github.com/user-attachments/assets/1572d6a9-dab1-4f13-a9c2-ea31ead67eaa)

# Module:
-**composer**:

file `ProductController.php`. Đây thường là một **Controller** trong Laravel – chịu trách nhiệm xử lý logic giữa **model** và **view**.






-**co**:








# Cách chạy dự án

```bash
git clone [link repo]
cd [tên thư mục]
composer install
cp .env.example .env
Chỉnh sửa thông tin DB, sau đó:
php artisan key:generate
php artisan migrate --seed
php artisan serve






