<template>
    <Head title="Mi Calendario de Turnos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                    Mi Calendario de Turnos
                </h2>
                <!-- Botón para reportar disponibilidad -->
                <button @click="reportarDisponibilidad" class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition shadow-sm">
                    Reportar no disponibilidad
                </button>
            </div>
        </template>

        <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Leyenda de colores -->
                <div class="mb-6 flex gap-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                    <span class="flex items-center gap-2"><div class="w-3 h-3 bg-blue-500 rounded-full"></div> Turno asignado</span>
                    <span class="flex items-center gap-2"><div class="w-3 h-3 bg-emerald-500 rounded-full"></div> Día libre</span>
                    <span class="flex items-center gap-2"><div class="w-3 h-3 bg-red-500 rounded-full"></div> No disponible</span>
                </div>

                <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
                    <!-- Componente de FullCalendar -->
                    <FullCalendar :options="calendarOptions" />
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Importaciones de FullCalendar
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

const props = defineProps({
    eventos: Array
});

// Configuración del calendario
const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth', // Vista mensual por defecto
    locale: 'es', // Idioma español
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek' // Permite cambiar entre mes y semana
    },
    buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana'
    },
    events: props.eventos, // Le pasamos los datos procesados por Laravel
    eventClick: function(info) {
        // Al hacer clic en un turno, podríamos abrir un modal con más detalles
        alert(`Turno: ${info.event.title}\nNotas: ${info.event.extendedProps.notas || 'Sin notas adicionales'}`);
    }
});

const reportarDisponibilidad = () => {
    // Aquí podrías abrir un modal para que la colaboradora indique cuándo no puede trabajar
    alert("Pronto abriremos un formulario para que informes tus días no disponibles.");
};
</script>

<style>
/* Ajustes para que el calendario se vea bien en tu diseño (y en modo oscuro si lo usas) */
.fc .fc-toolbar-title {
    font-size: 1.25rem !important;
    font-weight: 700;
}
.fc-theme-standard td, .fc-theme-standard th {
    border-color: #e2e8f0; 
}
</style>