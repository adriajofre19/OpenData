<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { onMounted } from 'vue';
import { initFlowbite, initModals } from 'flowbite';
import axios from 'axios';

const props = defineProps(['plans', 'categories', 'users', 'showButtons']);

let deleteModal = ref(false);
let editUser = ref(false);
let viewModal = ref(false);
let planModal = ref(false);
const activities = ref([]);

const form = useForm({
    id: '',
    name: '',
    description: '',
    start_date: '',
    end_date: '',
    id_category: '',
});

const formUsers = useForm({
    id: '',
    selectedUsers: ref([]),
});

const updateSelectedUsers = (userId) => {
    const index = formUsers.selectedUsers.value.indexOf(userId);
    if (index === -1) {
        formUsers.selectedUsers.value.push(userId);
    } else {
        formUsers.selectedUsers.value.splice(index, 1);
    }
}

function update() {
    form.get('/profile/updateplan/'+ form.id, form);
}

function share() {
    console.log(formUsers.id);
    console.log(formUsers.selectedUsers);

    formUsers.post('/profile/share-plan/' + formUsers.id, formUsers.selectedUsers);
    closeModal(); 
}

function deletePlan(id) {
    form.delete('/profile/deleteplan/' + id);
}

function deleteActivity(id) {
    form.delete('/profile/deleteactivity/' + id);
}

const getActivities = async (id) => {
    viewModal.value = true;
  try {
    const response = await axios.get('/profile/getactivities/' + id);
    activities.value = response.data;
    console.log(activities.value);
  } catch (error) {
    console.error('Error al obtener actividades:', error);
  }
};

function showModal(id) {
    form.id = id;
    deleteModal.value = true;
}

function openEditPlanModal(id) {
    editUser.value = true;
    form.id = id;
    form.name = props.plans.title;
    form.description = props.plans.description;
    form.start_date = props.plans.start_date;
    form.end_date = props.plans.end_date;
    form.id_category = props.plans.id_category;
}

function openSharePlanModal(id) {
    planModal.value = true;
    formUsers.id = id;
    formUsers.selectedUsers = [];
}

function closeModal() {
    deleteModal.value = false;
    editUser.value = false;
    viewModal.value = false;
    planModal.value = false;
}

const shareOnTwitter = (plan) => {
    const tweetText = encodeURIComponent(`Mira aquest plan: ${plan.title}. \nData d'inici: ${plan.start_date}. \nData final: ${plan.end_date}. \nMes informacio a: ${window.location.href}`);
    const url = `https://twitter.com/intent/tweet?text=${tweetText}`;
    window.open(url, '_blank');
}

onMounted(() => {
    initFlowbite();
    initModals();
    console.log(props.plans)
});
</script>

