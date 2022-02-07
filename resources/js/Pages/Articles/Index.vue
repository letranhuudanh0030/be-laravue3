<template>
    <app-layout title="Articles">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>

        <AppContainer>
            <jet-button :href="route('articles.create')">Add new</jet-button>
            <AppCard class="mt-4">
                <AppTable :headers="headers" :items="articles">
                    <tr v-for="article in articles.data" :key="article.id">
                        <td>{{ article.title }}</td>
                        <td>{{ article.category.name }}</td>
                        <td>{{ article.created_at_for_human }}</td>
                        <td class="flex items-center justify-end space-x-2">
                            <div><EditBtn :url="route('articles.edit', { article: article.id })" /></div>
                            <div><DeleteBtn :url="route('articles.destroy', { article: article.id })" module-name="article" /></div>
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
        articles: {},
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
                    name: 'Title',
                },
                {
                    name: 'Category',
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
                    label: 'Articles',
                },
            ]
        },
    },
})
</script>
