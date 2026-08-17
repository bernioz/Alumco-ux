<template>
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 font-sans text-slate-900 dark:text-slate-100 transition-colors duration-300">
        <nav class="flex justify-between items-center px-8 py-4 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-sm transition-colors duration-300">
            
            <div class="flex items-center gap-8">
                <Link :href="$page.props.auth.user.rol === 'admin' ? route('admin.alumnos.index') : '/dashboard'" class="flex items-center gap-3 no-underline transition-transform hover:scale-105">
                    <img src="/images/logo_alumco.png" alt="Logo Alumco+" class="h-[120px] w-auto object-contain block dark:hidden" />
                    <img src="/images/logo_alumco_oscuro.png" alt="Logo Alumco+" class="h-[120px] w-auto object-contain hidden dark:block" />
                    <span class="font-bold text-blue-800 dark:text-blue-400 text-xl tracking-tight hidden sm:block"></span>
                </Link>
                
                <div class="hidden md:flex items-center gap-6 text-sm font-medium">

                    <template v-if="$page.props.auth.user.rol === 'admin'"> 

                        <Link :href="route('admin.alumnos.index')" :class="route().current('admin.alumnos.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                             Alumnos
                        </Link>

                        <Link :href="route('admin.profesores.index')" :class="route().current('admin.profesores.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Profesores
                        </Link>

                        <Link :href="route('admin.estadisticas')" :class="route().current('admin.estadisticas') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Estadísticas
                        </Link>

                        <Link :href="route('admin.control-costos')" :class="route().current('admin.control-costos') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Control de Costos
                        </Link>
                        
                    </template>

                    <template v-else-if="$page.props.auth.user.rol === 'profesor'">
                        <Link :href="route('profesor.cursos.index')" :class="route().current('profesor.cursos.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Mis Cursos
                        </Link>
                    </template>

                    <template v-else-if="$page.props.auth.user.rol === 'alumno'">
                        <Link :href="route('alumno.explorar')" :class="route().current('alumno.explorar') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Explorar Cursos
                        </Link>
                        
                        <Link :href="route('alumno.dashboard')" :class="route().current('alumno.dashboard') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Mis Cursos
                        </Link>

                        <Link :href="route('mis-logros')" :class="route().current('mis-logros') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition'">
                            Mis Logros
                        </Link>
                    </template>
                    
                </div>
            </div>

            <div class="flex items-center gap-4">
                
                <div class="flex items-center gap-2 border-r border-slate-200 dark:border-slate-600 pr-4">
                    <div class="flex items-center border border-slate-200 dark:border-slate-600 rounded bg-white dark:bg-slate-700 shadow-sm overflow-hidden h-8 text-sm">
                        <button @click="changeFontSize(-1)" class="px-2.5 h-full text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 transition font-medium border-r border-slate-200 dark:border-slate-600 flex items-center justify-center">
                            A-
                        </button>
                        <button @click="changeFontSize(1)" class="px-2.5 h-full text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 transition font-medium flex items-center justify-center">
                            A+
                        </button>
                    </div>

                    <button @click="toggleDarkMode" class="flex items-center justify-center border border-slate-200 dark:border-slate-600 rounded w-8 h-8 bg-white dark:bg-slate-700 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition">
                        <svg v-if="!isDarkMode" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                    </button>
                </div>
                <Link :href="$page.props.auth.user.rol === 'admin' ? route('admin.perfil') : route('profile.edit')" class="flex items-center gap-2 border border-slate-200 dark:border-slate-700 py-1.5 px-3 rounded-lg bg-white dark:bg-slate-800 shadow-sm cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700 transition no-underline text-slate-700 dark:text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-sm font-medium">{{ $page.props.auth.user.name }}</span>
                    <span class="ml-1 text-[10px] uppercase bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold px-1.5 py-0.5 rounded">
                        {{ $page.props.auth.user.rol }}
                    </span>
                </Link>

                <Link :href="route('logout')" method="post" as="button" class="text-sm text-red-500 dark:text-red-400 font-medium hover:text-red-700 dark:hover:text-red-300 transition">
                    Cerrar Sesión
                </Link>
            </div>

        </nav>

        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Estado y Lógica del Modo Oscuro
const isDarkMode = ref(false);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

// Estado y Lógica del Tamaño de Letra
const changeFontSize = (step) => {
    // Obtenemos el tamaño base actual del html (por defecto suele ser 16px)
    let currentSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
    
    // Incrementamos o reducimos 2px por cada clic
    let newSize = currentSize + (step * 2); 
    
    // Establecemos límites lógicos (entre 12px y 24px) para no romper el layout
    if (newSize >= 12 && newSize <= 24) {
        document.documentElement.style.fontSize = `${newSize}px`;
        localStorage.setItem('fontSize', newSize);
    }
};

// Cargar preferencias guardadas al montar el componente
onMounted(() => {
    // Revisar preferencia de modo oscuro
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // Revisar preferencia de tamaño de letra
    const savedFontSize = localStorage.getItem('fontSize');
    if (savedFontSize) {
        document.documentElement.style.fontSize = `${savedFontSize}px`;
    }
});
</script>