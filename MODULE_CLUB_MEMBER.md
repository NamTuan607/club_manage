# MODULE: CLB & Thành viên

Tài liệu này mô tả đầy đủ module CLB & Thành viên (clubs, club_roles, club_members) dùng trong project — dựa trực tiếp trên migration, model, controller, route và view hiện có. Không bịa cấu trúc khác với project.

---

## 1. PHÂN TÍCH NGHIỆP VỤ + ERD

Mục đích từng bảng
- `clubs`: lưu thông tin câu lạc bộ (tên, viết tắt, logo, mô tả, liên hệ, ngày thành lập, cố vấn, chủ nhiệm, giới hạn thành viên, trạng thái).
- `club_roles`: danh sách vai trò trong CLB (Chủ nhiệm, Phó chủ nhiệm, Thành viên...).
- `club_members`: mapping thành viên (student) thuộc CLB, kèm vai trò, ngày tham gia/rời, trạng thái, năm học, ghi chú.
- `users`: tài khoản hệ thống; có `role` enum (admin|club|student). Một `user` có thể liên kết 1 `student`.
- `students`: thông tin sinh viên, có `user_id` FK tới `users`.

PK / FK / Quan hệ
- `clubs.id` PK.
- `club_roles.id` PK.
- `students.id` PK; `students.user_id` FK → `users.id` (cascadeOnDelete).
- `club_members.id` PK; `club_members.club_id` FK → `clubs.id` (cascadeOnDelete), `club_members.student_id` FK → `students.id` (cascadeOnDelete), `club_members.club_role_id` FK → `club_roles.id`.

Quan hệ 1-N / N-N
- `Club` 1 - N `ClubMember` (một CLB có nhiều thành viên).
- `ClubRole` 1 - N `ClubMember` (một vai trò có thể áp cho nhiều member).
- `Student` 1 - N `ClubMember` (một sinh viên có thể xuất hiện nhiều bản ghi membership ở các CLB khác nhau; trong UI hiện có ràng buộc ngăn duplicate student+club).
- `User` 1 - 1 `Student`.

Vòng đời nghiệp vụ (ví dụ điển hình)
1. Quản trị tạo `Club` (tạo CLB, upload logo, set max_members, status).
2. Quản trị tạo `ClubRole` (ví dụ: Chủ nhiệm, Phó, Thành viên).
3. Thêm `Student` vào `Club` bằng tạo `ClubMember` (chọn `club`, `student`, `club_role`, `join_date`, optional `academic_year`/`note`).
4. Trong thời gian là thành viên: thay đổi `club_role` (ví dụ thăng chức), hoặc thay `status` (active → inactive), hoặc set `leave_date` khi rời CLB.
5. Khi rời CLB: admin cập nhật `leave_date` và `status=inactive` (hệ thống không tự động set `leave_date`).
6. Xóa `Club`: bị chặn nếu còn `ClubMember` (cần chuyển/xóa member trước khi xóa).
7. Xóa `ClubRole`: bị chặn nếu có `ClubMember` đang dùng role đó.

Các rule nghiệp vụ & điều kiện không hợp lệ
- Không tạo `ClubMember` nếu cùng (`student_id`,`club_id`) đã tồn tại (app-level validation).
- `leave_date` (nếu có) phải >= `join_date`.
- Không xóa `Club` khi còn members (controller-level guard).
- Không xóa `ClubRole` khi role đang được sử dụng (controller-level guard).
- `club_roles.role_name` phải duy nhất (app-level `unique` validation).

---

## 2. DATABASE / MIGRATION / CONSTRAINT

Các cột quan trọng (tóm tắt từ migration)
- `clubs`: `id`, `name`, `short_name`, `logo`, `description`, `email`, `phone`, `location`, `founding_date`, `advisor`, `president`, `max_members` (int, default 100), `status` enum (active|inactive), timestamps.
- `club_roles`: `id`, `role_name`, `description`, timestamps.
- `club_members`: `id`, `club_id` (FK → `clubs.id`, cascadeOnDelete), `student_id` (FK → `students.id`, cascadeOnDelete), `club_role_id` (FK → `club_roles.id`), `join_date` (date), `leave_date` (date nullable), `status` enum (active|inactive|pending), `academic_year` (nullable string), `note` (nullable text), timestamps.
- `users`: `id`, `name`, `email` (unique), `password`, `role` enum (admin|club|student), timestamps.
- `students`: `id`, `user_id` FK → `users.id` cascadeOnDelete, `student_code` unique, `full_name`, `class`, `faculty`, `phone`, timestamps.

