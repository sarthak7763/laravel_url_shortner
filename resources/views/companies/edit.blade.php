<x-app-layout>

    <div class="max-w-4xl mx-auto py-6">

        <h2 class="text-2xl font-bold mb-5">
            Edit Company
        </h2>

        <form action="{{ route('companies.update', $company->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('companies.form')

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Update
            </button>
        </form>

    </div>

</x-app-layout>