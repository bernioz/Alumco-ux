<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; 

const registros = ref([]);
const filtroActivo = ref('Todos');

const mostrarModal = ref(false);
const formulario = ref({
    descripcion: '',
    trabajadoras: '',
    fecha: '',
    monto: '',
    tipo: 'Gasto'
});

const registrosFiltrados = computed(() => {
    if (filtroActivo.value === 'Todos') return registros.value;
    return registros.value.filter(r => r.tipo === filtroActivo.value);
});


const totalInvertido = computed(() => {
    return registros.value
        .filter(r => r.tipo === 'Gasto')
        .reduce((acc, curr) => acc + Math.abs(curr.monto), 0);
});

const ahorroEstimado = computed(() => {
    return registros.value
        .filter(r => r.tipo === 'Ahorro')
        .reduce((acc, curr) => acc + Math.abs(curr.monto), 0);
});


const formatoMoneda = (valor) => {
    const absValor = Math.abs(valor);
    const formateado = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0 }).format(absValor);
    return valor < 0 ? `-${formateado}` : `+${formateado}`;
};


const guardarRegistro = () => {

    const montoFinal = formulario.value.tipo === 'Gasto' ? -Math.abs(formulario.value.monto) : Math.abs(formulario.value.monto);
    
    registros.value.push({
        id: Date.now(), // ID temporal
        descripcion: formulario.value.descripcion,
        trabajadoras: formulario.value.trabajadoras,
        fecha: formulario.value.fecha,
        monto: montoFinal,
        tipo: formulario.value.tipo
    });


    formulario.value = { descripcion: '', trabajadoras: '', fecha: '', monto: '', tipo: 'Gasto' };
    mostrarModal.value = false;
};

const eliminarRegistro = (id) => {
    registros.value = registros.value.filter(r => r.id !== id);
};
</script>

<template>
    <Head title="Control de Costos - Alumco+" />

    <AuthenticatedLayout>
        
        
        <div class="py-8 px-4 sm:px-6 lg:px-8 font-sans text-slate-800 dark:text-slate-100 transition-colors duration-300">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Control de Costos</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Registro y seguimiento de gastos e inversiones en capacitación</p>
            </div>

            <!-- Tarjetas de Resumen Dinámicas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm transition-colors duration-300">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-2 flex items-center gap-2">
                        <span class="text-blue-500">$</span> Total invertido
                    </div>
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ formatoMoneda(totalInvertido) }}</div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm transition-colors duration-300">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-2 flex items-center gap-2">
                        <span class="text-green-500"></span> Ahorro estimado
                    </div>
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ formatoMoneda(ahorroEstimado) }}</div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm transition-colors duration-300">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-2 flex items-center gap-2">
                        <span class="text-slate-400">Registros totales</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800 dark:text-white">{{ registros.length }}</div>
                </div>
            </div>

       
            <div class="flex justify-between items-center mb-4">
                <div class="flex bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-1 shadow-sm transition-colors duration-300">
                    <button @click="filtroActivo = 'Todos'" :class="filtroActivo === 'Todos' ? 'bg-slate-800 dark:bg-slate-700 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700'" class="px-4 py-1.5 rounded-md text-sm font-medium transition">
                        Todos
                    </button>
                    <button @click="filtroActivo = 'Gasto'" :class="filtroActivo === 'Gasto' ? 'bg-slate-800 dark:bg-slate-700 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700'" class="px-4 py-1.5 rounded-md text-sm font-medium transition">
                        Gastos
                    </button>
                    <button @click="filtroActivo = 'Ahorro'" :class="filtroActivo === 'Ahorro' ? 'bg-slate-800 dark:bg-slate-700 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700'" class="px-4 py-1.5 rounded-md text-sm font-medium transition">
                        Ahorros
                    </button>
                </div>

                <button @click="mostrarModal = true" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition flex items-center gap-2">
                    + Nuevo gasto / ahorro
                </button>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm transition-colors duration-300">
                
                <div v-if="registros.length === 0" class="p-8 text-center text-slate-500 dark:text-slate-400">
                    Aún no hay registros. Presiona el botón azul para agregar un nuevo dato.
                </div>
                
                <table v-else class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-50/50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm">
                            <th class="p-4 font-semibold">Descripción</th>
                            <th class="p-4 font-semibold">Trabajadoras</th>
                            <th class="p-4 font-semibold">Fecha</th>
                            <th class="p-4 font-semibold">Monto</th>
                            <th class="p-4 font-semibold">Tipo</th>
                            <th class="p-4 font-semibold w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(registro, index) in registrosFiltrados" :key="registro.id" 
                            class="border-b border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition"
                            :class="{'bg-slate-50/30 dark:bg-slate-800/50': index % 2 !== 0}">
                            
                            <td class="p-4 text-sm font-medium text-slate-800 dark:text-slate-200">{{ registro.descripcion }}</td>
                            <td class="p-4 text-sm text-slate-600 dark:text-slate-400">{{ registro.trabajadoras }}</td>
                            <td class="p-4 text-sm text-slate-500 dark:text-slate-400">{{ registro.fecha }}</td>
                            
                            <td class="p-4 text-sm font-bold" :class="registro.tipo === 'Gasto' ? 'text-red-500 dark:text-red-400' : 'text-green-600 dark:text-green-400'">
                                {{ formatoMoneda(registro.monto) }}
                            </td>
                            
                            <td class="p-4">
                                <span :class="registro.tipo === 'Gasto' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'" 
                                      class="px-2.5 py-1 rounded-full text-xs font-semibold">
                                    {{ registro.tipo }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-center">
                                <button @click="eliminarRegistro(registro.id)" class="text-red-400 hover:text-red-600 dark:hover:text-red-300 transition" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="mostrarModal" class="fixed inset-0 bg-black/50 dark:bg-black/70 flex justify-center items-center z-50 p-4">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl max-w-md w-full p-6 border border-slate-200 dark:border-slate-700 transition-colors duration-300">
                <h2 class="text-xl font-bold mb-4 text-slate-900 dark:text-white">Agregar Nuevo Registro</h2>
                
                <form @submit.prevent="guardarRegistro" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Descripción</label>
                        <input type="text" v-model="formulario.descripcion" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Trabajadoras (Cant.)</label>
                            <input type="number" v-model="formulario.trabajadoras" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Fecha</label>
                            <input type="date" v-model="formulario.fecha" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 [&::-webkit-calendar-picker-indicator]:dark:invert">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Monto ($)</label>
                            <input type="number" v-model="formulario.monto" min="0" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tipo</label>
                            <select v-model="formulario.tipo" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Gasto">Gasto</option>
                                <option value="Ahorro">Ahorro</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <button type="button" @click="mostrarModal = false" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 rounded-lg transition shadow-sm">
                            Guardar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>