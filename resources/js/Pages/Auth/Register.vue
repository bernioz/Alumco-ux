<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

// 1. Agregamos los nuevos campos al estado inicial del formulario
const form = useForm({
    name: '',
    email: '',
    sede: '',              // Nuevo campo
    sexo: '',              // Nuevo campo
    fecha_nacimiento: '',  // Nuevo campo
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Crear Cuenta - Alumco+" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 transition-colors duration-300">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <img src="/images/logo_alumco.png" alt="Logo Alumco+" class="mx-auto h-24 w-auto object-contain block dark:hidden" />
            <img src="/images/logo_alumco_oscuro.png" alt="Logo Alumco+" class="mx-auto h-24 w-auto object-contain hidden dark:block" />
            <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Crea tu cuenta
            </h2>
            <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
                Completa tus datos para registrarte en la plataforma
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-slate-800 py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-200 dark:border-slate-700 transition-colors duration-300">
                
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Nombre Completo
                        </label>
                        <div class="mt-1">
                            <input id="name" type="text" v-model="form.name" required autofocus autocomplete="name"
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.name}" />
                        </div>
                        <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Correo Electrónico
                        </label>
                        <div class="mt-1">
                            <input id="email" type="email" v-model="form.email" required autocomplete="username"
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.email}" />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="sede" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Sede
                        </label>
                        <div class="mt-1">
                            <select id="sede" v-model="form.sede" required
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.sede}">
                                <option value="" disabled>Selecciona tu sede</option>
                                <option value="Santiago">Santiago</option>
                                <option value="Concepcion">Concepcion</option>
                            </select>
                        </div>
                        <p v-if="form.errors.sede" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.sede }}</p>
                    </div>

                    <div>
                        <label for="sexo" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Sexo
                        </label>
                        <div class="mt-1">
                            <select id="sexo" v-model="form.sexo" required
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.sexo}">
                                <option value="" disabled>Selecciona tu sexo</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <p v-if="form.errors.sexo" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.sexo }}</p>
                    </div>

                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Fecha de Nacimiento
                        </label>
                        <div class="mt-1">
                            <input id="fecha_nacimiento" type="date" v-model="form.fecha_nacimiento" required
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors [&::-webkit-calendar-picker-indicator]:dark:invert"
                                :class="{'border-red-500': form.errors.fecha_nacimiento}" />
                        </div>
                        <p v-if="form.errors.fecha_nacimiento" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.fecha_nacimiento }}</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Contraseña
                        </label>
                        <div class="mt-1">
                            <input id="password" type="password" v-model="form.password" required autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.password}" />
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Confirmar Contraseña
                        </label>
                        <div class="mt-1">
                            <input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.password_confirmation}" />

                        </div>
                        <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <div class="pt-6">
                        <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 disabled:opacity-50 transition-all duration-200 dark:focus:ring-offset-slate-800">
                            Registrarse
                        </button>
                    </div>
                </form>

                <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        ¿Ya tienes una cuenta?
                        <Link :href="route('login')" class="font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors ml-1">
                            Inicia sesión aquí
                        </Link>
                    </p>
                </div>

            </div>
        </div>
    </div>
</template>