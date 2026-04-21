<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const video = ref(null);
const canvas = ref(null);
const result = ref(null);
const loading = ref(false);
const stream = ref(null);
const isActive = ref(false);
const error = ref(null);
let intervalId = null;

const startCamera = async () => {
    try {
        stream.value = await navigator.mediaDevices.getUserMedia({ video: true });
        if (video.value) {
            video.value.srcObject = stream.value;
            isActive.value = true;
            error.value = null;
            // Iniciar análisis automático cada 5 segundos
            intervalId = setInterval(analyzeMood, 5000);
        }
    } catch (err) {
        console.error("Error al acceder a la cámara:", err);
        error.value = "Permiso de cámara denegado o no disponible.";
    }
};

const stopCamera = () => {
    if (stream.value) {
        stream.value.getTracks().forEach(track => track.stop());
        isActive.value = false;
        stream.value = null;
    }
    if (intervalId) {
        clearInterval(intervalId);
        intervalId = null;
    }
};

const analyzeMood = async () => {
    if (!video.value || !canvas.value || !isActive.value || loading.value) return;

    loading.value = true;
    const context = canvas.value.getContext('2d');
    
    canvas.value.width = video.value.videoWidth;
    canvas.value.height = video.value.videoHeight;
    context.drawImage(video.value, 0, 0, canvas.value.width, canvas.value.height);

    canvas.value.toBlob(async (blob) => {
        if (!blob) return;
        const formData = new FormData();
        formData.append('img', blob, 'mood.jpg');

        try {
            const response = await axios.post('http://localhost:5000/analyze', formData);
            if (response.data.dominant_emotion) {
                result.value = response.data.dominant_emotion;
            }
        } catch (err) {
            console.error("Error en el análisis:", err);
        } finally {
            loading.value = false;
        }
    }, 'image/jpeg');
};

onMounted(() => {
    // Pequeño delay para asegurar que el DOM esté listo
    setTimeout(startCamera, 1000);
});

onUnmounted(() => {
    stopCamera();
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
            <h3 class="font-bold flex items-center gap-2">
                <span class="animate-pulse">🔴</span> Live Mood Tracking
            </h3>
        </div>

        <div class="p-6">
            <div class="relative group">
                <!-- Video Mini Preview -->
                <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-gray-900 shadow-inner mb-4 ring-2 ring-indigo-500/20">
                    <video 
                        ref="video" 
                        autoplay 
                        playsinline 
                        class="w-full h-full object-cover mirror scale-110"
                        v-show="isActive"
                    ></video>
                    
                    <!-- Overlay de carga/escaneo -->
                    <div v-if="loading" class="absolute inset-0 flex items-center justify-center bg-indigo-500/10 backdrop-blur-[1px]">
                        <div class="w-full h-0.5 bg-indigo-400 absolute animate-scan-fast shadow-[0_0_15px_rgba(129,140,248,0.8)]"></div>
                    </div>

                    <!-- Estado No Activo -->
                    <div v-if="!isActive" class="absolute inset-0 flex items-center justify-center text-center p-4">
                        <p class="text-gray-500 text-xs font-medium">{{ error || 'Iniciando cámara...' }}</p>
                    </div>
                </div>

                <!-- HUD Emoción -->
                <div v-if="result" class="absolute -top-2 -right-2 bg-white dark:bg-gray-900 rounded-full p-2 shadow-lg border-2 border-indigo-500 animate-bounce-slow">
                    <span class="text-3xl">
                        {{ result === 'happy' ? '😊' : (result === 'sad' ? '😢' : '😐') }}
                    </span>
                </div>
            </div>

            <!-- Panel de Estado -->
            <div class="space-y-3">
                <div class="flex items-center justify-between px-2">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-tighter">Estado Atual:</span>
                    <span class="text-xs font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest animate-pulse">
                        {{ loading ? 'Sincronizando...' : 'Conectado' }}
                    </span>
                </div>

                <div v-if="result" class="p-3 rounded-xl transition-all duration-500" :class="{
                    'bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800': result === 'happy',
                    'bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800': result === 'sad',
                    'bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600': !['happy', 'sad'].includes(result)
                }">
                    <div class="flex items-center gap-3">
                        <div class="flex-grow">
                            <p class="text-[10px] uppercase font-bold text-gray-400 leading-none mb-1">Detección IA</p>
                            <p class="text-sm font-black dark:text-white capitalize">
                                {{ result === 'happy' ? 'Muy Contento' : (result === 'sad' ? 'Algo Triste' : result) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <canvas ref="canvas" class="hidden"></canvas>
            
            <p class="mt-4 text-[10px] text-center text-gray-400 italic">
                El sistema analiza tu expresión cada 5 segundos para adaptar la experiencia.
            </p>
        </div>
    </div>
</template>

<style scoped>
.mirror {
    transform: scaleX(-1);
}

.animate-scan-fast {
    animation: scan 1.5s ease-in-out infinite;
}

@keyframes scan {
    0% { top: 0; opacity: 0; }
    50% { opacity: 1; }
    100% { top: 100%; opacity: 0; }
}

@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.animate-bounce-slow {
    animation: bounce-slow 3s ease-in-out infinite;
}
</style>
