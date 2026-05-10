<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
                @if(auth()->user()->hasRole('SuperAdmin'))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Companies</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $companiesCount }}</p>
                            </div>
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581M9 3h0m5.581 18H9"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Short URLs</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $shortUrlsCount }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $scopeLabel }}</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m4 4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Short URL Hits</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $shortUrlClicks }}</p>
                                <p class="text-xs text-gray-500 mt-1">Browser redirects</p>
                            </div>
                            <div class="bg-yellow-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7-9-7-9 7 9 7z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l9-7-9 7-9-7 9 7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!auth()->user()->hasRole('SuperAdmin'))
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Company Admins</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $adminsCount }}</p>
                                <p class="text-xs text-gray-500 mt-1">Admins in your company</p>
                            </div>
                            <div class="bg-purple-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20H4v-2a3 3 0 013-3h4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Company Members</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $membersCount }}</p>
                                <p class="text-xs text-gray-500 mt-1">Members in your company</p>
                            </div>
                            <div class="bg-pink-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20H4v-2a3 3 0 013-3h4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a4 4 0 10-6 0"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
