<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Iniciar Sesión - Alumco+" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 transition-colors duration-300">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <img src="/images/logo_alumco.png" alt="Logo Alumco+" class="mx-auto h-24 w-auto object-contain block dark:hidden" />
            <img src="/images/logo_alumco_oscuro.png" alt="Logo Alumco+" class="mx-auto h-24 w-auto object-contain hidden dark:block" />
            <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Acceso a la plataforma
            </h2>
            <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
                Ingresa tus credenciales para continuar
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-slate-800 py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-200 dark:border-slate-700 transition-colors duration-300">
                
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Correo Electrónico
                        </label>
                        <div class="mt-1">
                            <input id="email" type="email" v-model="form.email" required autofocus autocomplete="username"
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.email}" />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Contraseña
                        </label>
                        <div class="mt-1">
                            <input id="password" type="password" v-model="form.password" required autocomplete="current-password"
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm dark:bg-slate-900 dark:text-white transition-colors"
                                :class="{'border-red-500': form.errors.password}" />
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" v-model="form.remember"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-600 border-slate-300 rounded dark:bg-slate-900 dark:border-slate-600 transition-colors" />
                            <label for="remember_me" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">
                                Mantener sesión iniciada
                            </label>
                        </div>

                        <div class="text-sm">
                            <Link v-if="route().has('password.request')" :href="route('password.request')" class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                ¿Olvidaste tu contraseña?
                            </Link>
                        </div>
                    </div>

                    <div>
                        <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 disabled:opacity-50 transition-all duration-200 dark:focus:ring-offset-slate-800">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        ¿Aún no tienes una cuenta?
                        <Link v-if="route().has('register')" :href="route('register')" class="font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors ml-1">
                            Regístrate aquí
                        </Link>
                    </p>
                </div>

            </div> 
        </div> 
    </div>
</template>