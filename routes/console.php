<?php
# Vai trò: Nơi khai báo các lệnh console tùy chỉnh của Laravel.

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
