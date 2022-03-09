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
                    <div class="px-4">
                        <button class="bg-gray-400 px-6 py-2 round " @click="toggle">Toggle</button>
                        <Welcome v-if="show" />
                    </div>
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

    data() {
        return {
            show: false
        }
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
    methods: {
        toggle() {
            this.show = !this.show
        }
    }
})
</script>
