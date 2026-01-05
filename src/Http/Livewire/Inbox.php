<?php

namespace ModernMcGuire\MailThief\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use ModernMcGuire\MailThief\MailThief;

class Inbox extends Component
{
    use WithPagination;

    private const EMAILS_PAGE_LIMIT = 10;

    public $email = null;
    public $email_id = null;
    public $search = '';
    public $numberOfPaginatorsRendered = [];
    public $emailLink = '';

    protected $queryString = [
        'email_id',
    ];

    public function mount()
    {
        if (!config('mailthief.theme') || !in_array(config('mailthief.theme'), ['tailwind', 'bootstrap'])) {
            throw new \Exception('Please set MAILTHIEF_THEME in your .env. Available options: tailwind (default), bootstrap');
        }

        $this->selectEmail($this->email_id ?: MailThief::latest()->first()?->id);
    }

    public function selectEmail($id = null)
    {
        $this->email_id = $id;
        $this->email = $id
            ? MailThief::find($id)
            : null;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function deleteEmail($id)
    {
        MailThief::destroy($id);

        $this->selectEmail();
    }

    public function render()
    {
        $emails = MailThief::query()
            ->when($this->search, function ($query, $search) {
                return $query
                    ->where('subject', 'like', "%{$search}%")
                    ->orWhere('text', 'like', "%{$search}%")
                    ->orWhere('html', 'like', "%{$search}%");
            })
            ->latest()
            ->limit(self::EMAILS_PAGE_LIMIT)
            ->paginate(self::EMAILS_PAGE_LIMIT)
            ->onEachSide(1);


        return view('mailthief::livewire.' . config('mailthief.theme'), [
            'emails' => $emails,
        ]);
    }

    public function paginationView()
    {
        return 'mailthief::livewire.pagination.' . config('mailthief.theme');
    }
}
