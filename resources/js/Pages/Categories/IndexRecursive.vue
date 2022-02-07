<template>
    <app-layout title="Categories">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>

        <AppContainer>
            <jet-button :href="route('categories.create')">Add new</jet-button>
            <AppCard class="mt-4">
                <!-- <AppTable :headers="headers" :items="categories" :recursive="true"> -->
                    <Category v-for="category in categories.data" :key="category.id" :category="category"/>
                <!-- </AppTable> -->
            </AppCard>
        </AppContainer>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
// import EditBtn from '@/Components/EditBtn.vue'
// import DeleteBtn from '@/Components/DeleteBtn.vue'
// import AppTable from '@/Components/Table.vue'
import AppTable from '@/Components/Table.vue'
import JetButton from '@/Jetstream/Button.vue'
import AppContainer from '@/Components/Container.vue'
import AppCard from '@/Components/Card.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'
import Category from '@/Pages/Categories/Partials/Category.vue'

export default defineComponent({
    props: {
        categories: {},
    },
    components: {
        AppLayout,
        // EditBtn,
        // DeleteBtn,
        AppTable,
        JetButton,
        AppContainer,
        AppCard,
        AppBreadcrumbs,
        Category
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
})
</script>
