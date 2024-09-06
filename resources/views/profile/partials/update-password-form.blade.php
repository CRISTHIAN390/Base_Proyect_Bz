<section class="max-w-md mx-auto p-6 bg-white rounded-md shadow-md">
    <header class="mb-4">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Actualizar Clave') }}
        </h2>
        <p class="text-sm text-gray-600">
            {{ __('Datos:') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Contraseña actual -->
        <div class="mb-4">
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual:')" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- Nueva Contraseña -->
        <div class="mb-4">
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirma Contraseña:')" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botón Guardar y mensaje de confirmación -->
        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-black font-semibold py-2 px-4 rounded-md">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>
