<?php

namespace ModernMcGuire\MailThief\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use ModernMcGuire\MailThief\MailThief;

class Inbox extends Component
{
    use WithPagination;

    private const EMAILS_PAGE_LIMIT = 10;

    public $search = '';

    public function mount()
    {
        $this->email = MailThief::latest()->first()?->refresh();
    }

    public function selectEmail($id)
    {
        $this->email = MailThief::find($id);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $emails = MailThief::latest()
            ->when($this->search, function($query, $search) {
                return $query
                    ->where('subject', 'like', "%{$search}%")
                    ->orWhere('text', 'like', "%{$search}%")
                    ->orWhere('html', 'like', "%{$search}%");
            })
            ->limit(self::EMAILS_PAGE_LIMIT)
            ->paginate(self::EMAILS_PAGE_LIMIT)
            ->onEachSide(1);

        return view('mailthief::livewire.inbox', [
            'emails' => $emails,
        ]);
    }

    public function paginationView()
    {
        return 'mailthief::livewire.pagination.bootstrap';
    }
}
