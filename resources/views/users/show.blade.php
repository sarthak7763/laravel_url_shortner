<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details - ' . $user->name) }}
            </h2>
            <div class="space-x-3">
                <a href="{{ route('users.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Name</label>
                            <p class="text-lg font-semibold">{{ $user->name }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-lg font-semibold">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Role in {{ $company->name }}</label>
                            <p class="text-lg">
                                @php
                                    $badgeClass = $userRole === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $badgeClass }}">
                                    {{ ucfirst($userRole) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Joined Date</label>
                            <p class="text-lg font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