<template>

    <div class="flex flex-col pb-4 w-full">
        <div class="relative flex flex-col md:flex-row md:space-x-5 space-y-3 md:space-y-0 rounded-xl shadow-lg p-4 border border-white bg-white">
            <div class="w-full md:w-1/6 bg-white grid place-items-center">
                <img :src="plans.image" :alt="plans.title" class="rounded-xl h-full"/>
            </div>
            <div class="w-full bg-white flex flex-col space-y-2 p-3 relative">
                <div class="flex justify-between items-center">
                    <p class="text-gray-500 font-medium">#{{ plans.category_name }}</p>
                    <div v-if="showButtons" class="flex rounded-md shadow-sm" role="group">
                        <button type="button" @click="getActivities(plans.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 7.8C6.7 6.3 9.2 5 12 5s5.3 1.3 7 2.8a12.7 12.7 0 0 1 2.7 3.2c.2.2.3.6.3 1s-.1.8-.3 1a2 2 0 0 1-.6 1 12.7 12.7 0 0 1-9.1 5c-2.8 0-5.3-1.3-7-2.8A12.7 12.7 0 0 1 2.3 13c-.2-.2-.3-.6-.3-1s.1-.8.3-1c.1-.4.3-.7.6-1 .5-.7 1.2-1.5 2.1-2.2Zm7 7.2a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button type="button" @click="openEditPlanModal(plans.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M14 4.2a4.1 4.1 0 0 1 5.8 0 4 4 0 0 1 0 5.7l-1.3 1.3-5.8-5.7L14 4.2Zm-2.7 2.7-5.1 5.2 2.2 2.2 5-5.2-2.1-2.2ZM5 14l-2 5.8c0 .3 0 .7.3 1 .3.3.7.4 1 .2l6-1.9L5 13.8Zm7 4 5-5.2-2.1-2.2-5.1 5.2 2.2 2.1Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button type="button" @click="showModal(plans.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button type="button" @click="shareOnTwitter(plans)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 5.9c-.7.3-1.5.5-2.4.6a4 4 0 0 0 1.8-2.2c-.8.5-1.6.8-2.6 1a4.1 4.1 0 0 0-6.7 1.2 4 4 0 0 0-.2 2.5 11.7 11.7 0 0 1-8.5-4.3 4 4 0 0 0 1.3 5.4c-.7 0-1.3-.2-1.9-.5a4 4 0 0 0 3.3 4 4.2 4.2 0 0 1-1.9.1 4.1 4.1 0 0 0 3.9 2.8c-1.8 1.3-4 2-6.1 1.7a11.7 11.7 0 0 0 10.7 1A11.5 11.5 0 0 0 20 8.5V8a10 10 0 0 0 2-2.1Z" clip-rule="evenodd"/>
                            </svg>  
                        </button>
                        <button type="button" @click="openSharePlanModal(plans.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.5 3A3.5 3.5 0 0 0 14 7L8.1 9.8A3.5 3.5 0 0 0 2 12a3.5 3.5 0 0 0 6.1 2.3l6 2.7-.1.5a3.5 3.5 0 1 0 1-2.3l-6-2.7a3.5 3.5 0 0 0 0-1L15 9a3.5 3.5 0 0 0 6-2.4c0-2-1.6-3.5-3.5-3.5Z"/>
                            </svg>
                        </button>
                    </div>   
                </div>
                <h3 class="font-black text-gray-800 md:text-2xl text-xl">{{ plans.title }}</h3>
                <p class="md:text-lg text-gray-500 text-base">{{ plans.description }}</p>
            </div>
        </div>
    </div> 

    <div v-if="deleteModal === true" tabindex="-1" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full">
        <div class="relative p-4 w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button @click="closeModal()" data-modal-hide="deleteUserModal" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Estas segur que vols eliminar aquest plan.</h3>
                    <button @click="deletePlan(form.id)" data-modal-hide="deleteUserModal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Eliminar
                    </button>
                    <button @click="closeModal()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Cancel·lar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div v-if="editUser === true" tabindex="-2" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between rounded-t dark:border-gray-600">
                    <button @click="closeModal()" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" @submit.prevent="update">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                            <input type="text" v-model="form.name" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripció</label>
                            <input type="text" v-model="form.description" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data d'inici</label>
                            <input type="date" v-model="form.start_date" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data final</label>
                            <input type="date" v-model="form.end_date" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        <div class="col-span-2">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plans</label>
                            <select v-model="form.id_category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="category in props.categories" :key="category.id" :value="category.id ">{{ category.name }}</option>
                            </select>
                        </div>
                    </div>
                    <button @click="cleanForm()" type="submit" data-modal-target="adduser-modal" data-modal-toggle="adduser-modal" class="text-white inline-flex items-center bg-gray-900  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ACTUALITZAR PLAN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div v-if="viewModal === true" tabindex="-2" class="fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="flex justify-center items-center">
                <div class="relative overflow-y-auto bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between rounded-t dark:border-gray-600">
                        <button @click="closeModal()" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span> 
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4 overflow-y-auto">
                        <div v-if="activities.length > 0">
                            <ol class="relative border-s border-gray-200 dark:border-gray-700">               
                                <li v-for="(activity, index) in activities" :key="index" class="mb-10 ms-6">            
                                    <span @click="deleteActivity(activity.id); closeModal()" class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ activity.name }}</h3>
                                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Número de participants: {{ activity.person_count }}</time>
                                    <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">{{ activity.description }}</p>
                                </li>
                            </ol>
                        </div>
                        <div v-else>
                            <p>Aquest plan encara no té cap activitat assignat.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>  
    </div>

    <div v-if="planModal === true" tabindex="-2" class="fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="flex justify-center items-center">
                <div class="relative overflow-y-auto bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between rounded-t dark:border-gray-600">
                        <button @click="closeModal()" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Cerrar modal</span> 
                        </button>
                    </div>
                    <form class="p-4 md:p-5" @submit.prevent="share">
                        <div class="grid space-y-2 pb-4">
                            <label v-for="user in users" :key="user.id" for="hs-vertical-checkbox-in-form" class="max-w-xs flex p-4 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                <input type="checkbox" :value="user.id" v-model="formUsers.selectedUsers" @change="updateSelectedUsers(user.id)" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-vertical-checkbox-in-form">
                                <span class="text-sm text-gray-500 ms-3 dark:text-gray-400">{{ user.name }} ( {{ user.email }} )</span>
                            </label>
                        </div>
                        <button  @click="cleanForm()" type="submit" class="text-white inline-flex items-center bg-gray-900  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            COMPARTIR PLAN
                        </button>
                    </form>
                </div>
            </div>
        </div>  
    </div>

</template>