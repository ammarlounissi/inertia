<script setup>
import { defineProps } from 'vue';

defineProps({
    verses: Array,
});
</script>

<template>
    <MainLayout title="اختبار علاقات القرآن">
        <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold mb-8 text-indigo-800 dir-rtl">
                صفحة اختبار علاقات نماذج القرآن الكريم
            </h1>
            <p class="mb-8 text-gray-600 dir-rtl">
                يتم عرض {{ verses.length }} آية مع تحميل جميع العلاقات المطلوبة.
                نجاح عرض كل مربع بيانات لكل آية يعني أن العلاقة تعمل بشكل صحيح (Eager Loading ناجح).
            </p>

            <div v-if="verses.length === 0" class="text-center py-10 bg-red-50 rounded-lg shadow-inner">
                <p class="text-xl text-red-700 font-semibold">
                    ⚠️ لم يتم العثور على آيات. يرجى التأكد من تعبئة قاعدة البيانات.
                </p>
            </div>

            <div v-else class="space-y-8">
                <div v-for="verse in verses" :key="verse.id" 
                     class="bg-white shadow-xl rounded-xl p-6 border-r-8 border-indigo-600 transition duration-300 hover:border-r-[12px]">
                    
                    <div class="dir-rtl border-b pb-4 mb-4">
                        <p class="font-quran text-4xl leading-loose text-gray-900">
                            {{ verse.text }} <span class="text-2xl text-indigo-600 align-top">({{ verse.number_in_surah }})</span>
                        </p>
                        <span class="text-sm text-gray-500">الآية رقم: {{ verse.id }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm dir-rtl">
                        
                        <div class="p-3 bg-indigo-50 rounded-lg border border-indigo-200">
                            <h4 class="font-bold text-indigo-700 mb-1">✅ السورة (Verse -> Surah)</h4>
                            <p>العربية: <strong class="text-indigo-900">{{ verse.surah.name_ar }}</strong></p>
                            <p>الإنجليزية: <strong class="text-indigo-900">{{ verse.surah.name_en }}</strong></p>
                        </div>

                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <h4 class="font-bold text-green-700 mb-1">✅ الجزء (Verse -> Juz)</h4>
                            <p>رقم الجزء: <strong class="text-green-900">{{ verse.juz.id }}</strong></p>
                            <p>الاسم: <strong class="text-green-900">{{ verse.juz.name }}</strong></p>
                        </div>

                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-bold text-yellow-700 mb-1">✅ الرواية (Verse -> Riwaya)</h4>
                            <p>الاسم: <strong class="text-yellow-900">{{ verse.riwaya.name_ar }}</strong></p>
                        </div>
                        
                        <div class="p-3 bg-red-50 rounded-lg border border-red-200">
                            <h4 class="font-bold text-red-700 mb-1">✅ الصفحة وعلاقاتها المتداخلة</h4>
                            <p>رقم الصفحة: <strong class="text-red-900">{{ verse.page.id }}</strong></p>
                            <p>السورة عبر الصفحة: <strong class="text-red-900">{{ verse.page.surah.name_ar }}</strong></p>
                            <p>الجزء عبر الصفحة: <strong class="text-red-900">{{ verse.page.juz.name }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>