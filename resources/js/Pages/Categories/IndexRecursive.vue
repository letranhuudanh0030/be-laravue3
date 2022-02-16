<template>
    <app-layout title="Categories">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>

        <AppContainer>
            <jet-button @click="toggleAddCategory()">{{ labelAddCategory }}</jet-button>
            <AppCard class="mt-4">
                <div class="flex items-center justify-between w-full h-10 bg-gray-300 mb-2 px-4">
                    <div class="uppercase font-bold">Categories List</div>
                    <Link :href="route('categories.create.recursive')" v-tooltip:top.tooltip="'Add Category'" v-show="showAddCategory">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </Link>
                </div>
                <Category v-for="category in categories.data" :key="category.id" :category="category" :items="categories" :showAddCategory="showAddCategory" />
                <div v-if="categories.data.length > 0 && !recursive" class="mt-4">
                    <SimplePagination :prevUrl="categories.links.prev" :nextUrl="categories.links.next" />
                </div>
            </AppCard>
        </AppContainer>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import AppTable from '@/Components/Table.vue'
import JetButton from '@/Jetstream/Button.vue'
import AppContainer from '@/Components/Container.vue'
import AppCard from '@/Components/Card.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'
import Category from '@/Pages/Categories/Partials/Category.vue'
import SimplePagination from '@/Components/SimplePagination.vue'

export default defineComponent({
    props: {
        categories: {},
    },

    data() {
        return {
            showAddCategory: false,
            labelAddCategory: 'Add New',
        }
    },

    components: {
        AppLayout,
        AppTable,
        JetButton,
        AppContainer,
        AppCard,
        AppBreadcrumbs,
        Category,
        SimplePagination,
    },

    computed: {
        headers() {
            return [
                {
                    name: 'ID',
                },
                {
                    name: 'Name',
                },
                {
                    name: 'Created Date',
                },
                {
                    name: 'Actions',
                    class: 'text-right',
                },
            ]
        },
        breadcrumbs() {
            return [
                {
                    label: 'Categories Recursive',
                },
            ]
        },
    },

    methods: {
        toggleAddCategory() {
            this.showAddCategory = !this.showAddCategory
            this.showAddCategory ? (this.labelAddCategory = 'Cancel Add New') : (this.labelAddCategory = 'Add New')
        },
    },
})
</script>
