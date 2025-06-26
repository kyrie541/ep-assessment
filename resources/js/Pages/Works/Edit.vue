<template>
    <Head title="Admin portal" />

    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <Link href="/works">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Admin Portal
                    </h2>
                </Link>
            </div>
        </header>

        <div v-if="loading">Loading...</div>
        <WorkForm v-else :work="work" />
    </div>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import WorkForm from "./Form.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const workId = page.props.id;

const work = ref(null);
const loading = ref(true);

onMounted(async () => {
    const res = await axios.get(`/api/works/${workId}`);
    work.value = res.data;
    loading.value = false;
});
</script>
