<div class="container-fluid mt-3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .nav-tabs .nav-link.small {
            font-size: 0.875rem !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12 d-flex align-items-end justify-content-center">
            <img src="{{ asset('vendor/mailthief/icon.png') }}" width="64" class="me-3" />
            <h1 class="text-center mb-0 ml-3">
                MailThief Inbox
            </h1>
        </div>
        <div class="col-md-12">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="search" class="visually-hidden">Search</label>
                        <input type="search" class="form-control" id="search" placeholder="Search..." wire:model.debounce.500ms="search" />
                    </div>

                    <div>
                        {{ $emails->links() }}
                    </div>

                    <ul class="list-group">
                        @foreach ($emails as $singleEmail)
                            <li
                                @class([
                                    'list-group-item',
                                    'bg-dark-subtle' => !empty($email) && $email->id == $singleEmail->id,
                                ])
                                role="button"
                                wire:click="selectEmail({{ $singleEmail->id }})"
                                wire:key="email-{{ $singleEmail->id }}"
                            >
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-primary">{{ $singleEmail->subject }}</span><br />
                                        <span class="text-muted text-sm">
                                            {{ collect($singleEmail->to)->pluck('email')->join(', ') }}
                                        </span><br />
                                        <span class="form-text">
                                            @if($singleEmail->created_at < now()->subDay())
                                                {{ $singleEmail->created_at->toDateTimeLocalString() }}
                                            @else
                                                {{ $singleEmail->created_at->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column justify-content-around align-items-center">
                                        <span class="badge bg-secondary badge-pill">#{{ $singleEmail->id }}</span>
                                        @if($singleEmail->attachments)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-8">
                    @if($email)
                        <table class="table bg-white rounded border">
                            <tr id="from">
                                <th class="w-25">From:</th>
                                <td>
                                    @foreach($email->from as $from)
                                        {{ data_get($from, 'name') }} {{ data_get($from, 'email') }}<br />
                                    @endforeach
                                </td>
                            </tr>

                            <tr id="to">
                                <th class="w-25">To:</th>
                                <td>
                                    @foreach($email->to as $recipient)
                                        {{ data_get($recipient, 'name') }} {{ data_get($recipient, 'email') }}<br />
                                    @endforeach
                                </td>
                            </tr>

                            @if($email->cc)
                                <tr id="cc">
                                    <th class="w-25">Cc:</th>
                                    <td>
                                        @foreach($email->cc as $cc)
                                            {{ data_get($cc, 'name') }} {{ data_get($cc, 'email') }}<br />
                                        @endforeach
                                    </td>
                                </tr>
                            @endif

                            @if($email->bcc)
                                <tr id="bcc">
                                    <th class="w-25">Bcc:</th>
                                    <td>
                                        @foreach($email->bcc as $bcc)
                                            {{ data_get($bcc, 'name') }}<{{ data_get($bcc, 'email') }}><br />
                                        @endforeach
                                    </td>
                                </tr>
                            @endif

                            <tr id="subject">
                                <th class="w-25">Subject:</th>
                                <td>{{ $email->subject }}</td>
                            </tr>

                            <tr id="date">
                                <th class="w-25">Date:</th>
                                <td>{{ $email->created_at->toDateTimeLocalString() }}</td>
                            </tr>
                        </table>

                        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link bg-transparent border-0 small {{ $email->html ? 'active' : '' }}" id="html-tab" data-bs-toggle="tab" data-bs-target="#html-tab-pane" type="button" role="tab" aria-controls="html-tab-pane" aria-selected="true">HTML</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link bg-transparent border-0 small" id="source-tab" data-bs-toggle="tab" data-bs-target="#source-tab-pane" type="button" role="tab" aria-controls="source-tab-pane" aria-selected="false">HTML Source</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link bg-transparent border-0 small {{ !$email->html && $email->text ? 'active' : '' }}" id="text-tab" data-bs-toggle="tab" data-bs-target="#text-tab-pane" type="button" role="tab" aria-controls="text-tab-pane" aria-selected="false">Text</button>
                            </li>
                            @if($email->attachments)
                                <li class="nav-item" role="presentation" id="attachments">
                                    <button class="nav-link bg-transparent border-0 small" id="attachments-tab" data-bs-toggle="tab" data-bs-target="#attachments-tab-pane" type="button" role="tab" aria-controls="attachments-tab-pane" aria-selected="false">Attachments</button>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade {{ $email->html ? 'show active' : '' }}" id="html-tab-pane" role="tabpanel" aria-labelledby="html-tab" tabindex="0">
                                <div class="border">
                                    <iframe class="w-100" style="height: 800px;" srcdoc="{{ $email->html }}"></iframe>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="source-tab-pane" role="tabpanel" aria-labelledby="source-tab" tabindex="0">
                                <div class="border bg-white p-3">
                                    <code>
                                        <pre>{{ $email->html }}</pre>
                                    </code>
                                </div>
                            </div>
                            <div class="tab-pane fade {{ !$email->html && $email->text ? 'show active' : '' }}" id="text-tab-pane" role="tabpanel" aria-labelledby="text-tab" tabindex="0">
                                <div class="border bg-white p-3">
                                    {!! nl2br($email->text) !!}
                                </div>
                            </div>
                            @if($email->attachments)
                                <div class="tab-pane fade" id="attachments-tab-pane" role="tabpanel" aria-labelledby="attachments-tab" tabindex="0">
                                    <div class="border bg-white p-3">
                                        <ul>
                                            @foreach($email->attachments as $attachment)
                                                {{ $attachment }}<br />
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="card" id="empty">
                            <div class="card-body">
                                <h5 class="card-title">No email selected</h5>
                                <div class="card-text">Please select an email from the list.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

