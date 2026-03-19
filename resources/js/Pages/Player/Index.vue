<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    games: Array
});
</script>

<template>
    <Head title="Juegos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Catálogo de Juegos
            </h2>
        </template>

        <div className="py-12">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template v-if="games.length > 0">
                        <div v-for="game in games" :key="game.id" className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 flex flex-col">
                            <div className="p-6 text-gray-900 dark:text-gray-100 flex-grow">
                                <h3 className="text-lg font-bold mb-2">{{ game.title }}</h3>
                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ game.description }}</p>
                            </div>
                            <div className="p-6 pt-0">
                                <Link
                                    :href="route('player.games.show', game.id)"
                                    className="inline-block w-full text-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                                >
                                    Jugar Ahora
                                </Link>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div className="col-span-full text-center p-12 bg-white dark:bg-gray-800 rounded-lg">
                            <p className="text-gray-500">No hay juegos disponibles por el momento.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
