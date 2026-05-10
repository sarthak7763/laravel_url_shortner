<div class="mb-3">
    <label>Admin Name</label>
    <input type="text"
           name="admin_name"
           class="border rounded w-full p-2"
           value="{{ old('admin_name', $admin->name ?? '') }}"
           required>

    @error('admin_name')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Admin Email</label>
    <input type="email"
           name="admin_email"
           class="border rounded w-full p-2"
           value="{{ old('admin_email', $admin->email ?? '') }}"
           required>

    @error('admin_email')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="block mb-1 font-medium">
        Admin Password
    </label>

    <div class="relative">
        <input type="password"
               id="admin_password"
               name="admin_password"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400"
               {{ isset($admin) ? '' : 'required' }}>

        <button type="button"
                onclick="togglePassword('admin_password')"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

            <svg id="eye-icon-admin_password"
                 xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
</div>

<div class="mb-4">
    <label class="block mb-1 font-medium">
        Confirm Password
    </label>

    <div class="relative">
        <input type="password"
               id="admin_password_confirmation"
               name="admin_password_confirmation"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400"
               {{ isset($admin) ? '' : 'required' }}>

        <button type="button"
                onclick="togglePassword('admin_password_confirmation')"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

            <svg id="eye-icon-admin_password_confirmation"
                 xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);

        input.type =
            input.type === 'password'
                ? 'text'
                : 'password';
    }
</script>
