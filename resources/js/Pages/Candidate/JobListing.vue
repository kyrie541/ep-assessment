<template>
    <Head title="Candidate portal" />

    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <Link href="/job-listing">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Candidate Portal
                    </h2>
                </Link>
            </div>
        </header>

        <div>
            <div class="max-w-4xl mx-auto py-10">
                <!-- Resume Upload Section -->
                <div
                    class="bg-white shadow p-6 rounded-md border border-gray-200"
                >
                    <h2 class="text-xl font-semibold mb-4">
                        Please upload resume before matching with jobs
                    </h2>

                    <form class="space-y-5">
                        <div>
                            <label class="block mb-1 font-medium">
                                Resume File (PDF)
                            </label>
                            <input
                                type="file"
                                accept="application/pdf"
                                @change="handleFileUpload"
                            />
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Or Paste Resume Text
                            </label>
                            <textarea
                                v-model="resumeText"
                                rows="5"
                                class="w-full border rounded-md p-2"
                            ></textarea>
                        </div>
                    </form>
                </div>

                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700" />
                <!-- Job Listing Section -->
                <div>
                    <div v-if="works.length === 0" class="text-gray-500">
                        No jobs available.
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
                                    <button
                                        @click="matchJob(work.id)"
                                        class="inline-flex items-center text-sm text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md transition"
                                    >
                                        🔍 Match
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div
                    v-if="isLoading"
                    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-40"
                >
                    <div
                        class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent"
                    ></div>
                </div>

                <!-- Modal -->
                <div
                    v-if="showModal"
                    class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                >
                    <div
                        class="bg-white max-w-xl w-full rounded-lg p-6 shadow-xl relative"
                    >
                        <h2 class="text-lg font-semibold mb-4">
                            AI Match Result
                        </h2>
                        <pre
                            class="whitespace-pre-wrap text-sm text-gray-800"
                            >{{ matchResult }}</pre
                        >
                        <button
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"
                            @click="showModal = false"
                        >
                            ✖
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

const works = ref([]);
const resumeFile = ref(null);
const resumeText = ref("");

const isLoading = ref(false);
const showModal = ref(false);
const matchResult = ref("");

// Fetch job listings on load
onMounted(async () => {
    const res = await axios.get("/api/works");
    works.value = res.data;
});

// Handle file change
const handleFileUpload = (e) => {
    resumeFile.value = e.target.files[0];
};

// Match job button
const matchJob = async (workId) => {
    if (!resumeFile.value && !resumeText.value.trim()) {
        alert("Please upload your resume before matching with jobs.");
        return;
    }

    const formData = new FormData();
    formData.append("work_id", workId);

    if (resumeText.value.trim()) {
        formData.append("resume_text", resumeText.value.trim());
    } else if (resumeFile.value) {
        formData.append("resume_file", resumeFile.value);
    }

    try {
        isLoading.value = true;
        const res = await axios.post("/api/match", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        matchResult.value = res.data.result;
        showModal.value = true;
    } catch (err) {
        console.error(err);
        alert("Failed to match job. Please try again.");
    } finally {
        isLoading.value = false;
    }
};
</script>
