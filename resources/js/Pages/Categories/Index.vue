<template>
    <app-layout title="Categories">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>

        <AppContainer>
            <jet-button :href="route('categories.create')">Add new</jet-button>
            <AppCard class="mt-4">
                <AppTable :headers="headers" :items="categories">
                    <tr v-for="category in categories.data" :key="category.id">
                        <td>{{ category.name }}</td>
                        <td>{{ category.created_at_for_human }}</td>
                        <td class="flex items-center justify-end space-x-2">
                            <div><EditBtn :url="route('categories.edit', { category: category.id })" /></div>
                            <div><DeleteBtn :url="route('categories.destroy', { category: category.id })" module-name="category" /></div>
                        </td>
                    </tr>
                </AppTable>
            </AppCard>
        </AppContainer>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import EditBtn from '@/Components/EditBtn.vue'
import DeleteBtn from '@/Components/DeleteBtn.vue'
import AppTable from '@/Components/Table.vue'
import JetButton from '@/Jetstream/Button.vue'
import AppContainer from '@/Components/Container.vue'
import AppCard from '@/Components/Card.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'

export default defineComponent({
    props: {
        categories: {},
    },
    components: {
        AppLayout,
        EditBtn,
        DeleteBtn,
        AppTable,
        JetButton,
        AppContainer,
        AppCard,
        AppBreadcrumbs,
    },

    computed: {
        headers() {
            return [
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
                    label: 'Categories',
                },
            ]
        },
    },
})
</script>
