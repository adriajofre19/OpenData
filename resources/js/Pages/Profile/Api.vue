<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { initFlowbite } from 'flowbite';
import Plan from './Plan.vue';
import Comment from './Comment.vue';

const props = defineProps(['userId', 'plans', 'activities', 'categories']);
const token = ref('');
const axiosPlans = ref([]);
const axiosComments = ref([]);
const url = ref('');
let activeSection = ref('plan');

const submit = () => {
    event.preventDefault();
    console.log(token.value);
    axios.get('/check-token/' + token.value)
        .then(response => {
            axiosPlans.value = response.data.plans;
            url.value = response.data.url; 
            console.log("Resultado:", axiosPlans.value);
            console.log("URL:", url.value); 
        })
        .catch(error => {
            console.error("Error:", error);
        });
};

const submit2 = () => {
    event.preventDefault();
    console.log(token.value);
    axios.get('/check-token-2/' + token.value)
        .then(response => {
            axiosComments.value = response.data.comments;
            url.value = response.data.url; 
            console.log("Resultado:", axiosComments.value);
            console.log("URL:", url.value); 
        })
        .catch(error => {
            console.error("Error:", error);
        });
};

function setActiveSection(section) {
    activeSection.value = section;
}

const generateAPIKey = () => {
    axios.post('/profile/addapikey');
};

onMounted(() => {
    initFlowbite();
});
</script>

<template>
    
    <div v-if="$page.props.auth.user.api_token" class="mb-4 space-x-4">
        <a class="text-gray-900 inline-flex items-center bg-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Token: {{ $page.props.auth.user.api_token }}
        </a>
    </div>
    <div v-else class="mb-4 space-x-4">
        <form @submit.prevent="generateAPIKey">
            <button class="text-gray-900 inline-flex items-center bg-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                GENERAR API KEY
            </button>
        </form>
    </div>

    <div class="pb-4">
        <div class="sm:hidden"> 
            <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" @change.prevent="setActiveSection($event.target.value)">
                <option value="plan">Plans</option>
                <option value="comment">Comentaris</option>
            </select>
        </div>
        <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
            <li class="w-full">
                <a href="#" @click.prevent="setActiveSection('plan')" class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white" aria-current="page">Plans</a>
            </li>
            <li class="w-full">
                <a href="#" @click.prevent="setActiveSection('comment')" class="inline-block w-full p-4 bg-white border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Commentaris</a>
            </li>
        </ul>
    </div>

    <div v-if="activeSection === 'plan'" class="bg-white p-4 rounded-xl">
        <form class="max-w-sm mx-auto" @submit.prevent="submit">
            <div class="mb-5">
                <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingressa el teu token:</label>
                <input type="token" id="token" v-model="token" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <button class="text-white inline-flex items-center bg-gray-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                VEURE PLANS
            </button>
        </form>
    </div>

    <div v-if="activeSection === 'comment'" class="bg-white p-4 rounded-xl">
        <form class="max-w-sm mx-auto" @submit.prevent="submit2">
            <div class="mb-5">
                <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingressa el teu token:</label>
                <input type="token" id="token" v-model="token" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <button class="text-white inline-flex items-center bg-gray-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                VEURE COMENTARIS
            </button>
        </form>
    </div>
    
    <div v-if="url.length > 0" class="pt-4">
        <a :href="url" class="text-gray-900 inline-flex items-center bg-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            URL: {{ url }} 
        </a>
    </div>

    <div v-if="axiosPlans.length > 0" class="pt-4">
        <Plan v-for="plan in axiosPlans" :key="plan.id" :plans="plan" :categories="categories" :showButtons="false"/>
    </div>

    <div v-if="axiosComments.length > 0" class="pt-4">
        <Comment v-for="comment in axiosComments" :key="comment.id" :comments="comment"/>
    </div>

</template>