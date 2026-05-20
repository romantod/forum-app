<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

defineProps({
    post: Object,
});


</script>

<template>
    <Head title="Создание поста" />

    <Form
        :action="'/posts/' + post.id"
        method="put"
        v-slot="{ errors, processing }"
        class="max-w-md"
    >
        <div>
            <label>Заголовок</label>
            <input type="text" name="title" 
            class="w-full p-2 bg-gray-700 text-white rounded" :value="post.title"/>
            <InputError :message="errors.title" />            
        </div>

        <div>
            <label>Содержание</label>
            <textarea name="body" :value="post.body" rows="8"
                class="w-full p-2 bg-gray-700 text-white rounded"></textarea>
            <InputError :message="errors.body" />
        </div>        
        
        <button 
            type="submit" 
            :disabled="processing"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
            Сохранить
        </button>
    </Form> 

  
</template>