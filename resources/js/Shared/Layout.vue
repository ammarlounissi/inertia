<script setup>
import Nav from './Nav.vue';
import Hamburger from './Hamburger.vue';
import Sidebar from './Sidebar.vue';
import ProfilePictureForm from './ProfilePictureForm.vue';
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const username = computed(() => page.props.auth.user.username);
const user = computed(() => page.props.auth.user);
const showProfileForm = ref(false);

const profilePictureUrl = computed(() => {
    if (user.value.profile_picture_url) {
        return user.value.profile_picture_url;
    }
    return '/default-avatar.png'; // You can add a default avatar image
});

</script>

<template>
    <Head>
        <meta type="description" content="Information about this app" head-key="description">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </Head>
    
    <!-- Header -->
    <section class="fixed top-0 right-0 left-0 z-10 p-6 bg-gray-200 md:hidden">
        <header class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h1 class="font-bold text-lg md:hidden">
الدورة الشتوية                  </h1>

                <p>اهلا  , {{ username }}!</p>
            </div>

            <div class="flex items-center gap-2">
                <img
                    :src="profilePictureUrl"
                    alt="Profile Picture"
                    class="w-10 h-10 rounded-full cursor-pointer border-2 border-white shadow-md"
                    @click="showProfileForm = true"
                >
            </div>
        </header>
    </section>

    <!-- Sidebar -->
    <Sidebar />

    <!-- Main Content -->
    <main class="lg:mr-[25%] mt-20 min-h-screen md:mt-0">
        <section class="p-4 md:p-6 pb-24">
            <div class="max-w-4xl mx-auto">
                <slot />
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="fixed bottom-0 left-0 right-0 bg-[#f5f5dc] shadow-lg md:hidden">
        <div class="max-w-3xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <Hamburger />
                <Nav />
            </div>
        </div>
    </footer>

    <!-- Profile Picture Form Modal -->
    <ProfilePictureForm
        :user="user"
        :show="showProfileForm"
        @close="showProfileForm = false"
    />
</template>
