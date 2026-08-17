<template>
    <button
        @click="leerTexto"
        type="button"
        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        aria-label="Leer pregunta en voz alta"
    >
        <!-- Icono de altavoz (SVG simple) -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
        </svg>
        Escuchar
    </button>
</template>

<script setup>
const props = defineProps({
    texto: {
        type: String,
        required: true
    }
});

const leerTexto = () => {
    // Verificar si el navegador de la usuaria soporta la API
    if ('speechSynthesis' in window) {
        // Cancelar cualquier lectura previa para que los audios no se superpongan
        window.speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(props.texto);
        
        // Configurar el idioma al español de Chile
        utterance.lang = 'es-CL';
        
        // Ajustar velocidad (rate). 0.9 es un poco más pausado para mejorar la comprensión
        utterance.rate = 0.9; 
        utterance.pitch = 1.0;

        window.speechSynthesis.speak(utterance);
    } else {
        alert("Lamentablemente, tu navegador no soporta la lectura por voz.");
    }
};
</script>