<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    games: Array
});

const form = useForm({});

const deleteGame = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este juego?')) {
        form.delete(route('admin.games.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Juegos" />

    <AuthenticatedLayout>
        <template #header>
            <div className="flex justify-between items-center">
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Gestión de Juegos
                </h2>
                <Link
                    :href="route('admin.games.create')"
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                >
                    Añadir Juego
                </Link>
            </div>
        </template>

        <div className="py-12">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div className="p-6 text-gray-900 dark:text-gray-100">
                        <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Título</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estado</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="game in games" :key="game.id">
                                    <td className="px-6 py-4 whitespace-nowrap">{{ game.title }}</td>
                                    <td className="px-6 py-4 whitespace-nowrap">
                                        <span :className="`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${game.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}`">
                                            {{ game.status }}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 whitespace-nowrap space-x-2">
                                        <Link :href="route('admin.games.edit', game.id)" className="text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        <button @click="deleteGame(game.id)" className="text-red-600 hover:text-red-900">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
