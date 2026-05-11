<x-app-layout>

    <div class="max-w-6xl mx-auto py-6">

        <div class="flex justify-between mb-5">
            <h2 class="text-2xl font-bold">
                Companies
            </h2>

            <a href="{{ route('companies.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Company
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-200 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">

            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">#</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Phone</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @php 
                    $counter = ($companies->currentPage() - 1) * $companies->perPage() + 1; @endphp
                @forelse($companies as $company)

                    <tr>
                        <td class="border p-2">
                            {{ $counter++ }}
                        </td>
                        </td>

                        <td class="border p-2">
                            {{ $company->name }}
                        </td>

                        <td class="border p-2">
                            {{ $company->email }}
                        </td>

                        <td class="border p-2">
                            {{ $company->phone }}
                        </td>

                        <td class="border p-2 flex gap-2">

                            <a href="{{ route('companies.show', $company->id) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded">
                                View
                            </a>

                            <a href="{{ route('companies.edit', $company->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center p-4">
                            No companies found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>

    </div>

</x-app-layout>