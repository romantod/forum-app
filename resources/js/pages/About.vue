<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Form } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';

defineProps({
    title: String,
    description: String,
});

const page = usePage();
const user = page.props.auth.user;

</script>

<template>
    <Head :title="title" />

    <h2>{{ title }}</h2>
    <p>{{ description }}</p>

    <p v-if="user">Привет, {{ user.name }}</p>
    
    <Form
        action="/feedback"
        method="post"
        v-slot="{ errors, processing }"
        class="max-w-md"
        @success="toast.success('Сообщение отправлено!')"
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