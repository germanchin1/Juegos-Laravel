<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    game: Object
});

const form = useForm({
    title: props.game.title,
    description: props.game.description || '',
    status: props.game.status,
    path: props.game.path,
});

const submit = () => {
    form.patch(route('admin.games.update', props.game.id));
};
</script>

<template>
    <Head title="Editar Juego" />

    <AuthenticatedLayout>
        <template #header>
            <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Editar Juego: {{ game.title }}
            </h2>
        </template>

        <div className="py-12">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div className="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit" className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium">Título</label>
                                <input
                                    type="text"
                                    v-model="form.title"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <div v-if="form.errors.title" className="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
                            </div>

                            <div>
                                <label className="block text-sm font-medium">Descripción</label>
                                <textarea
                                    v-model="form.description"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <div v-if="form.errors.description" className="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                            </div>

                            <div>
                                <label className="block text-sm font-medium">Estado</label>
                                <select
                                    v-model="form.status"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                >
                                    <option value="draft">Borrador</option>
                                    <option value="published">Publicado</option>
                                    <option value="private">Privado</option>
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-medium">Ruta del Juego (URL o Carpeta)</label>
                                <input
                                    type="text"
                                    v-model="form.path"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <div v-if="form.errors.path" className="text-red-500 text-xs mt-1">{{ form.errors.path }}</div>
                            </div>

                            <div className="flex items-center gap-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:opacity-50"
                                >
                                    Actualizar Juego
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
