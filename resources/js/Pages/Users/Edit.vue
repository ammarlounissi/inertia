<script setup>
import { useForm } from '@inertiajs/vue3';

let props = defineProps({
    user: Object
});

let form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: ''
});

let submit = () => {
    form.put(`/users/${props.user.id}`, {
        onSuccess: () => {
            // Handle success
        }
    });
};
</script>

<template>

    <Head title="Edit User" />

    <h1 class="text-3xl">Edit User</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name"> Name </label>

            <input v-model="form.name" class="border border-gray-400 p-2 w-full" type="text" name="name" id="name"
                required />

            <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email"> Email </label>

            <input v-model="form.email" class="border border-gray-400 p-2 w-full" type="email" name="email" id="email"
                required />

            <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password"> Password (leave blank to keep current) </label>

            <input v-model="form.password" class="border border-gray-400 p-2 w-full" type="password" name="password"
                id="password" />

            <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
            <button :disabled="form.processing" type="submit"
                class="bg-blue-400 text-white rounded py-2 px-4 cursor-pointer hover:bg-blue-500 disabled:opacity-70 disabled:cursor-not-allowed">Update</button>
        </div>
    </form>
</template>