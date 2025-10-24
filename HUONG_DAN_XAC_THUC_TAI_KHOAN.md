# Hướng Dẫn Chi Tiết: Xác Thực Tài Khoản Qua Email

## Tổng Quan

Hệ thống xác thực tài khoản qua email cho phép người dùng xác nhận địa chỉ email của họ sau khi đăng ký. Người dùng phải xác nhận email trước khi có thể đăng nhập vào hệ thống.

---

## Các Bước Thực Hiện

### Bước 1: Tạo Migration Thêm Cột `very_mail_token`

**File:** `database/migrations/2025_10_24_130143_add_columd_very_token_to_users.php`

Thêm cột `very_mail_token` vào bảng `users` để lưu token xác thực email.

```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('very_mail_token')->nullable()->after('remember_token');
    });
}
```

**Chạy migration:**

```bash
php artisan migrate
```

**Giải thích:**

-   Cột `very_mail_token` sẽ lưu token ngẫu nhiên để xác thực email
-   Cột này có thể `nullable` vì chỉ tồn tại khi chưa xác thực
-   Sau khi xác thực thành công, cột này sẽ được set về `null`

---

### Bước 2: Tạo Mailable Class

**File:** `app/Mail/VeryEmail.php`

Tạo class để định nghĩa cấu trúc email xác thực.

```php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VeryEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $url;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = route('auth.very', $url); // Link xác nhận email
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác Nhận Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.verify',
            with: [
                'nameVery' => $this->name,
                'url' => $this->url,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
```

**Giải thích:**

-   Constructor nhận `$name` (tên người dùng) và `$url` (token)
-   `route('auth.very', $url)` tạo URL xác thực có dạng: `http://domain.com/very/{token}`
-   Sử dụng markdown template `mail.verify` để hiển thị nội dung email

---

### Bước 3: Tạo View Email Template

**File:** `resources/views/mail/verify.blade.php`

Template markdown cho email xác thực.

```blade
<x-mail::message>
# Xác nhận tài khoản {{ $nameVery }}!

Để xác nhận tài khoản, vui lòng nhấn vào link bên dưới:

{{ $url }}

Cảm ơn bạn đã đăng ký!
</x-mail::message>
```

**Lưu ý:**

-   Có thể sử dụng component `<x-mail::button>` để tạo button đẹp hơn
-   Template sử dụng cú pháp Markdown của Laravel

---

### Bước 4: Tạo Job Gửi Email

**File:** `app/Jobs/SendVeryEmail.php`

Tạo Job để gửi email bất đồng bộ (queue).

```php
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\VeryEmail;
use Illuminate\Support\Facades\Log;

class SendVeryEmail implements ShouldQueue
{
    use Queueable;

    public $email;
    public $name;
    public $token;

    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new VeryEmail($this->name, $this->token));
    }

    public function failed(\Throwable $exception)
    {
        Log::error('SendEmailJob fail 😭: ' . $exception->getMessage());
    }
}
```

**Giải thích:**

-   Implements `ShouldQueue` để chạy bất đồng bộ
-   Method `handle()` thực thi việc gửi email
-   Method `failed()` log lỗi nếu gửi email thất bại
-   Sử dụng Job giúp tránh blocking request khi gửi email

**Yêu cầu:**

-   Cần cấu hình queue driver trong `.env` (có thể dùng `database`, `redis`, etc.)
-   Chạy queue worker: `php artisan queue:work`

---

### Bước 5: Cập Nhật AuthController

**File:** `app/Http/Controllers/Auth/AuthController.php`

#### 5.1. Method `registerPost()` - Xử lý đăng ký

```php
use Illuminate\Support\Str;
use App\Jobs\SendVeryEmail;

public function registerPost(RegisterRequest $request)
{
    try {
        // Tạo user mới
        $user = User::create($request->all());

        // Gán role customer cho user
        $user->assignRole('customer');

        // Tạo token ngẫu nhiên 60 ký tự
        $token = Str::random(60);
        $user->very_mail_token = $token;
        $user->save();

        // Dispatch job gửi email xác thực
        SendVeryEmail::dispatch($user->email, $user->name, $user->very_mail_token);

        return redirect()->route('auth.login.index')
            ->with('success', 'Đăng ký thành công, vui lòng kiểm tra email để xác nhận tài khoản');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Đăng ký thất bại: ' . $e->getMessage())
            ->withInput();
    }
}
```

**Các bước trong method:**

1. Tạo user mới với dữ liệu từ form
2. Gán role 'customer' cho user (sử dụng Spatie Permission)
3. Tạo token ngẫu nhiên 60 ký tự bằng `Str::random(60)`
4. Lưu token vào cột `very_mail_token`
5. Dispatch job gửi email (chạy bất đồng bộ)
6. Redirect về trang login với thông báo thành công

#### 5.2. Method `very()` - Xử lý xác thực email

```php
public function very($token)
{
    // Tìm user có very_mail_token khớp với token được truyền vào
    $user = User::where('very_mail_token', $token)->first();

    if ($user) {
        // Xóa token (set về null)
        $user->very_mail_token = null;

        // Đánh dấu email đã được xác thực
        $user->email_verified_at = now();

        // Lưu thay đổi
        $user->save();

        return redirect()->route('auth.login.index')
            ->with('success', 'Xác nhận tài khoản thành công, vui lòng đăng nhập');
    } else {
        return redirect()->route('auth.login.index')
            ->with('error', 'Xác nhận tài khoản thất bại');
    }
}
```

**Các bước trong method:**

1. Tìm user có `very_mail_token` khớp với token trong URL
2. Nếu tìm thấy:
    - Set `very_mail_token` về `null` (xóa token)
    - Set `email_verified_at` về thời gian hiện tại
    - Lưu user
