<script setup>
const props = defineProps(['image','name','description', 'id']);
const categoryRoute = (category) => {
  switch (category) {
    case 1:
      return route('culturalactivities');
    case 2:
      return route('culturalactivities2');
  }
};
</script>

<template>

  <div class="p-4">
    <a :href="categoryRoute(props.id)" class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl px-8 pb-8 pt-40 max-w-sm mx-auto">
      <img :src="props.image" :alt="props.name" class="absolute inset-0 h-full w-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
      <h3 class="z-10 mt-3 text-3xl font-bold text-white">{{ props.name }}</h3>
      <div class="z-10 gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">{{ props.description }}</div>
    </a>
  </div>
  
</template>