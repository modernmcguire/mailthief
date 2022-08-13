<?php

namespace ModernMcGuire\MailThief\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use ModernMcGuire\MailThief\MailThief;

class Inbox extends Component
{
    public $emails;
    public $email;

    public function mount()
    {
        $this->emails = MailThief::latest()->get(['id','from','subject','attachments','created_at']);
        $this->email = $this->emails->first()->refresh();
    }

    public function selectEmail($id)
    {
        $this->email = MailThief::find($id);
    }

    public function render()
    {
        return view('mailthief::livewire.inbox');
    }
}