Các constraint & giải thích
- FK cascadeOnDelete cho `club_members.club_id` và `club_members.student_id` và `students.user_id`: bảo đảm khi xóa `club`/`student`/`user` thì các bản ghi phụ thuộc được xóa sạch tự động.
- `students.student_code` là `unique` để đảm bảo mỗi sinh viên có mã riêng (dùng làm khóa logic).
- `users.email` là `unique` để tránh trùng tài khoản.
- `club_roles.role_name` không có index ở DB theo migration, nhưng code áp `unique` validation trên controller để ngăn trùng tên ở tầng ứng dụng (không thay migration).
- Enum fields (`clubs.status`, `club_members.status`, `users.role`) giới hạn giá trị hợp lệ.

Lưu ý triển khai
- Migrations trong repo là nguồn chân lý; runtime DB có thể khác nếu migrations chưa chạy hay DB cũ — code seeder có kiểm tra cột tồn tại để tránh lỗi trên môi trường lệch schema.

---

## 3. SEEDER / DỮ LIỆU MẪU

Seeders hiện có trong repo (liên quan đến module)
- `UsersSeeder` — tạo sample users (idempotent via `updateOrCreate`).
- `StudentsSeeder` — tạo students liên kết tới users (idempotent via `updateOrCreate`).
- `ClubRoleSeeder` — tạo vai trò (dùng `firstOrCreate`).
- `ClubSeeder` — (đã chuyển sang idempotent) tạo CLB mẫu bằng `updateOrCreate`.
- `ClubMemberSeeder` — tạo 4–6 `club_members` hợp lệ; seeder kiểm tra sự tồn tại của cột trước khi chèn (để an toàn khi schema khác nhau), tránh duplicate (`student_id`+`club_id`).

Thứ tự seed theo dependency
1. `UsersSeeder` (tạo users vì `students.user_id` cần users)
2. `StudentsSeeder` (tạo students - có `user_id` FK)
3. `ClubRoleSeeder` (tạo roles)
4. `ClubSeeder` (tạo clubs)
5. `ClubMemberSeeder` (tạo memberships)

Dữ liệu mẫu dùng để test workflow
- Sample users → students để có account sinh viên.
- 3 club roles (Chủ nhiệm, Phó chủ nhiệm, Thành viên).
- 2–3 clubs (IT, Bóng đá, Âm nhạc).
- 4–6 club_members phân bổ hợp lệ, khác `student_code`, khác `email`.

Idempotency
- Seeders quan trọng dùng `firstOrCreate` / `updateOrCreate` để chạy nhiều lần không tạo bản ghi trùng (ngoại trừ các seeders cũ có dùng `insert`—đã chuyển `ClubSeeder` sang idempotent để tránh duplicate clubs).

---

## 4. MODEL / RELATIONSHIP

Club (app/Models/Club.php)
- `$fillable`: `name, short_name, logo, description, email, phone, location, founding_date, advisor, president, max_members, status`.
- Relations:
  - `members()` → returns `hasMany(ClubMember::class)`.
    - Mục đích: lấy tất cả `ClubMember` của CLB.
    - Input: none; Xử lý: Eloquent query lọc `club_members` với `club_id = $this->id`; Output: Collection of `ClubMember` models.
  - `events()` → `hasMany(Event::class)` (không thuộc scope module hiện tại).

ClubRole (app/Models/ClubRole.php)
- `$fillable`: `role_name, description`.
- Relations:
  - `members()` → `hasMany(ClubMember::class)` — lấy members gán role này.

ClubMember (app/Models/ClubMember.php)
- `$fillable`: `club_id, student_id, club_role_id, join_date, leave_date, status, academic_year, note`.
- Relations:
  - `club()` → `belongsTo(Club::class)` — lấy CLB của member. INPUT: none (instance method); Xử lý: Eloquent loads `clubs` row by `club_id`; OUTPUT: `Club` model or null.
  - `student()` → `belongsTo(Student::class)` — lấy sinh viên. OUTPUT: `Student`.
  - `clubRole()` → `belongsTo(ClubRole::class)` — lấy role.

