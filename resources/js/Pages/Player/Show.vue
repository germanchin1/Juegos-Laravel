<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    game: Object
});
</script>

<template>
    <Head :title="game.title" />

    <AuthenticatedLayout>
        <template #header>
            <div className="flex justify-between items-center">
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ game.title }}
                </h2>
                <Link
                    :href="route('player.games.index')"
                    className="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                >
                    &larr; Volver al catálogo
                </Link>
            </div>
        </template>

        <div className="py-6">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 h-[80vh]">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 h-full flex flex-col">
                    <div className="flex-grow">
                         <iframe
                            :src="game.path"
                            className="w-full h-full border-0"
                            :title="game.title"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <div className="p-4 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600">
                         <p className="text-sm text-gray-600 dark:text-gray-300">{{ game.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
