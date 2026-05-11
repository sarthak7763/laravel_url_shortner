<x-app-layout>

    <div class="max-w-4xl mx-auto py-6">

        <h2 class="text-2xl font-bold mb-5">
            Company Details
        </h2>

        <div class="border rounded p-5 bg-white">

            <p class="mb-3">
                <strong>Name:</strong>
                {{ $company->name }}
            </p>

            <p class="mb-3">
                <strong>Email:</strong>
                {{ $company->email }}
            </p>

            <p class="mb-3">
                <strong>Phone:</strong>
                {{ $company->phone }}
            </p>

            <p class="mb-3">
                <strong>Website:</strong>
                {{ $company->website }}
            </p>

            <p class="mb-3">
                <strong>Address:</strong>
                {{ $company->address }}
            </p>

        </div>

        <!-- Company Admins -->
        <div class="mt-6 border rounded p-5 bg-white">
            <h3 class="text-xl font-semibold mb-4">Company Admins</h3>
            @if($company->companyAdmins->count())
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Name</th>
                            <th class="text-left py-3 px-4">Email</th>
                            <th class="text-left py-3 px-4">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->companyAdmins as $admin)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $admin->name }}</td>
                                <td class="py-3 px-4">{{ $admin->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                        Admin
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No admins found for this company.</p>
            @endif
        </div>

        <!-- Company Users -->
        <div class="mt-6 border rounded p-5 bg-white">
            <h3 class="text-xl font-semibold mb-4">Company Users</h3>
            @if($company->companyMembers->count())
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Name</th>
                            <th class="text-left py-3 px-4">Email</th>
                            <th class="text-left py-3 px-4">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->companyMembers as $member)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $member->name }}</td>
                                <td class="py-3 px-4">{{ $member->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        Member
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No users found for this company.</p>
            @endif
        </div>

    </div>

</x-app-layout>