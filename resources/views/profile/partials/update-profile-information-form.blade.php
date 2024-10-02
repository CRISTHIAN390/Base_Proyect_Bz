<section>
    <!-- Formulario para enviar verificación de correo -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulario para actualizar el perfil -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Campo de nombre -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nombre:')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        
        <!-- Campo de rol -->
        <div class="mb-4">
            <x-input-label for="rol" :value="__('Rol:')" />
            <x-text-input id="rol" name="rol" type="text" class="mt-1 block w-full" :value="old('rol', $user->rol->name ?? 'Sin rol')"
                readonly /> <!-- Campo de solo lectura -->
            <x-input-error class="mt-2" :messages="$errors->get('rol')" />
        </div>
        <!-- Campo de correo electrónico -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Correo:')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4">
                    <p class="text-sm text-gray-800">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nuevo enlace de verificación ha sido enviado a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <!-- Botón de guardar y mensaje de éxito -->
        <div class="flex items-center gap-4 mt-6">
            <button class="bg-green-600 hover:bg-green-0 text-black font-semibold py-2 px-4 rounded-md">
                {{ __('Guardar') }}
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
