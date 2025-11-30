<script setup>
import { ref, onMounted, computed, onUnmounted } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import { defineOptions } from 'vue';

defineOptions({
    layout: null,
});

// ---------------------------
// 1. STATE MANAGEMENT (إدارة الحالة)
// ---------------------------
const current_page = ref(1);
const total_pages = 604;
const suras_list = ref([]);
const page_content = ref(null);
const tafseer_content = ref('');
const active_sura_id = ref(0);

// ---------------------------
// 2. COMPUTED PROPERTIES
// ---------------------------
const imagePath = computed(() => {
    // يضيف صفراً في البداية لضمان أن يكون الرقم 3 خانات (مثل 001.jpg)
    return `/img/${current_page.value.toString().padStart(3, '0')}.jpg`;
});

// ---------------------------
// 3. METHODS
// ---------------------------

const load_suras = async () => {
    try {
        const response = await axios.get('/json/suras.json');
        suras_list.value = response.data;
    } catch (error) {
        console.error("Failed to load Suras:", error);
    }
};

const load_page = async (page) => {
    let newPage = parseInt(page);
    if (newPage < 1) newPage = 1;
    if (newPage > total_pages) newPage = total_pages;
    current_page.value = newPage;
    page_content.value = null;
    tafseer_content.value = '';

    try {
        const response = await axios.get(`/json/page_${newPage}.json`);
        page_content.value = response.data;

        if (response.data.length > 0) {
            // تحديث السورة النشطة بناءً على أول آية في الصفحة
            active_sura_id.value = response.data[0].sura_id;
        }

    } catch (error) {
        console.error(`Failed to load page ${newPage}:`, error);
    }
};

const load_tafseer = async (sura, aya) => {
    // يجب أن تكون هذه الأسماء مطابقة لـ taf.type في ملفات JSON
    const tafseer_names = ['مشكل', 'نصي', 'الجلالين', 'الميسر', 'ابن كثير'];
    tafseer_content.value = 'جاري التحميل...';

    try {
        const response = await axios.get(`/json/aya_${sura}_${aya}.json`);
        let str = '';
        for (const taf of response.data) {
            const name = tafseer_names[taf.type] || `تفسير رقم ${taf.type}`;
            str += `
                <div class="mb-4 p-2 border-b border-gray-200">
                    <strong class="text-blue-700">${name}</strong>
                    <p class="text-sm mt-1">${taf.text}</p>
                </div>
            `;
        }
        tafseer_content.value = str;

    } catch (error) {
        tafseer_content.value = 'فشل تحميل التفسير لهذه الآية.';
        console.error(`Failed to load Tafseer for sura ${sura} aya ${aya}:`, error);
    }
};

const sura_clicked = (e, page, suraId) => {
    e.preventDefault();
    active_sura_id.value = suraId;
    load_page(page);
};

const aya_clicked = (e, sura, aya) => {
    e.preventDefault();
    load_tafseer(sura, aya);
};

const page_change = (offset) => {
    load_page(current_page.value + offset);
};

// ---------------------------
// 4. HOTKEY/KEYBOARD NAVIGATION (اختصارات لوحة المفاتيح)
// ---------------------------
const handleKeyDown = (e) => {
    if (e.key === 'ArrowRight') {
        page_change(-1); // يمين يقلل الصفحة (لأن الاتجاه عربي)
    }
    else if (e.key === 'ArrowLeft') {
        page_change(1); // يسار يزيد الصفحة
    }
    else if (e.key === 'Home') {
        load_page(1);
    }
    else if (e.key === 'End') {
        load_page(total_pages);
    }
};

// ---------------------------
// 5. LIFECYCLE HOOKS
// ---------------------------

onMounted(() => {
    load_suras();
    load_page(1);
    document.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeyDown);
});

// Helper for dynamic styling - (FINAL FIX APPLIED HERE)
const getAyaLinkStyle = (seg) => {
    // عرض الصورة الثابت (290px)
    const IMAGE_WIDTH = 290; 
    
    // تصحيح الانعكاس الأفقي: تحويل الإحداثي 'x' (المقاس من اليسار) إلى مسافة من اليمين (right)
    const calculated_right = IMAGE_WIDTH - seg.x - seg.w;

    return {
        position: 'absolute',
        top: `${seg.y}px`,
        right: `${calculated_right}px`, 
        width: `${seg.w}px`,
        height: `${seg.h}px`,
    };
};
</script>

