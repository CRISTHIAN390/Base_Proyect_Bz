@extends('layouts.plantilla')

@section('titulo', 'Perfil de Usuario')

@section('contenido')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Sección de actualización de información del perfil -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actualizar Información del Perfil') }}</h2>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Sección de actualización de contraseña -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actualizar Contraseña') }}</h2>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
           
        </div>
    </div>
@endsection
 <!--Para eliminar el usuario
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" >
                    <div class="max-w-xl">
                        include('profile.partials.delete-user-form')
                    </div>
                </div>
                -->