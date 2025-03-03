<div class="mt-8" x-data="{
    email: @entangle('email'),
}">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.js"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <div class="">
        <div class="w-full flex items-end pl-8 mb-8">
            <img src="{{ asset('vendor/mailthief/mailthief-icon.svg') }}" width="64" class="mr-3 h-42 w-42" />
        </div>
        <div class="w-full">
            <hr>
            <div class="">
                <div class="flex flex-col md:flex-row mx-auto ">
                    <div class="w-full md:w-1/3 border-r">
                        <div class="mx-4 my-4 flex flex-row gap-x-4">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <input type="search" class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md" id="search" placeholder="Search" wire:model.debounce.500ms="search" />
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <img src="{{ asset('vendor/mailthief/search-icon.png') }}" class="h-5 w-5 mr-2" />
                                </div>
                            </div>
                            <button type="button" class="w-32 inline-flex items-center justify-center px-2 py-2 text-base -ml-px text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-md leading-5 hover:text-gray-400 focus:z-10 
                                focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" wire:click="clearSearch">
                                Clear All
                            </button>
                        </div>

                        <ul class="">
                            @foreach ($emails as $singleEmail)
                            <li class="cursor-pointer p-3 {{ $loop->first ? '' : 'border-t' }} border-gray-300 {{ !empty($email) && $email->id == $singleEmail->id ? 'bg-white' : 'bg-[#FAFBF0]' }}"
                                wire:click="selectEmail({{ $singleEmail->id }})"
                                wire:key="email-{{ $singleEmail->id }}">

                                <div class="flex flex-row gap-x-2 w-full">
                                    <div class="flex-shrink-0 ml-2">
                                        @if (!empty($email) && $email->id == $singleEmail->id)
                                            <img src="{{ asset('vendor/mailthief/selected-mail-icon.png')}}" alt="Mail Icon" class="h-12 w-5 mt-1" />
                                        @else
                                            <div class="h-12 w-5"></div>
                                        @endif
                                    </div>
                                    <div class="flex flex-row w-full">
                                        <div class="flex flex-col w-full">
                                            <div class="flex w-full flex-row justify-between">
                                                <div class="w-full font-semibold text-lg mb">
                                                    {{ $singleEmail->from[0]['name'] ?? 'No Name' }}
                                                </div>
                                                <div class="w-auto flex-shrink-0 ml-4 lowercase">
                                                    {{ $singleEmail->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="w-full font-semibold text-lg">
                                                {{ $singleEmail->subject ?? 'No Subject' }}</div>
                                            <div class="w-full text-gray-500">
                                                {{ Str::limit($singleEmail->text ?? strip_tags($singleEmail->html), 120, '...') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="flex justify-center my-4">
                            {{ $emails->links() }}
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        @if($email)
                        
                        <div class="" x-data="{ tab: 'html' }">
                            <nav class="ml-8 my-4 flex justify-between" aria-label="Tabs">
                                <div class="flex">
                                    <a href="#" x-on:click="tab = 'html'"
                                        class="text-base whitespace-nowrap border-t border-b border-l border-gray-300 px-6 py-2 text-sm text-black hover:text-gray-700 capitalize rounded-l-md"
                                        :class="{'bg-[#CACE00] font-bold text-black': tab === 'html', 'font-medium': tab !== 'html'}">HTML</a>
                                    <a href="#" x-on:click="tab = 'source'"
                                        class="text-base whitespace-nowrap border {{ $email ? 'border-gray-300' : 'border-gray-200' }} px-6 py-2 text-sm text-black hover:text-gray-700 capitalize"
                                        :class="{'bg-[#CACE00] font-bold text-black': tab === 'source', 'font-medium': tab !== 'source'}">Source</a>
                                    <a href="#" x-on:click="tab = 'text'"
                                        class="text-base whitespace-nowrap border-t border-b border-r {{ $email ? 'border-gray-300' : 'border-gray-200' }} px-6 py-2 text-sm text-black hover:text-gray-700 capitalize rounded-r-md"
                                        :class="{'bg-[#CACE00] font-bold text-black': tab === 'text', 'font-medium': tab !== 'text'}">Text</a>
                                    @if($email->attachments)
                                    <a href="#" x-on:click="tab = 'attachments'"
                                        class="text-base whitespace-nowrap border-t border-b border-r {{ $email ? 'border-gray-300' : 'border-gray-200' }} px-6 py-2 text-sm text-black hover:text-gray-700 capitalize rounded-r-md"
                                        :class="{'bg-[#CACE00] font-bold': tab === 'attachments', 'font-medium': tab !== 'attachments'}">Attachments</a>
                                    @endif
                                </div>
                                <div class="flex gap-4">
                                    <button type="button"
                                        class="text-base whitespace-nowrap border border-gray-300 px-6 py-2 text-sm text-black hover:text-gray-700 capitalize rounded-md"
                                        wire:click="deleteEmail({{ $email->id }})">
                                        <span class="inline-flex items-center">
                                            <img src="{{ asset('vendor/mailthief/delete-icon.png') }}" class="h-4 w-5 mr-1" />
                                            Delete
                                        </span>
                                    </button>
                                    <button type="button"
                                        class="text-base whitespace-nowrap border border-gray-300 mr-8 px-6 py-2 text-sm text-black hover:text-gray-700 capitalize rounded-md"
                                        wire:click="shareEmail({{ $email->id }})">
                                        <span class="inline-flex items-center">
                                            <img src="{{ asset('vendor/mailthief/share-link-icon.png') }}" class="h-4 w-5 mr-1" />
                                            Share Email Link
                                        </span>
                                    </button>
                                </div>
                            </nav>

                            <div class="bg-white border-l border-t border-r">
                                <div class="flex flex-row gap-4 p-4 mb-4">
                                    <div class="flex flex-col w-full">
                                        <div class="flex w-full flex-row justify-between">
                                            <div class="w-full text-base mb-2">
                                                <span class="font-bold">{{ $email->from[0]['name'] ?? 'No Name'
                                                    }}</span>
                                                <span class="text-base">({{ $email->from[0]['email'] }})</span>
                                            </div>
                                            <div class="w-auto flex-shrink-0 ml-4 ">{{ $email->created_at->format('F j,
                                                Y g:i A') }}</div>
                                        </div>
                                        <div class="w-full ">To: {{ $email->to[0]['email'] }}</div>
                                    </div>
                                </div>
                                <div :class="{'hidden': tab !== 'html'}" id="html-tab-pane" role="tabpanel"
                                    aria-labelledby="html-tab" tabindex="0">
                                    <iframe class="w-full overflow-auto" srcdoc="{{ $email->html }}"
                                        onload="resizeIframe(this)" wire:key="email-{{ $email->id }}-html"></iframe>
                                </div>
                                <div :class="{'hidden': tab !== 'source'}" id="source-tab-pane" role="tabpanel"
                                    aria-labelledby="source-tab" tabindex="0">
                                    <div class="p-4 w-full">
                                        <pre
                                            class="overflow-auto"><code class="language-html w-full overflow-x-auto">{{ $email->html }}</code></pre>
                                    </div>
                                </div>
                                <div :class="{'hidden': tab !== 'text'}" id="text-tab-pane" role="tabpanel"
                                    aria-labelledby="text-tab" tabindex="0">
                                    <div class="p-4">
                                        {!! nl2br($email->text) !!}
                                    </div>
                                </div>

                                @if($email->attachments)
                                <div class="hidden" id="attachments-tab-pane" role="tabpanel"
                                    aria-labelledby="attachments-tab" tabindex="0">
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