<template>
    <Head title="القرآن الكريم" />

    <div dir="rtl" class="bg-gray-50 min-h-screen py-4">
        
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div id="wrapper" class="mx-auto w-full lg:w-[95%] shadow-2xl bg-white p-4 lg:p-6 rounded-lg">

                <h1 class="text-3xl font-extrabold text-center text-blue-800 mb-4">القرآن الكريم</h1>

                <div id="control" class="flex justify-center items-center space-x-2 space-x-reverse bg-gray-200 p-2 rounded-md mb-4">
                    <button @click="page_change(-100)" :disabled="current_page <= 1" class="control__button text-sm font-bold p-1 hover:text-blue-700 disabled:text-gray-500">
                        &lt;&lt;&lt;
                    </button>
                    <button @click="page_change(-10)" :disabled="current_page <= 1" class="control__button text-sm font-bold p-1 hover:text-blue-700 disabled:text-gray-500">
                        &lt;&lt;
                    </button>
                    <button @click="page_change(-1)" :disabled="current_page <= 1" class="control__button text-sm font-bold p-1 hover:text-blue-700 disabled:text-gray-500">
                        &lt;
                    </button>

                    <span class="control__page-num inline-block px-4 font-bold text-lg text-gray-800">
                        صفحة : {{ current_page }}
                    </span>

                    <button @click="page_change(1)" :disabled="current_page >= total_pages" class="control__button text-sm font-bold p-1 hover:text-blue-700 disabled:text-gray-500">
                        &gt;
                    </button>
                    <button @click="page_change(10)" :disabled="current_page >= total_pages" class="control__button text-sm font-bold p-1 hover:text-blue-700 disabled:text-gray-500">
                        &gt;&gt;
                    </button>
                    <button @click="page_change(100)" :disabled="current_page >= total_pages" class="control__button text-sm font-bold p-1 hover:text-blue-700 disabled:text-gray-500">
                        &gt;&gt;&gt;
                    </button>
                </div>

                <div id="main" class="flex flex-col lg:flex-row lg:justify-between gap-4 mt-6">

                    <div id="suras" class="w-full lg:w-[25%] h-96 overflow-y-auto border border-gray-300 p-2 rounded-lg bg-gray-50">
                        <table class="suras__table w-full text-sm">
                            <thead>
                                <tr class="bg-blue-100 sticky top-0">
                                    <th class="p-1">#</th>
                                    <th class="p-1">اسم</th>
                                    <th class="p-1">صفحة</th>
                                    <th class="p-1">آيات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="suras_list.length === 0">
                                    <td colspan="4" class="text-center py-4">جاري تحميل السور...</td>
                                </tr>
                                <tr v-for="sura in suras_list" :key="sura.id"
                                    :id="`sura_link_${sura.id}`"
                                    :class="{'bg-blue-600 text-white': sura.id === active_sura_id, 'hover:bg-blue-50': sura.id !== active_sura_id, 'cursor-pointer': true}">
                                    <td class="p-1 text-center">{{ sura.id }}</td>
                                    <td class="p-1 text-right">
                                        <a href="#" class="sura_link block"
                                            :class="{'text-white': sura.id === active_sura_id, 'text-blue-600': sura.id !== active_sura_id}"
                                            @click="sura_clicked($event, sura.page, sura.id)">
                                            {{ sura.name }}
                                        </a>
                                    </td>
                                    <td class="p-1 text-center">{{ sura.page }}</td>
                                    <td class="p-1 text-center">{{ sura.ayas }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="w-full lg:w-[30%] flex justify-center items-start">
                        <div id="page" class="relative bg-gray-100 rounded-lg shadow-2xl p-0 overflow-hidden w-[290px] h-[430px]">
                            
                            <div v-if="page_content" class="relative w-full h-full">
                                <img :src="imagePath" alt="صفحة من القرآن الكريم" class="w-full h-full" />
                                
                                <template v-for="aya in page_content" :key="`${aya.sura_id}-${aya.aya_id}`">
                                    <a v-for="(seg, index) in aya.segs" :key="index" href="#"
                                        class="aya_link absolute block z-10 opacity-0 transition-opacity duration-300
                                               hover:opacity-100 hover:bg-yellow-300/50
                                               focus:opacity-100 focus:bg-yellow-300/50 active:opacity-100 active:bg-yellow-300/50"
                                        :style="getAyaLinkStyle(seg)"
                                        @click="aya_clicked($event, aya.sura_id, aya.aya_id)">
                                        <div class="w-full h-full"></div>
                                    </a>
                                </template>
                            </div>
                            <div v-else class="flex items-center justify-center h-full text-lg text-gray-500">
                                جاري تحميل الصفحة...
                            </div>
                        </div>
                    </div>
                    
                    <div id="tafseer" class="w-full lg:w-[45%] h-96 overflow-y-auto border border-gray-300 p-3 rounded-lg bg-gray-50">
                        <h2 class="text-xl font-bold text-gray-700 border-b pb-2 mb-3 sticky top-0 bg-gray-50">التفسير المُختار</h2>
                        <div v-if="tafseer_content" class="text-gray-600" v-html="tafseer_content"></div>
                        <div v-else class="text-sm text-gray-500">
                            انقر على أي آية في الصفحة الوسطى لعرض تفاسيرها هنا.
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>