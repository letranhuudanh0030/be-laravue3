<template>
    <app-layout title="Articles">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>

        <AppContainer>
            <div class="flex items-center justify-between">
                <jet-button v-if="!category" :href="route('articles.create')">Add new</jet-button>
                <jet-button v-else :href="route('articles.create-by-category', { category: category.data.id })">Add new</jet-button>
                <h2 v-if="category" class="font-bold text-2xl text-gray-800 leading-tight ml-4 uppercase">
                    Category: <span class="text-indigo-500">{{ category.data.name }}</span>
                </h2>
                <jet-input id="search" type="text" v-model="searchTerm" @keyup="search" placeholder="Search here..." autocomplete="search" />
            </div>
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
import JetInput from '@/Jetstream/Input.vue'
import AppContainer from '@/Components/Container.vue'
import AppCard from '@/Components/Card.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'

export default defineComponent({
    props: {
        articles: {},
        category: {},
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
        JetInput,
    },

    data() {
        return {
            searchTerm: '',
            typing: false,
        }
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

        searchResults() {
            return this.articles.data.filter((article) => article.title.toLowerCase().includes(this.searchTerm.toLowerCase()))
        },
    },

    methods: {
        search: _.debounce(function () {
            this.$inertia.replace(route('articles.search', { searchTerm: this.searchTerm }))
        }, 300),
    },
})
</script>
