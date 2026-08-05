# Hệ thống Quản lý Câu lạc bộ, Sự kiện và Điểm hoạt động

## Giới thiệu

Đề tài xây dựng hệ thống quản lý câu lạc bộ, sự kiện và điểm hoạt động dành cho sinh viên Trường Đại học Thủy Lợi.

Hệ thống hỗ trợ:

- Quản lý câu lạc bộ
- Quản lý thành viên câu lạc bộ
- Quản lý sự kiện
- Duyệt sự kiện
- Đăng ký tham gia sự kiện
- Check-in sự kiện
- Cộng điểm hoạt động
- Cấp chứng nhận

---

## Công nghệ sử dụng

- Laravel 12
- PHP 8.2
- MySQL
- Bootstrap 5
- Git & GitHub

---

## Cơ sở dữ liệu

Database:

```
club_management
```

Tổng số bảng:

```
13 bảng
```

- users
- students
- clubs
- club_roles
- club_members
- event_categories
- events
- event_approvals
- event_registrations
- checkin_logs
- activity_point_rules
- student_points
- certificates

---

## Cài đặt project

Clone project

```bash
git clone <repository-url>
```

Di chuyển vào project

```bash
cd club_manage
```

Cài package

```bash
composer install
```

Tạo file .env

Windows

```bash
copy .env.example .env
```

Linux / macOS

```bash
cp .env.example .env
```

Sinh APP_KEY

```bash
php artisan key:generate
```

Tạo database

```
club_management
```

Chạy migration

```bash
php artisan migrate
```

Khởi động server

```bash
php artisan serve
```

---

## Phân công thành viên

| Thành viên | Module |
|------------|--------|
| Leader | Database + Migration + Relationship + Merge |
| Thành viên 1 | Quản lý CLB |
| Thành viên 2 | Quản lý Sự kiện |
| Thành viên 3 | Đăng ký + Check-in |
| Thành viên 4 | Điểm + Chứng nhận |

---

## Quy trình làm việc

- Không commit trực tiếp lên main
- Mỗi thành viên làm trên branch riêng
- Commit thường xuyên
- Sau khi hoàn thành tạo Pull Request về develop
- Leader review và merge