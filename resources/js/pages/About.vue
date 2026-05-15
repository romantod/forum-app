<script setup>
import { Head } from '@inertiajs/vue3';
import { Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const props = defineProps({
    title: String,
    description: String,
    success: String,
});


</script>

<template>
    <Head :title="title" />

    <h2>{{ title }}</h2>
    <p>{{ description }}</p>

    <div v-if="success" class="text-green-600 mb-4">
        {{ success }}
    </div>
    
    <Form
        action="/feedback"
        method="post"
        v-slot="{ errors, processing }"
        class="max-w-md"
    >
        <div>
            <label>Имя</label>
            <input type="text" name="name" 
            class="w-full p-2 bg-gray-700 text-white rounded" />
            <InputError :message="errors.name" />
        </div>

        <div>
            <label>Сообщение</label>
            <textarea name="message"
                class="w-full p-2 bg-gray-700 text-white rounded">
            </textarea>
            <InputError :message="errors.message" />
        </div>        
        
        <button 
            type="submit" 
            :disabled="processing"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
            Отправить
        </button>
    </Form>
</template>