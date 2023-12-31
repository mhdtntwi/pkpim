<x-guest-layout>
    </style>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Cipta Akaun Baharu
            </h1>
            <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Nama Penuh')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="email" :value="__('E-mel')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                        <x-input-label for="ic" :value="__('No. Kad Pengenalan')" />
                        <x-text-input id="ic" class="block mt-1 w-full" type="text" name="ic" :value="old('ic')" required autofocus autocomplete="ic" />
                        <p id="helper-text-explanation" class="mt-2 text-sm text-red-500 dark:text-gray-400">Tanpa menggunakan (-).</p>
                    <x-input-error :messages="$errors->get('ic')" class="mt-2" />
                </div>
                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jantina</label>
                    <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="">--Pilih Jantina--</option>    
                        <option value="male">Lelaki</option>
                        <option value="female">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Negeri</label>
                    <select id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="">--Pilih Negeri--</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Kata Laluan')" />

                    <div class="relative">
                        <x-text-input id="password" class="block mt-1 w-full pr-10"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <span id="hidePassword" class="text-gray-500 cursor-pointer hover:text-gray-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-3 6a6 6 0 100-12 6 6 0 000 12z" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Daftar') }}
                    </x-primary-button>
                </div>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Anda mempunyai akaun? <a href="{{ route('welcome.index') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Log Masuk</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const hidePassword = document.querySelector('#hidePassword');
        const password = document.querySelector('#password');

        hidePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('text-gray-500');
            this.classList.toggle('text-gray-700');
        });
    </script>
</x-guest-layout>
