<template>
  <div class="w-full px-4 md:px-6 md:max-w-2xl md:mx-auto">
    <h1 class="text-2xl font-bold mb-6">إنشاء منشور جديد</h1>

    <form @submit.prevent="submit" class="space-y-4 md:space-y-6">
      <div>
        <label for="surah_id" class="block text-sm font-medium text-gray-700 mb-2">
          اختر السورة
        </label>
        <select
          id="surah_id"
          v-model.number="form.surah_id"
          required
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-900 text-right md:bg-white md:text-gray-900"
          dir="rtl"
        >
          <option value="" class="text-gray-900 bg-white hover:bg-gray-100">اختر سورة...</option>
          <option
            v-for="surah in surahs"
            :key="surah.sura_no"
            :value="surah.sura_no"
            class="text-gray-900 bg-white hover:bg-gray-100"
          >
            {{ surah.sura_name_ar }}
          </option>
        </select>
      </div>

      <div>
        <label for="start_verse" class="block text-sm font-medium text-gray-700 mb-2">
          رقم الآية الأولى
        </label>
        <input
          id="start_verse"
          v-model.number="form.start_verse"
          type="number"
          min="1"
          :max="maxVerse"
          required
          :disabled="!form.surah_id"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
        />
        <p v-if="selectedSurah" class="text-sm text-gray-500 mt-1">
          الحد الأقصى: {{ maxVerse }} آية
        </p>
      </div>

      <div>
        <label for="end_verse" class="block text-sm font-medium text-gray-700 mb-2">
          رقم الآية الأخيرة
        </label>
        <input
          id="end_verse"
          v-model.number="form.end_verse"
          type="number"
          min="1"
          :max="maxVerse"
          required
          :disabled="!form.surah_id"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
        />
        <p v-if="selectedSurah" class="text-sm text-gray-500 mt-1">
          الحد الأقصى: {{ maxVerse }} آية
        </p>
      </div>

      <div class="flex flex-col sm:flex-row gap-4">
        <button
          type="submit"
          :disabled="form.processing"
          class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 text-sm md:text-base"
        >
          إنشاء المنشور
        </button>

        <Link
          href="/posts"
          class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-center text-sm md:text-base"
        >
          إلغاء
        </Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
  surahs: Array,
});

const form = useForm({
  surah_id: null,
  start_verse: null,
  end_verse: null,
});

// Computed property to get the selected surah
const selectedSurah = computed(() => {
  return props.surahs.find(surah => surah.sura_no === form.surah_id);
});

// Computed property for max verse number
const maxVerse = computed(() => {
  return selectedSurah.value ? selectedSurah.value.total_verses : 1;
});

const submit = () => {
  form.post('/posts', {
    onSuccess: () => {
      // Reset form on success
      form.reset();
    },
  });
};
</script>