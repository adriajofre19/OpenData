<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

const props = defineProps(['town','space']);

onMounted(() => {
    initFlowbite();
    console.log(props.space)
})
</script>

<template>

    <div class="grid grid-cols-2 gap-4">
        <div v-if="town.length > 0" class="col-span-2 sm:col-span-1 p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="px-4 sm:px-8 max-w-5xl m-auto">
                <h1 class="text-center font-semibold mb-4">Ciutats:</h1>
                <ul class="border border-gray-200 rounded overflow-hidden shadow-md">
                    <li v-for="city in town" :key="city.id" class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">{{ city.town_name }}</li>
                </ul>
            </div>
        </div>
        <div v-else class="col-span-2 sm:col-span-1 p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="sm:px-8 max-w-5xl m-auto">
                <h1 class="text-center font-semibold">Encara no tens cap ciutat guardada.</h1>
            </div>   
        </div>
        <div v-if="space.length > 0" class="col-span-2 sm:col-span-1 p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="px-4 sm:px-8 max-w-5xl m-auto">
                <h1 class="text-center font-semibold mb-4">Espais culturals:</h1>
                <ul class="border border-gray-200 rounded overflow-hidden shadow-md">
                    <li v-for="space in space" :key="space.id" class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">{{ space.space_name }}</li>
                </ul>
            </div>
        </div>
        <div v-else class="col-span-2 sm:col-span-1 p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="sm:px-8 max-w-5xl m-auto">
                <h1 class="text-center font-semibold">Encara no tens cap espai cultural guardat.</h1>
            </div>   
        </div>
    </div>

</template>