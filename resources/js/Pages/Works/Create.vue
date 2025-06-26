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

        <WorkForm />
    </div>
</template>

<script setup>
import WorkForm from "./Form.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>