3. Redirect về trang login với thông báo tương ứng

#### 5.3. Method `loginPost()` - Kiểm tra xác thực khi login

```php
public function loginPost(Request $request)
{
    $payload = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'Email là trường bắt buộc',
        'email.email' => 'Email không hợp lệ',
        'password.required' => 'Mật khẩu là trường bắt buộc',
    ]);

    if (Auth::attempt($payload)) {
        // Kiểm tra email đã được xác thực chưa
        if (Auth::user()->email_verified_at == null) {
            Auth::logout(); // Đăng xuất ngay lập tức
            return redirect()->route('auth.login.index')
                ->with('error', 'Vui lòng xác nhận email để đăng nhập');
        }

        return redirect()->route('home.index')
            ->with('success', 'Đăng nhập thành công');
    } else {
        return redirect()->back()
            ->with('error', 'Email hoặc mật khẩu không đúng')
            ->withInput();
    }
}
```

**Giải thích:**

-   Sau khi xác thực thành công với `Auth::attempt()`
-   Kiểm tra `email_verified_at` có null không
-   Nếu null (chưa xác thực email) → logout và thông báo lỗi
-   Nếu đã xác thực → cho phép đăng nhập

---

### Bước 6: Định Nghĩa Routes

**File:** `routes/auth.php`

```php
use App\Http\Controllers\Auth\AuthController;

// Routes cho auth (login, register)
Route::prefix('auth')->name('auth.')->middleware('checkLogin')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

    Route::get('/register', [AuthController::class, 'register'])->name('register.index');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
});

// Route logout
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Route xác thực email (public, không cần auth)
Route::get('/very/{token}', [AuthController::class, 'very'])->name('auth.very');
```

**Giải thích:**

-   `/auth/login` - Hiển thị form login
-   `/auth/register` - Hiển thị form đăng ký
-   `/auth/logout` - Đăng xuất
-   `/very/{token}` - Route xác thực email (nhận token từ URL)

---

### Bước 7: Cấu Hình Email (Tùy Chọn)

**File:** `.env`

Cấu hình SMTP để gửi email thực tế (hoặc dùng log để test):

#### Sử dụng Gmail SMTP:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=phantohiroxi@gmail.com
MAIL_PASSWORD=eonbcjpvqbfadext
MAIL_FROM_ADDRESS="phantohiroxi@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Sử dụng Log (cho development):

```env
MAIL_MAILER=log
MAIL_LOG_CHANNEL=stack
```

**Lưu ý:**

-   Với Gmail, cần sử dụng "App Password" thay vì password thường
-   Email sẽ được log vào `storage/logs/laravel.log` khi dùng log driver

---

### Bước 8: Cấu Hình Queue

**File:** `.env`

```env
QUEUE_CONNECTION=database
```

**Chạy migration cho bảng jobs:**

```bash
php artisan queue:table
php artisan migrate
```

**Chạy queue worker:**

```bash
php artisan queue:work
```

**Lưu ý:**

-   Để chạy background, sử dụng supervisor (production)
-   Trong development, có thể dùng `QUEUE_CONNECTION=sync` để chạy đồng bộ

---

## Luồng Hoạt Động Tổng Thể

### 1. Đăng Ký

```
User điền form đăng ký
    ↓
AuthController::registerPost()
    ↓
Tạo User mới → Gán role 'customer'
    ↓
Tạo token ngẫu nhiên (60 ký tự)
    ↓
Lưu token vào very_mail_token
    ↓
Dispatch job SendVeryEmail
    ↓
Job gửi email với link xác thực
    ↓
Redirect về login với thông báo
```

### 2. Xác Thực Email

```
User nhấn vào link trong email
    ↓
GET /very/{token}
    ↓
AuthController::very($token)
    ↓
Tìm user có very_mail_token = $token
    ↓
Nếu tìm thấy:
  - Set very_mail_token = null
  - Set email_verified_at = now()
  - Save user
    ↓
Redirect về login với thông báo thành công
```

### 3. Đăng Nhập

```
User điền form login
    ↓
AuthController::loginPost()
    ↓
Validate email + password
    ↓
Auth::attempt() thành công?
    ↓
Kiểm tra email_verified_at
    ↓
Nếu null → Logout + Thông báo lỗi
    ↓
Nếu có giá trị → Cho phép đăng nhập
```

---

## Cấu Trúc Database

### Bảng `users`

| Cột                 | Kiểu      | Mô tả                    |
| ------------------- | --------- | ------------------------ |
| `id`                | bigint    | Primary key              |
| `name`              | string    | Tên người dùng           |
| `email`             | string    | Email (unique)           |
| `password`          | string    | Mật khẩu đã hash         |
| `email_verified_at` | timestamp | Thời gian xác thực email |
| `remember_token`    | string    | Token remember me        |
| `very_mail_token`   | string    | Token xác thực email     |
| `created_at`        | timestamp | Thời gian tạo            |
| `updated_at`        | timestamp | Thời gian cập nhật       |

---

## Các File Quan Trọng

1. **Migration:**

    - `database/migrations/2025_10_24_130143_add_columd_very_token_to_users.php`

2. **Models:**

    - `app/Models/User.php`

3. **Controllers:**

    - `app/Http/Controllers/Auth/AuthController.php`

4. **Jobs:**

    - `app/Jobs/SendVeryEmail.php`

5. **Mailable:**

    - `app/Mail/VeryEmail.php`

6. **Views:**

    - `resources/views/mail/verify.blade.php`
    - `resources/views/client/page/auth/login.blade.php`
    - `resources/views/client/page/auth/register.blade.php`

7. **Routes:**

    - `routes/auth.php`

8. **Config:**
    - `config/mail.php`

---
