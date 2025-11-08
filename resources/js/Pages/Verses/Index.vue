<template>
    <div>
        <h1>Verses</h1>
        <ul>
            <li v-for="verse in verses" :key="verse.id">
                {{ verse.aya_text }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        verses: Array,
    },
};
</script>