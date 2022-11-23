<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    event: Object,
})
const form = useForm({
    title: props.event.title,
    description: props.event.description,
    slug: props.event.slug,
    start_date: props.event.start_date,
    end_date: props.event.end_date,
    banner: null,
});
let imageSelected = ref(props.event.image_url)

function generateSlug()
{
    form.slug =  form.title.toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
}

function onFileChange() {
    imageSelected.value = URL.createObjectURL(form.banner);
}

function submitForm() // due to limitation of multipart/form-data in put method
{
    Inertia.post(route('admin.events.update', props.event.id), {
        _method: 'put',
        title: form.title,
        slug: form.slug,
        description: form.description,
        banner: form.banner,
        start_date: form.start_date,
        end_date: form.end_date
    })
}
</script>

<template>
    <Head title="Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link :href="route('admin.events.create')">Edit Event</Link>
            </h2>
        </template>

        <div class="card">
            <form
                class="form-horizontal"
                @submit.prevent="
                    submitForm
                "
                enctype="multipart/form-data"
            >
            <div class="card-body">
                <div class="form-group row mb-3">
                    <label
                        for="title"
                        class="col-sm-2 col-form-label"
                        >Title</label
                    >
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control"
                            id="title"
                            placeholder="Title"
                            v-model="form.title"
                            @blur="generateSlug"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.title"
                        >
                            {{ form.errors.title }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="slug"
                        class="col-sm-2 col-form-label"
                        >Slug</label
                    >
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control"
                            id="slug"
                            placeholder="Slug"
                            v-model="form.slug"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.slug"
                        >
                            {{ form.errors.slug }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="start_date"
                        class="col-sm-2 col-form-label"
                        >Start Day</label
                    >
                    <div class="col-sm-10">
                        <input
                            type="date"
                            class="form-control"
                            id="start_date"
                            placeholder="start date"
                            v-model="form.start_date"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.start_date"
                        >
                            {{ form.errors.start_date }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="end_date"
                        class="col-sm-2 col-form-label"
                        >End Day</label
                    >
                    <div class="col-sm-10">
                        <input
                            type="date"
                            class="form-control"
                            id="end_date"
                            placeholder="start date"
                            v-model="form.end_date"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.end_date"
                        >
                            {{ form.errors.end_date }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="description"
                        class="col-sm-2 col-form-label"
                        >Description</label
                    >
                    <div class="col-sm-10">
                        <textarea v-model="form.description" class="form-control" id="description" rows="5"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.description"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="banner"
                        class="col-sm-2 col-form-label"
                        >Banner</label
                    >
                    <div class="col-sm-10">
                        <input
                            type="file"
                            class="form-control"
                            id="banner"
                            @input="form.banner = $event.target.files[0]"
                            @change="onFileChange"
                            accept="image/*"
                        />
                        <img :src="imageSelected" style="width: 100px" v-if="imageSelected != null">
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.banner"
                        >
                            {{ form.errors.banner }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group row mb-3">
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
