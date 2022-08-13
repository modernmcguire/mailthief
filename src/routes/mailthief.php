<?php

use Illuminate\Support\Facades\Route;
use ModernMcGuire\MailThief\Http\Controllers\InboxController;

Route::get(config('mailthief.endpoint'), [InboxController::class, 'index'])->name('index');
