<?php

namespace ModernMcGuire\MailThief;

use Illuminate\Database\Eloquent\Model;

class MailThief extends Model
{
    protected $table = 'mailthief';

    protected $guarded = [];

    protected $casts = [
        'from' => 'array',
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'attachments' => 'array',
    ];
}
