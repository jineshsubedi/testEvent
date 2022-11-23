<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    event: Object,
});
const form = useForm();
</script>

<template>
    <Head title="Event Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event Information
            </h2>
        </template>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <img :src="event.image_url" class="card-img-top" :alt="event.title" v-if="event.image != null" />
                    <div class="card-body">
                        <h5 class="card-title">{{event.title}}</h5>
                        <p class="text-muted">Creator: {{event.user.name}}</p>
                        <p class="card-text " v-html="event.description">
                           
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Start Date: {{event.start_date}}</li>
                        <li class="list-group-item">End Date: {{event.end_date}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
