<script setup>
import { Head, Link } from '@inertiajs/vue3';

import DropdownLink from '@/Components/DropdownLink.vue';
import Layout from '@/Layouts/Layout.vue';
import Navbar from '@/Components/Navbar.vue';
import Background from '@/Components/Background.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { defineProps, onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { ref } from 'vue';



// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
    
})

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});


</script>



<template>
    <Navbar></Navbar>
</template>