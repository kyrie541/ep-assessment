<template>
    <div class="max-w-2xl mx-auto py-10">
        <!-- Back button -->
        <div class="mb-6">
            <Link
                href="/works"
                class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition"
            >
                ← Back to Job Listing
            </Link>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <h2 class="text-xl font-semibold mb-6">
                {{ isEdit ? "Edit Job" : "Create Job" }}
            </h2>

            <form @submit.prevent="submit" class="space-y-5">
                <!-- Title -->
                <div>
                    <label class="block mb-1 font-medium">Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    />
                </div>

                <!-- Description -->
                <div>
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea
                        v-model="form.description"
                        rows="4"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    ></textarea>
                </div>

                <!-- Required Skills -->
                <div>
                    <label class="block mb-2 font-medium"
                        >Required Skills</label
                    >
                    <div class="flex flex-wrap gap-3">
                        <label
                            v-for="skill in allSkills"
                            :key="skill"
                            class="flex items-center gap-2 text-sm"
                        >
                            <input
                                type="checkbox"
                                :value="skill"
                                v-model="form.required_skills"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            {{ skill }}
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
                    >
                        {{ isEdit ? "Update Job" : "Create Job" }}
                    </button>
                    <Link
                        href="/works"
                        class="border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-100 transition"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import axios from "axios";
import { router, Link, usePage } from "@inertiajs/vue3";

const props = defineProps({ work: Object });
const isEdit = !!props.work;

const form = reactive({
    title: props.work?.title ?? "",
    description: props.work?.description ?? "",
    required_skills: props.work?.required_skills ?? [],
});

const allSkills = ["Laravel", "Vue", "MySQL", "Docker", "Tailwind"];

const submit = async () => {
    if (isEdit) {
        await axios.put(`/api/works/${props.work.id}`, form);
    } else {
        await axios.post("/api/works", form);
    }

    router.visit("/works");
};
</script>
