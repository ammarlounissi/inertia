<script setup>
import { Head, Link } from '@inertiajs/vue3';
// تعريف الخصائص (Props) التي يتم تمريرها من الكنترولر
defineProps({
    verses: Object, // يحتوي على بيانات التصفية (data, links, meta)
});

// مكون بسيط لعرض روابط التصفية
const Pagination = ({ links }) => {
    return {
        template: `
            <div class="flex flex-wrap -mb-1">
                <template v-for="(link, key) in links" :key="key">
                    <div v-if="link.url === null"
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                        v-html="link.label" />
                    <Link v-else
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                        :class="{ 'bg-indigo-500 text-white': link.active }"
                        :href="link.url"
                        v-html="link.label" />
                </template>
            </div>
        `,
        components: { Link },
        props: ['links']
    }
};
</script>

<template>
    <Head title="آيات القرآن (ورش)" />

    <Layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6 text-right">عرض آيات القرآن (رواية ورش)</h1>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-8">
                    <div v-for="aya in verses.data" :key="aya.id" class="border-b pb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-indigo-600">
                                سورة: {{ aya.sura_name_ar }} ({{ aya.sura_no }}) - آية: {{ aya.aya_no }}
                            </span>
                            <span class="text-xs text-gray-500">
                                جزء: {{ aya.jozz }} - صفحة: {{ aya.page }}
                            </span>
                        </div>

                        <p class="aya-text text-gray-800">
                            {{ aya.aya_text }}
                        </p>
                    </div>

                    <div class="mt-8">
                        <Pagination :links="verses.links" />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>