User (app/Models/User.php)
- `$fillable`: `name, email, password, role`.
- Relations:
  - `student()` → `hasOne(Student::class)` — lấy Student liên quan.

Student (app/Models/Student.php)
- (no explicit `$fillable` listed in model; uses factories possibly)
- Relations:
  - `user()` → `belongsTo(User::class)`.
  - `clubMembers()` → `hasMany(ClubMember::class)` — lấy membership của student.

Ghi chú: hàm relationship thường trả Eloquent relation object; controller sử dụng eager loading e.g. `Club::with(['members.student','members.clubRole'])`.

---

## 5. ROUTE + CONTROLLER

Routes (routes/web.php)
- `Route::resource('clubs', ClubController::class);`
- `Route::resource('club_roles', ClubRoleController::class);`
- `Route::resource('club_members', ClubMemberController::class);`

Controller: `ClubController`
- `index()`
  - Lấy `Club::all()` → trả view `clubs.index` với `compact('clubs')`.
- `create()`
  - Trả view `clubs.create`.
- `store(Request $request)`
  - Validate: `name|required`, optional fields, `logo` image|max:2048.
  - Handle file upload -> move to `public/uploads/clubs` -> set `logo` path.
  - `Club::create($data)`.
  - Redirect `clubs.index`.
- `show($id)`
  - `Club::with(['members.student','members.clubRole'])->findOrFail($id)` → `clubs.show`.
  - View hiển thị chi tiết CLB và table danh sách members (get via eager-loaded relation).
- `edit($id)`
  - `Club::findOrFail($id)` → `clubs.edit`.
- `update(Request $request, $id)`
  - Validate same như `store()`.
  - Handle logo replacement (delete file nếu có), `update()` model.
  - Redirect `clubs.index`.
- `destroy($id)`
  - `findOrFail` → check `if ($club->members()->exists())` → nếu true trả redirect với flash `error` (không xóa).
  - Nếu không, xóa logo file nếu có, gọi `$club->delete()` và redirect với `success`.

Controller: `ClubRoleController`
- `index, create, show, edit` → tương tự, trả views trong `resources/views/club_roles/*`.
- `store(Request)`
  - Validate `role_name|required|unique:club_roles,role_name`.
  - `ClubRole::create($data)`.
- `update(Request,$id)`
  - Validate `role_name|required|unique:club_roles,role_name,$id`.
  - `$role->update($data)`.
- `destroy($id)`
  - If `$role->members()->exists()` → redirect back with `error` (không xóa).
  - Else delete and redirect with `success`.

Controller: `ClubMemberController`
- `index()`
  - `ClubMember::with(['club','student','clubRole'])->get()` → `club_members.index`.
- `create()`
  - Load `Club::all()`, `Student::all()`, `ClubRole::all()` → `club_members.create` (dropdowns for club/student/role).
- `store(Request)`
  - Validate: `club_id exists`, `student_id exists`, `club_role_id exists`, `join_date date required`, `leave_date nullable date`, `status in:active,inactive,pending`, `academic_year nullable string`, `note nullable`.
  - Prevent duplicate membership: check `ClubMember::where('club_id',...)->where('student_id',...)->exists()` → nếu true trả withErrors cho `student_id`.
  - Check `leave_date >= join_date` → nếu không hợp lệ trả withErrors cho `leave_date`.
  - `ClubMember::create($data)` và redirect với `success`.
- `show($id)`
  - `ClubMember::with(['club','student','clubRole'])->findOrFail($id)` → view `club_members.show`.
- `edit($id)`
  - Load member + lists để edit.
- `update(Request,$id)`
  - Validate giống `store()`.
  - Prevent duplicate membership excluding current id.
  - Check `leave_date >= join_date`.
  - `$member->update($data)`.
- `destroy($id)`
  - `$member->delete()` (no extra guard) → redirect to index.

Views
- `clubs.show` hiển thị members table pulled from `$club->members`.
- `club_members.form` uses dropdowns for `clubs`, `students`, `roles`.

---

## 6. LIST / CREATE / EDIT / DELETE / WORKFLOW

