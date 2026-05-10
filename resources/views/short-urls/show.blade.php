<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Short URL Details') }}
            </h2>
            <div class="space-x-3">
                @if(!auth()->user()->hasRole('superadmin'))
                    <a href="{{ route('short-urls.edit', $shortUrl) }}"
                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endif
                <a href="{{ route('short-urls.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($shortUrl->isExpired())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    This short URL has expired and will no longer redirect.
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Short Code</label>
                            <div class="mt-2 flex items-center gap-2">
                                <code class="text-2xl font-bold bg-gray-100 px-3 py-2 rounded">{{ $shortUrl->short_code }}</code>
                                <button type="button"
                                        onclick="copyToClipboard('{{ $shortUrl->short_url }}')"
                                        class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Short URL</label>
                            <a href="{{ $shortUrl->short_url }}"
                               target="_blank"
                               class="text-lg font-semibold text-blue-600 hover:text-blue-900 break-all">
                                {{ $shortUrl->short_url }}
                            </a>
                        </div>

                        <div class="col-span-2">
                            <label class="text-sm font-medium text-gray-500">Original URL</label>
                            <a href="{{ $shortUrl->original_url }}"
                               target="_blank"
                               class="text-lg font-semibold text-blue-600 hover:text-blue-900 break-all">
                                {{ $shortUrl->original_url }}
                            </a>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Created By</label>
                            <p class="text-lg font-semibold">{{ $shortUrl->user->name }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Total Clicks</label>
                            <p class="text-3xl font-bold text-blue-600">{{ $shortUrl->clicks }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Created At</label>
                            <p class="text-lg font-semibold">{{ $shortUrl->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            @if($shortUrl->isExpired())
                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-semibold">
                                    Expired
                                </span>
                            @else
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-semibold">
                                    Active
                                </span>
                            @endif
                        </div>

                        @if($shortUrl->expires_at)
                            <div class="col-span-2">
                                <label class="text-sm font-medium text-gray-500">Expires At</label>
                                <p class="text-lg font-semibold">{{ $shortUrl->expires_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif

                        @if($shortUrl->description)
                            <div class="col-span-2">
                                <label class="text-sm font-medium text-gray-500">Description</label>
                                <p class="text-lg">{{ $shortUrl->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!auth()->user()->hasRole('superadmin'))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('short-urls.destroy', $shortUrl) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this short URL?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Short URL
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Short URL copied to clipboard!');
            }).catch(() => {
                alert('Failed to copy to clipboard');
            });
        }
    </script>
</x-app-layout>
