<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Background from '@/Components/Background.vue';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps(['id']);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    id_contract: '',
    id_role: ''
});

if (props.id === 1) {
    form.id_contract = 1;
    form.id_role = 1;
} else {
    form.id_contract = 2; 
    form.id_role = 2; 
}

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

</script>

<template>

    <Head title="Register" />

    <Navbar />

    <Background>
        <div class="p-16">
            <div class="bg-white p-8 rounded-lg">
                <div class="flex justify-center">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Nom" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="email" value="Correu electrònic" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password" value="Contrasenya" />
                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirmar contrasenya" />
                        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('login')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ja estas registrat?
                        </Link>
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Registrar-se
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Background>

</template>