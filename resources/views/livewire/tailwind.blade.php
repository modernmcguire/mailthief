<div class="mt-8" x-data="{
    email: @entangle('email'),
}">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.js"></script>
    <div class="">
        <div class="w-full flex items-end justify-center mb-8">
            <img src="{{ asset('vendor/mailthief/icon.png') }}" width="64" class="mr-3" />
            <h1 class="text-center mb-0 ml-3 text-4xl">
                MailThief Inbox
            </h1>
        </div>
        <div class="w-full">
            <hr>
            <div class="mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <div class="flex flex-col md:flex-row mx-auto">
                    <div class="w-full md:w-1/3 pr-4">
                        <div class="mb-4">
                            <label for="search" class="sr-only">Search</label>
                            <input type="search" class="w-full px-3 py-2 border border-gray-300 rounded-md" id="search" placeholder="Search..." wire:model.debounce.500ms="search" />
                        </div>

                        <div class="flex justify-center my-4">
                            {{ $emails->links() }}
                        </div>

                        <ul class="space-y-2">
                            @foreach ($emails as $singleEmail)
                                <li class="cursor-pointer p-3 rounded-md {{ !empty($email) && $email->id == $singleEmail->id ? 'bg-gray-200' : 'bg-white' }}" wire:click="selectEmail({{ $singleEmail->id }})" wire:key="email-{{ $singleEmail->id }}">
                                    <div class="flex justify-between">
                                        <div>
                                            <span class="text-indigo-500">{{ $singleEmail->subject }}</span><br />
                                            <span class="text-gray-500 text-sm">
                                                {{ collect($singleEmail->to)->pluck('email')->join(', ') }}
                                            </span><br />
                                            <span class="text-xs text-gray-400">
                                                @if($singleEmail->created_at < now()->subDay())
                                                    {{ $singleEmail->created_at->toDateTimeLocalString() }}
                                                @else
                                                    {{ $singleEmail->created_at->diffForHumans() }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex flex-col justify-around items-center">
                                            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">#{{ $singleEmail->id }}</span>
                                            @if($singleEmail->attachments)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="w-full md:w-2/3">
                        @if($email)
                        <table class="w-full bg-white rounded-lg border border-gray-200">
                            <tr id="from" class="border-b">
                                <th class="w-1/4 px-4 py-2 text-left">From:</th>
                                <td class="px-4 py-2">
                                    @foreach($email->from as $from)
                                        {{ data_get($from, 'name') }} {{ data_get($from, 'email') }}<br />
                                    @endforeach
                                </td>
                            </tr>
                            <tr id="to" class="border-b">
                                <th class="w-1/4 px-4 py-2 text-left">To:</th>
                                <td class="px-4 py-2">
                                    @foreach($email->to as $recipient)
                                        {{ data_get($recipient, 'name') }} {{ data_get($recipient, 'email') }}<br />
                                    @endforeach
                                </td>
                            </tr>

                            @if($email->cc)
                            <tr id="cc">
                                <th class="w-1/4 px-4 py-2 text-left">Cc:</th>
                                <td class="px-4 py-2">
                                    @foreach($email->cc as $cc)
                                        {{ data_get($cc, 'name') }} {{ data_get($cc, 'email') }}<br />
                                    @endforeach
                                </td>
                            </tr>
                            @endif

                            @if($email->bcc)
                            <tr id="bcc" class="border-b">
                                <th class="w-1/4 px-4 py-2 text-left">Bcc:</th>
                                <td class="px-4 py-2">
                                    @foreach($email->bcc as $bcc)
                                        {{ data_get($bcc, 'name') }}<{{ data_get($bcc, 'email') }}><br />
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            <tr id="subject" class="border-b">
                                <th class="w-1/4 px-4 py-2 text-left">Subject:</th>
                                <td class="px-4 py-2">{{ $email->subject }}</td>
                            </tr>
                            <tr id="date">
                                <th class="w-1/4 px-4 py-2 text-left">Date:</th>
                                <td class="px-4 py-2">{{ $email->created_at->toDateTimeLocalString() }}</td>
                            </tr>
                        </table>
                        <div class="mt-4" x-data="{ tab: 'html' }">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <a href="#" x-on:click="tab = 'html'"   class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" :class="{'border-indigo-500 text-indigo-600': tab === 'html'}">HTML</a>
                                <a href="#" x-on:click="tab = 'source'" class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" :class="{'border-indigo-500 text-indigo-600': tab === 'source'}">Source</a>
                                <a href="#" x-on:click="tab = 'text'"   class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" :class="{'border-indigo-500 text-indigo-600': tab === 'text'}">Text</a>
                                @if($email->attachments)
                                    <a href="#" x-on:click="tab = 'attachments'"   class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" :class="{'border-indigo-500 text-indigo-600': tab === 'attachments'}">Attachments</a>
                                @endif
                            </nav>

                            <div class="bg-white border-l border-b border-r">
                                <div :class="{'hidden': tab !== 'html'}" id="html-tab-pane" role="tabpanel" aria-labelledby="html-tab" tabindex="0">
                                    <iframe class="w-full overflow-auto" srcdoc="{{ $email->html }}" onload="resizeIframe(this)" wire:key="email-{{ $email->id }}-html"></iframe>
                                </div>
                                <div :class="{'hidden': tab !== 'source'}" id="source-tab-pane" role="tabpanel" aria-labelledby="source-tab" tabindex="0">
                                    <div class="p-4 w-full">
                                        <pre class="overflow-auto"><code class="language-html w-full overflow-x-auto">{{ $email->html }}</code></pre>
                                    </div>
                                </div>
                                <div :class="{'hidden': tab !== 'text'}" id="text-tab-pane" role="tabpanel" aria-labelledby="text-tab" tabindex="0">
                                    <div class="p-4">
                                        {!! nl2br($email->text) !!}
                                    </div>
                                </div>

                                @if($email->attachments)
                                    <div class="hidden" id="attachments-tab-pane" role="tabpanel" aria-labelledby="attachments-tab" tabindex="0">
                                        <div class="p-4">
                                            <ul class="list-disc pl-5">
                                                @foreach($email->attachments as $attachment)
                                                <li>{{ $attachment }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="bg-white shadow-md rounded-lg p-6" id="empty">
                            <h5 class="text-xl font-bold mb-2">No email selected</h5>
                            <p>Please select an email from the list.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function resizeIframe(iframe) {
            // unless the doc height is greater than the screen height, set the irame height to the screen height
            if (iframe.contentWindow.document.body.scrollHeight >= (window.innerHeight - 450)) {
                iframe.style.height = (window.innerHeight - 450) + 'px';
            } else {
                // otherwise, set the iframe height to the document height
                iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
            }

        }
    </script>
</div>
