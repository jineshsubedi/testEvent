<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    events: Object,
    filters: Object,
});
const form = useForm();

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.events.destroy", id));
    }
}
</script>

<template>
    <Head title="Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link :href="route('admin.events.index')">Event</Link> 
            </h2>
        </template>

        <div class="card">
            <div class="card-header">
                Event Manager
                <span class="btn-group float-end">
                    <Link
                        :href="route('admin.events.create')"
                        class="btn btn-sm btn-outline-primary"
                    >
                        <i class="bi bi-plus"></i> Add Events
                    </Link>
                    <span class="dropdown">
                        <button
                            class="btn btn-sm btn-outline-info dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton1"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Filter
                        </button>
                        <ul
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuButton1"
                        >
                            <li><Link class="dropdown-item" :href="route('admin.events.index')">All</Link></li>
                            <li><Link class="dropdown-item" :href="route('admin.events.index', {type: 'upcomming'})">Upcomming</Link></li>
                            <li><Link class="dropdown-item" :href="route('admin.events.index', {type: 'running'})">Running</Link></li>
                            <li><Link class="dropdown-item" :href="route('admin.events.index', {type: 'finished'})">finished</Link></li>
                            <li><Link class="dropdown-item" :href="route('admin.events.index', {type: 'latest_upcomming'})">Upcomming within 7 days</Link></li>
                            <li><Link class="dropdown-item" :href="route('admin.events.index', {type: 'earliest_finish'})">finished within 7days</Link></li>
                        </ul>
                    </span>
                    
                </span>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="events.data.length > 0">
                        <tr v-for="(event, index) in events.data" :key="index">
                            <td>{{ ++index }}</td>
                            <td>{{ event.title }}</td>
                            <td>{{ event.start_date }}</td>
                            <td>{{ event.end_date }}</td>
                            <td><p v-html="event.status"></p></td>
                            <td>
                                <Link
                                    :href="route('admin.events.show', event.id)"
                                    class="btn btn-sm btn-outline-info"
                                >
                                    <i class="bi bi-eye"></i>
                                </Link>
                                <Link
                                    :href="route('admin.events.edit', event.id)"
                                    class="btn btn-sm btn-outline-warning"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </Link>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    @click="destroy(event.id)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-info text-center">
                                    No Events Found!
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <Pagination
                                    class="mt-6"
                                    :links="events.links"
                                />
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
