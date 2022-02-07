<template>
    <app-layout title="Dashboard">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <welcome /> -->
                    The dashboard page content
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
        AppBreadcrumbs,
    },
    computed: {
        breadcrumbs() {
            return [
                {
                    label: 'Dashboard',
                },
            ]
        },
    },
})
</script>
