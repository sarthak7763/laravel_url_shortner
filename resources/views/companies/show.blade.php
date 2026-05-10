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

    </div>

</x-app-layout>