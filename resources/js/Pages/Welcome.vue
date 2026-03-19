<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Bienvenido a Juegos Laravel" />
    <div class="min-h-screen bg-gray-900 text-white font-sans selection:bg-indigo-500">
        <!-- Navigation -->
        <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center font-bold text-xl">JL</div>
                <span class="text-xl font-bold tracking-tight">Juegos Laravel</span>
            </div>

            <div v-if="canLogin" class="flex gap-4">
                <template v-if="$page.props.auth.user">
                    <Link
                        :href="route('dashboard')"
                        class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-md transition"
                    >
                        Dashboard
                    </Link>

                    <Link
                        v-if="$page.props.auth.user.roles.some(r => r.slug === 'administrador') || $page.props.auth.user.roles.some(r => r.slug === 'gestor')"
                        :href="route($page.props.auth.user.roles.some(r => r.slug === 'administrador') ? 'admin.games.index' : 'manager.games.index')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-md transition"
                    >
                        Gestionar Juegos
                    </Link>

                    <Link
                        v-else
                        :href="route('player.games.index')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-md transition"
                    >
                        Ver Catálogo
                    </Link>
                </template>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="px-4 py-2 hover:text-indigo-400 transition"
                    >
                        Entrar
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-md transition"
                    >
                        Registrarse
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-6 py-20 lg:py-32 flex flex-col items-center text-center">
            <h1 class="text-5xl lg:text-7xl font-extrabold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                Tu plataforma de juegos favorita
            </h1>
            <p class="text-xl text-gray-400 mb-10 max-w-2xl leading-relaxed">
                Disfruta de una colección de juegos clásicos y modernos, gestionados con la potencia de Laravel y la agilidad de Vue/Inertia.
            </p>

            <div class="flex gap-6">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('player.games.index')"
                    class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-bold text-lg shadow-lg shadow-indigo-500/20 transition-all hover:scale-105"
                >
                    Ir al Catálogo de Juegos
                </Link>
                <Link
                    v-else
                    :href="route('register')"
                    class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-bold text-lg shadow-lg shadow-indigo-500/20 transition-all hover:scale-105"
                >
                    Comienza a Jugar Gratis
                </Link>
                <a
                    href="#features"
                    class="px-8 py-4 bg-gray-800 hover:bg-gray-700 rounded-xl font-bold text-lg transition-all"
                >
                    Saber más
                </a>
            </div>

            <!-- Preview/Visual -->
            <div class="mt-20 relative w-full max-w-4xl">
                 <div class="absolute inset-0 bg-indigo-500 opacity-20 blur-3xl rounded-full"></div>
                 <div class="relative bg-gray-800 border-4 border-gray-700 rounded-2xl overflow-hidden shadow-2xl aspect-video flex items-center justify-center">
                    <div class="text-center p-10">
                        <div class="w-20 h-20 bg-indigo-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Ping Pong Challenge disponible</h3>
                        <p class="text-gray-400">Prueba nuestro nuevo juego desarrollado con Phaser 3</p>
                    </div>
                 </div>
            </div>
        </main>

        <section id="features" class="py-20 bg-gray-800/50">
             <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">
                 <div class="p-8 bg-gray-900 rounded-2xl border border-gray-800">
                     <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center mb-6 text-indigo-400">🚀</div>
                     <h4 class="text-xl font-bold mb-4">Velocidad Increíble</h4>
                     <p class="text-gray-400">Gracias a Inertia.js y Vue 3, la navegación es instantánea y sin recargas de página.</p>
                 </div>
                 <div class="p-8 bg-gray-900 rounded-2xl border border-gray-800">
                     <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center mb-6 text-purple-400">🎮</div>
                     <h4 class="text-xl font-bold mb-4">Motor Phaser 3</h4>
                     <p class="text-gray-400">Integramos juegos de alto rendimiento desarrollados con el motor de juegos web líder.</p>
                 </div>
                 <div class="p-8 bg-gray-900 rounded-2xl border border-gray-800">
                     <div class="w-12 h-12 bg-green-500/10 rounded-lg flex items-center justify-center mb-6 text-green-400">🛡️</div>
                     <h4 class="text-xl font-bold mb-4">Seguro y Robusto</h4>
                     <p class="text-gray-400">Toda la potencia de Laravel protegiendo tus datos y gestionando tus roles de usuario.</p>
                 </div>
             </div>
        </section>

        <footer class="p-10 text-center text-gray-500 border-t border-gray-800">
            <p>© 2026 Juegos Laravel - Desarrollado con 💜 por Antigravity</p>
        </footer>
    </div>
</template>