Luồng người dùng chính
1. List CLB (`GET /clubs`) → view `clubs.index` shows all clubs.
2. Create CLB (`GET /clubs/create`) → fill form → `POST /clubs` (`store`) validate → save `Club` → redirect to list.
3. View CLB chi tiết (`GET /clubs/{id}`) → `show` hiển thị club và danh sách members (eager-loaded).
4. Add member (`GET /club_members/create`) → chọn `club`, `student`, `role`, `join_date` → `POST /club_members` validate → store; nếu duplicate student+club thì trả lỗi và giữ input.
5. Edit member (`GET /club_members/{id}/edit`) → update với validation tương tự.
6. Delete member (`DELETE /club_members/{id}`) → `destroy` xóa record và redirect.
7. Delete CLB (`DELETE /clubs/{id}`) → `destroy` của `ClubController` kiểm tra dependency: nếu có members sẽ báo lỗi và không xóa.
8. Delete role (`DELETE /club_roles/{id}`) → kiểm tra nếu role có members thì báo lỗi và không xóa.

Dữ liệu đi qua Controller → Model → DB → View
- Controller nhận `Request` → chạy `$request->validate()` → nếu lỗi trả về view cũ với errors.
- Nếu hợp lệ, controller gọi `Model::create()` hoặc `$model->update()` → Eloquent chuyển thành SQL insert/update qua PDO.
- Sau lưu, controller redirect về route list/detail; view hiển thị flash messages (`session('success')`/`session('error')`).

---

## 7. VALIDATION + ERROR + SAFE DELETE

Validation hiện có (tổng hợp)
- `ClubController::store/update`:
  - `name` required|string|max:255
  - `logo` nullable|image|max:2048
  - `status` in:active,inactive
- `ClubRoleController::store/update`:
  - `role_name` required|string|max:255|unique:club_roles,role_name
- `ClubMemberController::store/update`:
  - `club_id` required|exists:clubs,id
  - `student_id` required|exists:students,id
  - `club_role_id` required|exists:club_roles,id
  - `join_date` required|date
  - `leave_date` nullable|date
  - `status` required|in:active,inactive,pending
  - `academic_year` nullable|string|max:50
  - `note` nullable|string
- Duplicate membership check (app-level): prevent same `student_id` + `club_id`.
- Date ordering check: `leave_date` must be >= `join_date`.

Xử lý lỗi & flash messages
- Nếu validation thất bại, Laravel trả về view cũ với `$errors` (form shows errors via Blade).
- Duplicate membership ⇒ controller trả `redirect()->back()->withErrors(['student_id' => 'Sinh viên này đã là thành viên của CLB.'])` để hiển thị lỗi gần trường student.
- `leave_date` không hợp lệ ⇒ `withErrors(['leave_date' => 'Ngày rời không được nhỏ hơn ngày tham gia.'])`.
- Xóa CLB có members ⇒ `redirect()->route('clubs.index')->with('error','Không thể xóa CLB...')`.
- Xóa role đang dùng ⇒ tương tự trả `error` flash.

Safe delete
- `ClubController::destroy` chặn xóa nếu `members()->exists()`.
- `ClubRoleController::destroy` chặn xóa nếu `members()->exists()`.
- `ClubMemberController::destroy` xóa trực tiếp (không chặn), vì xóa member thường được phép.

Edge cases
- DB schema mismatch: một số môi trường cũ có thể thiếu cột (`leave_date`, `academic_year`, `note`) — seeder trong repo kiểm tra `Schema::hasColumn()` để tránh error khi chèn.

---

## 8. TEST + DEMO CÁ NHÂN (Checklist)

1) MILESTONE: Seed & basic data
- Input: Run `php artisan db:seed` (seeders in order Users→Students→ClubRoles→Clubs→ClubMembers)
- Thao tác: Chạy seeder
- Kết quả mong đợi: users>=1, students>=1, club_roles>=1, clubs>=1, club_members 4–6 (idempotent khi chạy lại)

2) Test tạo CLB
- Input: `/clubs/create` form với `name`, optional logo
- Thao tác: Submit
- KQ mong đợi: Redirect về `/clubs` và hiển thị new club trong list
- Lỗi: Missing name → validation error; invalid logo → file validation error

3) Test tạo role trùng
- Input: Tạo `role_name` đã tồn tại
- Thao tác: Submit `/club_roles` create
- KQ mong đợi: Validation error (unique)

4) Test thêm member thành công
- Dữ liệu đầu vào: Chọn `club` A, `student` S (không phải member của A), `role` R, `join_date` (2024-09-01)
- Thao tác: Submit `/club_members`
- KQ mong đợi: Redirect to members list with success; new row xuất hiện; trên `clubs/{id}` thấy member

