<section class="space-y-6">
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-700">
            {{ __('Eliminar cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Si quiere eliminar la cuenta, confirme seleccionando el botón.') }}
        </p>
    </header>

    <!-- Botón para abrir el modal -->
    <button
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="mt-4 bg-red-600 text-black font-semibold py-2 px-4 rounded hover:bg-red-700"
    >
        {{ __('Eliminar') }}
    </button>

    <script src="//unpkg.com/alpinejs" defer></script>

    <div x-data="{ open: @entangle('openModal') }">
        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Si quiere eliminar la cuenta coloque su clave') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <!-- Botón Cancelar (gris) -->
                    <button
                        x-on:click="$dispatch('close')"
                        type="button"
                        class="bg-gray-400 text-black font-semibold py-2 px-4 rounded hover:bg-gray-500"
                    >
                        {{ __('Cancelar') }}
                    </button>

                    <!-- Botón Confirmar (verde) -->
                    <button
                        type="submit"
                        class="ml-3 bg-green-600 text-black font-semibold py-2 px-4 rounded hover:bg-green-700"
                    >
                        {{ __('Confirmar') }}
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</section>
