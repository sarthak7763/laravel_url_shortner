<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if($company)
                {{'Short URLs - ' . $company?->name ?? 'All Companies' }}
                @else
                {{'Short URLs - All Companies' }}
                @endif
            </h2>
            @if(!auth()->user()->hasRole('SuperAdmin') || (auth()->user()->hasRole('SuperAdmin') && $company))
                <a href="{{ route('short-urls.create') }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Short URL
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($shortUrls->count())
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b bg-gray-50">
                                        <th class="text-left py-3 px-4">Short Code</th>
                                        <th class="text-left py-3 px-4">Original URL</th>
                                        <th class="text-left py-3 px-4">Created By</th>
                                        <th class="text-left py-3 px-4">Clicks</th>
                                        <th class="text-left py-3 px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shortUrls as $url)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">
                                                <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $url->short_code }}</code>
                                            </td>
                                            <td class="py-3 px-4">
                                                <a href="{{ $url->original_url }}"
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-900 truncate"
                                                   title="{{ $url->original_url }}">
                                                    {{ substr($url->original_url, 0, 40) }}...
                                                </a>
                                            </td>
                                            <td class="py-3 px-4">{{ $url->user->name }}</td>
                                            <td class="py-3 px-4">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                                    {{ $url->clicks }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <a href="{{ route('short-urls.show', $url) }}"
                                                   class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                
                                                @if(!$user->hasRole('SuperAdmin') || $user->canEditShortUrl($url, $company) ?? false)
                                                    <a href="{{ route('short-urls.edit', $url) }}"
                                                       class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $shortUrls->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">
                            @if($user->hasRole('SuperAdmin'))
                                No short URLs created yet.
                            @elseif($user->hasRole('Admin') && $user->hasCompanyRole($company, 'admin'))
                                No short URLs created in this company yet.
                                <a href="{{ route('short-urls.create') }}"
                                   class="text-blue-600 hover:text-blue-900">Create one now</a>
                            @else
                                No short URLs created by you yet.
                                <a href="{{ route('short-urls.create') }}"
                                   class="text-blue-600 hover:text-blue-900">Create one now</a>
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
