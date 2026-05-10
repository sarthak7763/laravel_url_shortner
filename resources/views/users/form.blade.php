<div class="mb-3">
    <label>User Name</label>
    <input type="text"
           name="name"
           class="border rounded w-full p-2"
           value="{{ old('name', $user->name ?? '') }}"
           required>

    @error('name')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email"
           name="email"
           class="border rounded w-full p-2"
           value="{{ old('email', $user->email ?? '') }}"
           required>

    @error('email')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="block mb-1 font-medium">
        Password
    </label>

    <div class="relative">
        <input type="password"
               id="password"
               name="password"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400"
               {{ isset($user) ? '' : 'required' }}>

        <button type="button"
                onclick="togglePassword('password')"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

            <svg id="eye-icon-password"
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
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>

    @if(!isset($user))
        <small class="text-gray-600">Password is required for new user</small>
    @else
        <small class="text-gray-600">Leave blank to keep current password</small>
    @endif

    @error('password')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="block mb-1 font-medium">
        Confirm Password
    </label>

    <div class="relative">
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400"
               {{ isset($user) ? '' : 'required' }}>

        <button type="button"
                onclick="togglePassword('password_confirmation')"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

            <svg id="eye-icon-password_confirmation"
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
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>

    @error('password_confirmation')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>User Role</label>
    <select name="role"
            class="border rounded w-full p-2"
            required>
        <option value="">-- Select Role --</option>
        @foreach($roles as $role)
            <option value="{{ $role }}"
                    {{ old('role', $userRole ?? '') === $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>

    @error('role')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<script>
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById('eye-icon-' + inputId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }
</script>
