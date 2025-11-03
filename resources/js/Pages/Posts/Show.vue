<template>
  <div class="w-full px-4 md:px-6">
    <div class="mb-6">
      <Link
        href="/posts"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block text-sm md:text-base"
      >
        ← العودة إلى المنشورات
      </Link>

      <div class="bg-white p-4 md:p-6 rounded-lg shadow-md border">
        <h1 class="text-xl md:text-2xl font-bold mb-2 break-words">
          سورة {{ ayahs[0]?.sura_name_ar || 'غير محدد' }} - الآيات {{ post.start_verse }} إلى {{ post.end_verse }}
        </h1>
        <p class="text-sm md:text-base text-gray-600 mb-4">
          بواسطة {{ post.user.name }} - {{ formatDate(post.created_at) }}
        </p>

        <div class="space-y-2">
          <div
            v-for="ayah in ayahs"
            :key="ayah.id"
            class="border-r-4 border-blue-500 pr-2 py-0"
            dir="rtl"
          >
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <p class="text-base md:text-lg leading-relaxed font-arabic mb-2">
                  {{ ayah.aya_text }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  post: Object,
  ayahs: Array,
  surah_name: String,
});

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('ar-EG', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};
</script>

<style scoped>
.font-arabic {
  font-family: 'Uthmanic Warsh', serif;
  font-size: 1.25rem;
  line-height: 2;
}
</style>