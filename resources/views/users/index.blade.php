<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Company Users - ' . $company->name) }}
            </h2>
            <a href="{{ route('users.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add User
            </a>
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
                    @if($users->count())
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4">Name</th>
                                    <th class="text-left py-3 px-4">Email</th>
                                    <th class="text-left py-3 px-4">Role</th>
                                    <th class="text-left py-3 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $user->name }}</td>
                                        <td class="py-3 px-4">{{ $user->email }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $role = $user->pivot->role;
                                                $badgeClass = $role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $badgeClass }}">
                                                {{ ucfirst($role) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('users.show', $user) }}"
                                               class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No users found. <a href="{{ route('users.create') }}"
                               class="text-blue-600 hover:text-blue-900">Add one now</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
