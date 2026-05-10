<x-app-layout>

    <div class="max-w-4xl mx-auto py-6">

        <h2 class="text-2xl font-bold mb-5">
            Add Company
        </h2>

        <form action="{{ route('companies.store') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4">Company Details</h2>
            @include('companies.form')

            <h2 class="text-xl font-semibold mb-4">Admin Details</h2>
            @include('companies.admin_form')

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>

    </div>

</x-app-layout>