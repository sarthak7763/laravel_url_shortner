<div class="mb-3">
    <label>Company Name</label>
    <input type="text"
           name="name"
           class="border rounded w-full p-2"
           value="{{ old('name', $company->name ?? '') }}">

    @error('name')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Company Email</label>
    <input type="email"
           name="email"
           class="border rounded w-full p-2"
           value="{{ old('email', $company->email ?? '') }}">
</div>

<div class="mb-3">
    <label>Company Phone</label>
    <input type="text"
           name="phone"
           class="border rounded w-full p-2"
           value="{{ old('phone', $company->phone ?? '') }}">
</div>

<div class="mb-3">
    <label>Company Website</label>
    <input type="text"
           name="website"
           class="border rounded w-full p-2"
           value="{{ old('website', $company->website ?? '') }}">
</div>

<div class="mb-3">
    <label>Company Address</label>
    <textarea name="address"
              class="border rounded w-full p-2">{{ old('address', $company->address ?? '') }}</textarea>
</div>