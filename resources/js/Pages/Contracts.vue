<script setup>
import { Head } from '@inertiajs/vue3';
import Background from '@/Components/Background.vue';
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Contract from '@/Components/Contract.vue';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps(['contracts']);

onMounted(() => {
    initFlowbite();
    console.log(props);
})
</script>

<template>
  <Head title="Home" />

  <Navbar />

  <Background>
    <div>
      <div class="container relative flex flex-col justify-between h-full max-w-6xl px-10 mx-auto xl:px-0 mt-5">
        <div class="flex flex-col items-center mt-4 text-white">    
          <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl dark:text-white">Precios sencillos, sin compromiso.</h1>
          <p class="text-center mb-6 text-lg font-normal text-white lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Todo lo que necesitas, nada que no necesites. Elija el plan que mejor se adapte a sus necesidades.</p>
          <div class="grid lg:grid-cols-2 px-8 gap-10 text-zinc-800 mt-10">
            <Contract v-for="contract in contracts" :key="contract.id" :name="contract.name" :description="contract.description" :price="contract.price" :type="contract.type" :contract_description="contract.contract_description" :id="contract.id"/>
          </div>
        </div>
      </div>
    </div>
  </Background>
</template>

