<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3';
import { MoveLeft } from '@lucide/vue';


const props = defineProps({ category: Object });
const form = useForm({ name: props.category.name, description: props.category.description ?? '' });
const submit = () => form.put('/admin/categories/' + props.category.id, {
    onSuccess: () => form.reset(),
});

</script>

<template>
     <Head title="Редактировать категорию" />

     <div class="max-w-3xl p-6">

        <div class="mb-6">
            <Link :href="'/admin/categories'" class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded">
                <MoveLeft class="w-5 h-5 inline-block" />&nbsp;&nbsp;&nbsp;Назад
            </Link>   
        </div>        
            
        <div class="max-w-3xl mx-auto p-6 space-y-4">

            <h1 class="text-xl font-bold text-white mb-6">Редактировать категорию:&nbsp;
            <span class="text-2xl font-bold text-blue-400">{{ category.name }}</span></h1>

            <input v-model="form.name" type="text" class="w-64 p-2 rounded bg-gray-700 text-white placeholder-gray-400"/>

            <textarea v-model="form.description" rows="10" class="w-full p-2 rounded bg-gray-700 text-white 
                placeholder-gray-400 border border-gray-600"></textarea>

            <p v-if="form.errors.name" class="text-red-400 text-sm">{{ form.errors.name }}</p>
            <p v-if="form.errors.description" class="text-red-400 text-sm">{{ form.errors.description }}</p>

            <button @click="submit" :disabled="form.processing" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">
                Сохранить
            </button>

        </div>        
    </div>
    
</template>