5) Test thêm member trùng
- Input: như trên, submit lại
- KQ mong đợi: withErrors cho `student_id` (không tạo duplicate)

6) Test leave_date ordering
- Input: `join_date` = 2024-09-01, `leave_date` = 2024-08-01
- KQ mong đợi: withErrors cho `leave_date`

7) Test xóa CLB có member
- Input: Delete action `/clubs/{id}` cho CLB có members
- KQ mong đợi: Không xóa, redirect với flash `error` thông báo phải chuyển/xóa members trước

8) Test xóa role đang dùng
- Input: Delete role used by member
- KQ mong đợi: Không xóa, flash `error`

9) Test edit member (change role)
- Input: Edit `/club_members/{id}/edit` đổi `club_role_id`
- KQ mong đợi: update thành công, reflect trên `clubs.show`

10) Regression: re-run seeder
- Input: run `php artisan db:seed` nhiều lần
- KQ mong đợi: users/students/club_roles/clubs/clubs_members không nhân bản do idempotent seeders (ClubSeeder đã chuyển sang `updateOrCreate`)

---

## FUNCTION MAP

| File | Function/Method | Mục đích | Input | Output | Model/DB liên quan |
|---|---:|---|---|---|---|
| `app/Http/Controllers/ClubController.php` | `index()` | List clubs | none | view `clubs.index` (all clubs) | `Club::all()` |
| `app/Http/Controllers/ClubController.php` | `store(Request)` | Tạo CLB | validated request data, optional file upload | redirect `clubs.index` | `Club::create($data)` (inserts `clubs` row) |
| `app/Http/Controllers/ClubController.php` | `show($id)` | Hiển thị chi tiết CLB + members | id | view `clubs.show` với `$club` eager loaded | `Club::with(['members.student','members.clubRole'])->findOrFail($id)` |
| `app/Http/Controllers/ClubRoleController.php` | `store(Request)` | Tạo role | validated `role_name` | redirect | `ClubRole::create()` |
| `app/Http/Controllers/ClubMemberController.php` | `store(Request)` | Tạo membership | validated data (`club_id`,`student_id`,`club_role_id`,`join_date`...) | redirect or withErrors | `ClubMember::create()` (inserts `club_members`) |
| `app/Models/Club.php` | `members()` | Lấy members của CLB | none | Eloquent relation (Collection after ->get()) | `club_members` where `club_id` |
| `app/Models/ClubMember.php` | `club()` | Lấy CLB của member | none | `Club` model | `clubs` via `club_id` |
| `database/seeders/ClubMemberSeeder.php` | `run()` | Seed members | none | console logs and inserts | `ClubMember::create()` (conditional fields) |

(Thêm các hàm khác tương tự: `edit`, `update`, `destroy` đều tồn tại trong controllers — xem chi tiết file controller để mapping đầy đủ.)

---

## WORKFLOW MAP

```mermaid
flowchart TD
  A[Create ClubRole] --> B[Create Club]
  B --> C[Add Student (User->Student exists)]
  C --> D[Create ClubMember]
  D --> E{Operate Member}
  E -->|Change role| D
  E -->|Change status| D
  E -->|Set leave_date| D
  D --> F[Delete Member]
  F --> G[Club may become empty]
  G -->|If empty| H[Delete Club]
  H --> I[Club deleted]
  G -->|Not empty| J[Block delete Club]
  D --> K[Validation: no duplicate student+club]
  D --> L[Validation: leave_date >= join_date]
```

---

Ghi chú cuối
- Tài liệu này dựa trên mã nguồn hiện có (migrations, models, controllers, views, routes). Nếu bạn thay migration hoặc mở rộng schema, cập nhật tài liệu tương ứng.
- Một số môi trường có thể chênh lệch schema (ví dụ cột `leave_date`, `academic_year`, `note` từng thiếu trên một DB test); khi viết seeder tôi đã thêm `Schema::hasColumn()` để tránh lỗi runtime. Tuy nhiên, migration trong repo thể hiện rằng các cột đó tồn tại và là phần của module.

---

Nếu bạn muốn, tôi có thể:
- Thêm checklist tường minh hơn dưới dạng file test (phpunit/feature) để tự động kiểm tra các workflow.
- Sinh diagram ERD cao cấp (PNG/SVG) từ cấu trúc hiện tại.


