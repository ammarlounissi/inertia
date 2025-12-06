<template>
  <div class="quran-page-container relative mx-auto my-8 shadow-2xl overflow-hidden">
    <img :src="imagePath" alt="صفحة المصحف رقم 3" class="absolute top-0 left-0 w-full h-full object-cover">
    <template v-for="item in pageData" :key="item.aya_id">
      <div
        v-for="(seg, index) in item.segs"
        :key="`${item.aya_id}-${index}`"
        :style="getSegmentStyle(seg)"
         class="absolute z-10 bg-black-500/30 hover:bg-blue-500/50 active:bg-blue-500/70 transition-colors cursor-pointer rounded-sm"        :data-sura-id="item.sura_id"
        :data-aya-id="item.aya_id"
        :title="`سورة: ${item.sura_id}، آية: ${item.aya_id}`"
      >
      </div>
    </template>
  </div>
</template>

<script setup>
import { computed } from 'vue';
defineOptions({
    layout: null,
});
const pageData = [
  {"sura_id": 2, "segs": [{"y": 0, "x": 0, "w": 290, "h": 28}, {"y": 28, "x": 219, "w": 71, "h": 28}], "aya_id": 6},
  {"sura_id": 2, "segs": [{"y": 28, "x": 0, "w": 219, "h": 28}, {"y": 57, "x": 81, "w": 209, "h": 28}], "aya_id": 7},
  {"sura_id": 2, "segs": [{"y": 57, "x": 0, "w": 81, "h": 28}, {"y": 85, "x": 16, "w": 274, "h": 28}], "aya_id": 8},
  {"sura_id": 2, "segs": [{"y": 85, "x": 0, "w": 16, "h": 28}, {"y": 114, "x": 0, "w": 290, "h": 28}, {"y": 143, "x": 208, "w": 82, "h": 28}], "aya_id": 9},
  {"sura_id": 2, "segs": [{"y": 143, "x": 0, "w": 208, "h": 28}, {"y": 171, "x": 92, "w": 198, "h": 28}], "aya_id": 10},
  {"sura_id": 2, "segs": [{"y": 171, "x": 0, "w": 92, "h": 28}, {"y": 200, "x": 20, "w": 270, "h": 28}], "aya_id": 11},
  {"sura_id": 2, "segs": [{"y": 200, "x": 0, "w": 20, "h": 28}, {"y": 228, "x": 59, "w": 231, "h": 28}], "aya_id": 12},
  {"sura_id": 2, "segs": [{"y": 228, "x": 0, "w": 59, "h": 28}, {"y": 257, "x": 0, "w": 290, "h": 28}, {"y": 286, "x": 70, "w": 220, "h": 28}], "aya_id": 13},
  {"sura_id": 2, "segs": [{"y": 286, "x": 0, "w": 70, "h": 28}, {"y": 314, "x": 0, "w": 290, "h": 28}, {"y": 343, "x": 130, "w": 160, "h": 28}], "aya_id": 14},
  {"sura_id": 2, "segs": [{"y": 343, "x": 0, "w": 130, "h": 28}, {"y": 371, "x": 166, "w": 124, "h": 28}], "aya_id": 15},
  {"sura_id": 2, "segs": [{"y": 371, "x": 0, "w": 166, "h": 28}, {"y": 400, "x": 16, "w": 274, "h": 28}], "aya_id": 16}
];

const imagePath = computed(() => '/img-3/003.png');

const originalWidth = 290;
const originalHeight = 430;

const getSegmentStyle = (seg) => {
  return {
    top: `${(seg.y / originalHeight) * 100}%`,
    left: `${(seg.x / originalWidth) * 100}%`,
    width: `${(seg.w / originalWidth) * 100}%`,
    height: `${(seg.h / originalHeight) * 100}%`,
    zIndex: 10,
  };
};
</script>
<style scoped>
.quran-page-container {
  width: 100vw;                  /* يملأ عرض الشاشة بالكامل */
  max-width: 100%;               /* لا يتجاوز عرض الشاشة أبدًا */
  aspect-ratio: 290 / 490;       /* يحافظ على نسبة الصورة الأصلية */
  position: relative;
  background-color: rgb(253, 252, 252);
  margin: 0 auto;                /* توسيط أفقي إذا كان العرض أقل من 100vw */
}
</style>