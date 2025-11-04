<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    show: Boolean,
});

const emit = defineEmits(['close']);

const form = useForm({
    profile_picture: null,
});

const fileInput = ref(null);

const submit = () => {
    form.post(`/users/${props.user.id}/profile-picture`, {
        forceFormData: true,
        onSuccess: () => {
            emit('close');
            form.reset();
            router.reload();
        },
        onError: () => {
            // Handle error
        },
    });
};

const handleFileChange = (event) => {
    form.profile_picture = event.target.files[0];
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold mb-4 text-center">تحديث صورة البروفيل</h3>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        اختر صورة جديدة
                    </label>
                    <input
                        ref="fileInput"
                        type="file"
                        accept="image/*"
                        @change="handleFileChange"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        @click="emit('close')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200"
                    >
                        إلغاء
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'جاري التحميل...' : 'تحديث' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>