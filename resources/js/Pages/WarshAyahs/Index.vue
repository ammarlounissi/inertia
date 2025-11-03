<template>

    <Head>
        <title>Warsh Ayahs</title>
        <meta type="description" content="Warsh Quran Ayahs" head-key="description">
    </Head>

    <div class="mb-6">
        <h1 class="text-3xl mb-4">Warsh Quran Ayahs</h1>

        <div class="flex flex-wrap gap-4 mb-4">
            <input type="text" placeholder="Search in text or sura name" class="border px-3 py-2 rounded-lg flex-1 min-w-64" v-model="search">

            <select v-model="suraNo" class="border px-3 py-2 rounded-lg">
                <option value="">All Suras</option>
                <option v-for="n in 114" :key="n" :value="n">{{ n }}</option>
            </select>

            <select v-model="jozz" class="border px-3 py-2 rounded-lg">
                <option value="">All Juz</option>
                <option v-for="n in 30" :key="n" :value="n">{{ n }}</option>
            </select>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sura</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ayah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juz</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Text</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="ayah in warshAyahs.data" :key="ayah.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ ayah.sura_name_ar }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ ayah.sura_name_en }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ayah.aya_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ayah.jozz }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ayah.page }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 max-w-md">
                                    <div class="font-uthmanic-warsh text-right leading-relaxed" dir="rtl">
                                        {{ ayah.aya_text }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <Pagination :links="warshAyahs.links" class="mt-6" />

</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';

import Pagination from '../../Shared/Pagination.vue';
import { ref, watch } from 'vue';

import debounce from 'lodash/debounce';

let props = defineProps({
    warshAyahs: Object,
    filters: Object
});

let search = ref(props.filters.search);
let suraNo = ref(props.filters.sura_no);
let jozz = ref(props.filters.jozz);

watch(search, debounce(value => {
    router.get('/warsh-ayahs', {
        search: value,
        sura_no: suraNo.value,
        jozz: jozz.value
    }, {
        preserveState: true,
        replace: true
    });
}, 300));

watch(suraNo, debounce(value => {
    router.get('/warsh-ayahs', {
        search: search.value,
        sura_no: value,
        jozz: jozz.value
    }, {
        preserveState: true,
        replace: true
    });
}, 300));

watch(jozz, debounce(value => {
    router.get('/warsh-ayahs', {
        search: search.value,
        sura_no: suraNo.value,
        jozz: value
    }, {
        preserveState: true,
        replace: true
    });
}, 300));

</script>

<style scoped>
.font-uthmanic-warsh {
    font-family: 'Uthmanic Warsh', serif;
    font-size: 1.25rem;
    line-height: 2;
}
</style>