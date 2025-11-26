<template>
    <div v-if="links.length > 3" class="flex flex-wrap items-center justify-start mt-8">
        <template v-for="(link, key) in links">
            
            <div v-if="link.url === null" :key="key"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded text-gray-400"
                v-html="link.label"
            />
            
            <div v-else-if="link.active" :key="'active-' + key"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded bg-indigo-600 text-white font-bold cursor-default"
                v-html="link.label"
            />
            
            <Link v-else :key="'link-' + key"
                :href="link.url"
                v-html="link.label"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-indigo-100 focus:text-indigo-500 focus:border-indigo-500 transition-colors duration-150"
            />
        </template>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

// استقبال الـ Props
defineProps({
    // مصفوفة الروابط المرسلة من Laravel Paginator (مع تفعيل withQueryString())
    links: {
        type: Array,
        required: true,
    },
});

// ملاحظة: بما أننا نستخدم مكون Link من Inertia، لا نحتاج لاستخدام router.get() يدوياً، 
// فمكون Link يقوم بهذا الدور تلقائياً، مما يجعل الكود أنظف وأسهل.
</script>