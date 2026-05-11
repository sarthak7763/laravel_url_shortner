<div class="mb-3">
    <label class="block mb-2 font-medium">Original URL *</label>
    <input type="url"
           name="original_url"
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
           value="{{ old('original_url', $shortUrl->original_url ?? '') }}"
           placeholder="https://example.com/very/long/url"
           required>

    @error('original_url')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="block mb-2 font-medium">Description</label>
    <textarea name="description"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
              rows="3"
              placeholder="Optional description for this short URL">{{ old('description', $shortUrl->description ?? '') }}</textarea>

    @error('description')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
