<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2 sm:col-span-1 p-4 sm:p-8 bg-white shadow rounded-lg"> 
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />
        </div>
        <div class="col-span-2 sm:col-span-1 p-4 sm:p-8 bg-white shadow rounded-lg">
            <UpdatePasswordForm class="max-w-xl" />
        </div>
        <div class="col-span-2 p-4 sm:p-8 bg-white shadow rounded-lg">
            <DeleteUserForm class="" />
        </div>
    </div>

</template>