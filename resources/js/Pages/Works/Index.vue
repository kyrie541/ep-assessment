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

        <div class="py-12">
            <div class="max-w-4xl mx-auto py-10">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Job Listings</h1>
                    <Link
                        href="/works/create"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    >
                        + Create Job
                    </Link>
                </div>

                <div v-if="works.length === 0" class="text-gray-500">
                    No jobs posted yet.
                </div>

                <div class="grid gap-6">
                    <div
                        v-for="work in works"
                        :key="work.id"
                        class="bg-white shadow-md rounded-lg p-6 border border-gray-200"
                    >
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold">
                                    {{ work.title }}
                                </h2>
                                <p class="text-gray-600 mt-1">
                                    {{ work.description }}
                                </p>

                                <div
                                    v-if="work.required_skills?.length"
                                    class="mt-3 flex flex-wrap gap-2"
                                >
                                    <span
                                        v-for="skill in work.required_skills"
                                        :key="skill"
                                        class="bg-blue-100 text-blue-700 text-sm px-2 py-1 rounded-full"
                                    >
                                        {{ skill }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                <Link
                                    :href="`/works/${work.id}/edit`"
                                    class="inline-flex items-center text-sm text-white bg-yellow-600 hover:bg-yellow-700 px-3 py-1 rounded-md transition"
                                >
                                    ✏️ Edit
                                </Link>

                                <button
                                    @click="deleteJob(work.id)"
                                    class="inline-flex items-center text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md transition"
                                >
                                    🗑️ Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { Head, Link } from "@inertiajs/vue3";

const works = ref([]);

const fetchJobs = async () => {
    const res = await axios.get("/api/works");
    works.value = res.data;
};

const deleteJob = async (id) => {
    if (confirm("Delete this job?")) {
        await axios.delete(`/api/works/${id}`);
        fetchJobs();
    }
};

onMounted(fetchJobs);
</script>
