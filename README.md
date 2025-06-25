# Laravel Midterm Project - [Tên ứng dụng của bạn]

## 👤 Thông tin sinh viên
- **Họ và tên**: [Tên sinh viên]
- **Mã sinh viên**: [Mã số sinh viên]

---

## 🧩 Mô tả ứng dụng

Ứng dụng web được xây dựng bằng **Laravel Framework**, thực hiện theo mô hình MVC. Ứng dụng gồm ít nhất 3 đối tượng chính:

- **User**: người dùng hệ thống (có đăng ký/đăng nhập).
- **Product**: sách đang bán.
- **Category**: danh mục phân loại sách.
- **Cart**: giỏ hàng (liên kết User & Product).
- **Favorite**: sản phẩm yêu thích (liên kết User & Product).

---

## ⚙️ Các chức năng chính

1. **Xác thực và định danh**:  
   - Sử dụng `Auth` để bảo vệ route và phân quyền.

2. **CRUD cho đối tượng `Order`**:  
   - Thêm/Sửa/Xoá/Hiển thị danh sách đơn hàng.
   - Liên kết với bảng `users` và `products`.

3. **Áp dụng Eloquent ORM**:  
   - Sử dụng model để truy vấn dữ liệu thay vì raw SQL.
   - Có quan hệ: 
    - `User` hasMany `Cart`
    - `User` hasMany `Favorite`
    - `Product` belongsTo `Category`
    - `Cart` belongsTo `User`
    - `Cart` belongsTo `Product`
    - `Favorite` belongsTo `User`
    - `Favorite` belongsTo `Product`

4. **Đảm bảo bảo mật (Security)**:
   - ✅ CSRF protection (sử dụng `@csrf`)
   - ✅ Escape dữ liệu đầu ra tránh XSS (`{{ $var }}`)
   - ✅ Xác thực & phân quyền (`Auth`, middleware)
   - ✅ Validation dữ liệu đầu vào (`FormRequest`, `validate`)
   - ✅ Dùng query builder/Eloquent (tránh SQL Injection)
   - ✅ Sử dụng session & cookies an toàn theo Laravel chuẩn

5. **Triển khai cơ sở dữ liệu trên Cloud**:
   - Sử dụng dịch vụ database cloud (ví dụ: Aiven PostgreSQL)
   - Sử dụng `.env` để cấu hình kết nối cloud database
   - Migrate và seed dữ liệu trực tiếp bằng lệnh:
     ```bash
     php artisan migrate --seed
     ```

---

## 🚀 Cách chạy dự án

```bash
git clone [link repo]
cd [tên thư mục]
composer install
cp .env.example .env
# Chỉnh sửa thông tin DB, sau đó:
php artisan key:generate
php artisan migrate --seed
php artisan serve
