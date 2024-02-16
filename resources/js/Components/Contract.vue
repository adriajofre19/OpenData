<script setup>
import { ref, toRefs } from 'vue';

const props = defineProps(['name', 'description', 'price', 'type', 'contract_description', 'id']);
const description = ref(JSON.parse(props.description));
const { duration, features } = toRefs(description.value);
</script>

<template>

    <div v-if="props.type === 1" class="container">
        <div class="mt-12 m-auto -space-y-4 items-center justify-center md:flex md:space-y-0 md:-space-x-4 xl:w-10/12">
            <div class="relative z-10 -mx-4 group md:w-6/12 md:mx-0 lg:w-5/12">
                <div aria-hidden="true" class="absolute top-0 w-full h-full rounded-2xl bg-white shadow-xl transition duration-500 group-hover:scale-105 lg:group-hover:scale-110"></div>
                <div class="relative p-6 space-y-6 lg:p-8">
                    <h3 class="text-3xl text-gray-700 font-semibold text-center">{{ name }}</h3>
                    <div>
                        <div class="relative flex justify-around">
                            <div class="flex items-end">
                                <span v-if="price == 0.00" class="text-6xl text-gray-800 font-bold leading-0">Gratis</span>
                                <span v-else class="text-6xl text-gray-800 font-bold leading-0">{{ price }}</span>
                                <div class="pb-2">
                                    <span class="block text-1xl text-gray-700 font-bold">€</span>
                                    <span class="block text-purple-500 font-bold">/{{ duration }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul role="list" class="space-y-4 py-6 m-auto text-gray-600">
                        <li v-for="(feature, index) in features.slice(0, 4)" :key="index" class="space-x-2">
                            <span class="text-purple-500 font-semibold">&check;</span>
                            <span>{{ feature }}</span>
                        </li>
                    </ul>
                    <div class="flex justify-center">
                        <a :href="route('register.contract', { id: id })" class="block w-full py-3 px-6 text-center rounded-xl transition bg-purple-600 hover:bg-purple-700 active:bg-purple-800 focus:bg-indigo-600">Començar</a>
                    </div>
                </div>
            </div>
            <div class="relative group md:w-6/12 lg:w-7/12">
                <div aria-hidden="true" class="absolute top-0 w-full h-full rounded-2xl bg-white shadow-lg transition duration-500 group-hover:scale-105"></div>
                <div class="relative p-6 pt-16 md:p-8 md:pl-12 md:rounded-r-2xl lg:pl-20 lg:p-16">
                    <ul role="list" class="space-y-4 py-6 text-gray-600">
                        <li v-for="(feature, index) in features.slice(4)" :key="index" class="space-x-2">
                            <span class="text-purple-500 font-semibold">&check;</span>
                            <span>{{ feature }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div v-if="props.type === 2" class="container">
        <div class="mt-12 m-auto -space-y-4 items-center justify-center md:flex md:space-y-0 md:-space-x-4 xl:w-10/12">
            <div class="relative group md:w-6/12 lg:w-7/12">
                <div aria-hidden="true" class="absolute top-0 w-full h-full rounded-2xl bg-white shadow-lg transition duration-500 group-hover:scale-105"></div>
                <div class="relative p-6 pt-16 md:p-8 md:pl-12 md:rounded-r-2xl lg:pl-20 lg:p-16">
                    <ul role="list" class="space-y-4 py-6 text-gray-600">
                        <li v-for="(feature, index) in features.slice(5)" :key="index" class="space-x-2">
                            <span class="text-purple-500 font-semibold">&check;</span>
                            <span>{{ feature }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative z-10 -mx-4 group md:w-6/12 md:mx-0 lg:w-5/12">
                <div aria-hidden="true" class="absolute top-0 w-full h-full rounded-2xl bg-white shadow-xl transition duration-500 group-hover:scale-105 lg:group-hover:scale-110"></div>
                <div class="relative p-6 space-y-6 lg:p-8">
                    <h3 class="text-3xl text-gray-700 font-semibold text-center">{{ name }}</h3>
                    <div>
                        <div class="relative flex justify-around">
                            <div class="flex items-end">
                                <span v-if="price == 0.00" class="text-6xl text-gray-800 font-bold leading-0">Gratis</span>
                                <span v-else class="text-6xl text-gray-800 font-bold leading-0">{{ price }}</span>
                                <div class="pb-2">
                                  <span class="block text-1xl text-gray-700 font-bold">€</span>
                                  <span class="block text-purple-500 font-bold">/{{ duration }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul role="list" class="space-y-4 py-6 m-auto text-gray-600">
                        <li v-for="(feature, index) in features.slice(0, 5)" :key="index" class="space-x-2">
                            <span class="text-purple-500 font-semibold">&check;</span>
                            <span>{{ feature }}</span>
                        </li>
                    </ul>
                    <div class="flex justify-center">
                        <a :href="route('register.contract', { id: id })" class="block w-full py-3 px-6 text-center rounded-xl transition bg-purple-600 hover:bg-purple-700 active:bg-purple-800 focus:bg-indigo-600">Començar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>