<template>
  <div class="w-full px-4 md:px-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <h1 class="text-xl md:text-2xl font-bold">المنشورات</h1>
      <Link
        href="/posts/create"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm md:text-base whitespace-nowrap"
      >
        إنشاء منشور جديد
      </Link>
    </div>

    <div class="space-y-4">
      <div
        v-for="post in posts"
        :key="post.id"
        class="bg-white p-4 md:p-6 rounded-lg shadow-md border"
      >
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
          <div class="flex-1 min-w-0">
            <h2 class="text-base md:text-lg font-semibold break-words">
              سورة {{ post.sura_name_ar }} - الآيات {{ post.start_verse }} إلى {{ post.end_verse }}
            </h2>
            <p class="text-xs md:text-sm text-gray-600 mt-1">
              بواسطة {{ post.user.name }} - {{ formatDate(post.created_at) }}
            </p>
          </div>
          <Link
            :href="`/posts/${post.id}`"
            class="text-blue-600 hover:text-blue-800 text-sm md:text-base whitespace-nowrap flex-shrink-0"
          >
            عرض التفاصيل
          </Link>
        </div>
      </div>

      <div v-if="posts.length === 0" class="text-center py-8 text-gray-500">
        لا توجد منشورات بعد.
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  posts: Array,
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