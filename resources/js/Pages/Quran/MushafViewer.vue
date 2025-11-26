<template>
    <Head title="تصفح المصحف الشريف" />
    <AppLayout>
        <div class="py-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <section class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">بحث وتصفية الآيات</h2>
                    <form @submit.prevent="applyFilters" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">نص الآية</label>
                            <input v-model="form.search_term" type="text" id="search" placeholder="اكتب كلمة أو جزء من آية..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="surah" class="block text-sm font-medium text-gray-700">اختر السورة</label>
                            <select v-model="form.surah_id" id="surah"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option :value="null">-- كل السور --</option>
                                <option v-for="surah in surahs" :key="surah.id" :value="surah.id">
                                    {{ surah.name_ar }}
                                </option>
                            </select>
                        </div>
                        
                        <div>
                            <button type="submit" :disabled="form.processing"
                                class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                بحث
                            </button>
                        </div>
                    </form>
                </section>

                <section class="bg-white p-6 rounded-lg shadow-xl">
                    <div class="text-3xl text-right font-quran leading-loose" dir="rtl">
                        <p v-for="verse in verses.data" :key="verse.id" class="my-4 border-b border-gray-200 pb-2">
                            {{ verse.text }} 
                            
                            <span class="text-sm text-gray-500 mr-4">
                                ({{ verse.surah.name_ar }}:{{ verse.number_in_surah }})
                            </span>
                        </p>
                        
                        <div v-if="verses.data.length === 0" class="text-center text-gray-500 py-10">
                            لا توجد آيات مطابقة لمعايير البحث.
                        </div>
                    </div>
                    
                    <div v-if="verses.meta.last_page > 1" class="mt-6">
                        <Pagination :links="verses.meta.links" />
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue'; // يجب أن تنشئ هذا المكون
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

// 1. استقبال الـ Props المرسلة من Controller
const props = defineProps({
    verses: Object, // كائن التصفح (Pagination Object)
    filters: Object, // كائن الفلاتر الحالية
    surahs: Array,  // قائمة السور
});

// 2. إعداد حالة النموذج (Form State)
const form = reactive({
    search_term: props.filters.search_term || '',
    surah_id: props.filters.surah_id || null,
    // ... أي فلاتر أخرى (مثل juz_id، riwaya_id)
});

// 3. دالة إرسال النموذج (Handling Form Submission)
const applyFilters = () => {
    // نستخدم Inertia Visit (GET Request) لإعادة تحميل الصفحة بالـ Query Parameters الجديدة
    router.get(route('quran.mushaf'), form, {
        preserveState: true, // للحفاظ على حالة الـ Scroll
        preserveScroll: true,
        // يمكنك استخدام only: ['verses', 'filters'] للـ Partial Reloads لتحسين الأداء
    });
};
</script>

<style>
/* 4. تعريف خط المصحف */
@font-face {
    font-family: 'UthmanicWarsh';
    /* يجب التأكد من وضع الملف 'uthmanic_warsh_v21.ttf' في مكان يمكن الوصول إليه (عادةً في 'public/fonts/') */
    src: url('/fonts/uthmanic_warsh_v21.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.font-quran {
    font-family: 'UthmanicWarsh', serif;
    /* خط الأساس: تحديد حجم مناسب */
    font-size: 24px; 
}
</style>