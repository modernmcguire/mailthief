<div class="row">
    <div class="col-md-4">
        <ul class="list-group">
            @foreach ($emails as $singleEmail)
                <li class="list-group-item" role="button" wire:click="selectEmail({{ $singleEmail->id }})" style="{{ !empty($email) && $email->id == $singleEmail->id ? 'background-color: var(--bs-gray-300)' : '' }}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-primary">{{ $singleEmail->subject }}</span><br />
                            <span class="text-muted text-sm">
                                {{ collect($singleEmail->to)->pluck('email')->join(', ') }}
                            </span><br />
                            <span class="form-text">({{ $singleEmail->created_at->toDateTimeLocalString() }})</span>
                        </div>
                        <div class="d-flex flex-column justify-content-around align-items-center">
                            <span class="badge bg-secondary badge-pill">#{{ $singleEmail->id }}</span>
                            @if($singleEmail->attachments)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
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
                    <th class="w-25">From:</td>
                    <td>
                        @foreach($email->from as $from)
                            {{ @$from['name'] }} {{ @$from['email'] }}<br />
                        @endforeach
                    </td>
                </tr>
                <tr id="to">
                    <th class="w-25">To:</th>
                    <td>
                        @foreach($email->to as $recipient)
                            {{ @$recipient['name'] }} {{ @$recipient['email'] }}<br />
                        @endforeach
                    </td>
                </tr>
                @if($email->cc)
                    <tr id="cc">
                        <th class="w-25">Cc:</th>
                        <td>
                            @foreach($email->cc as $cc)
                                {{ @$cc['name'] }} {{ @$cc['email'] }}<br />
                            @endforeach
                        </td>
                    </tr>
                @endif
                @if($email->bcc)
                    <tr id="bcc">
                        <th class="w-25">Bcc:</th>
                        <td>
                            @foreach($email->bcc as $bcc)
                                {{ @$bcc['name'] }} <{{ @$bcc['email'] }}><br />
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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="html-tab" data-bs-toggle="tab" data-bs-target="#html-tab-pane" type="button" role="tab" aria-controls="html-tab-pane" aria-selected="true">HTML</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="source-tab" data-bs-toggle="tab" data-bs-target="#source-tab-pane" type="button" role="tab" aria-controls="source-tab-pane" aria-selected="false">HTML Source</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="text-tab" data-bs-toggle="tab" data-bs-target="#text-tab-pane" type="button" role="tab" aria-controls="text-tab-pane" aria-selected="false">Text</button>
                </li>
                @if($email->attachments)
                    <li class="nav-item" role="presentation" id="attachments">
                        <button class="nav-link" id="attachments-tab" data-bs-toggle="tab" data-bs-target="#attachments-tab-pane" type="button" role="tab" aria-controls="attachments-tab-pane" aria-selected="false">Attachments</button>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="html-tab-pane" role="tabpanel" aria-labelledby="html-tab" tabindex="0">
                    <div class="border">
                        <iframe class="w-100" style="height: 800px;" srcdoc="{{ $email->html }}"></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="source-tab-pane" role="tabpanel" aria-labelledby="source-tab" tabindex="0">
                    <div class="border bg-white p-3">
                        <code><pre>{{ $email->html }}</pre></code>
                    </div>
                </div>
                <div class="tab-pane fade" id="text-tab-pane" role="tabpanel" aria-labelledby="text-tab" tabindex="0">
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
