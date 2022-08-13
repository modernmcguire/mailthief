<?php

namespace ModernMcGuire\MailThief\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use ModernMcGuire\MailThief\MailThief;

class InboxController extends Controller
{
    public function index()
    {
        return view('mailthief::index');
    }
}
