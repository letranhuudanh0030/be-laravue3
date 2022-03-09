<template>
    <div>
        <div class="flex items-center w-full">
            <svg v-if="category.is_child" xmlns="http://www.w3.org/2000/svg" class="h-6 w-5 mr-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" :style="cateMargin">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
            </svg>
            <div class="flex flex-1 justify-between bg-gray-100 hover:bg-gray-200 border shadow rounded py-3 px-4 mb-2">
                <div class="">
                    <span class="font-bold mr-2">{{ category.name }}</span>
                    <span class="text-gray-500">( {{ category.articles_count }} Articles | {{ category.created_at_for_human }} | Sort order: {{ category.sort_order }} )</span>
                </div>
                <div class="flex items-center justify-end space-x-2">
                    <Link :href="route('categories.create.recursive', { category: category.id })" v-tooltip:top.tooltip="'Add Child Category'" v-show="showAddCategory">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </Link>
                    <Link :href="route('categories.create.recursive', { category: category.id })" v-tooltip:top.tooltip="'Add Below Category'" v-show="showAddCategory">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                    </Link>

                    <Link :href="route('articles.show-by-category', { category: category.id })" v-tooltip:top.tooltip="'Show Articles'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </Link>
                    <div>
                        <EditBtn :url="route('categories.edit', { category: category.id })" v-tooltip:top.tooltip="'Edit Category'" />
                    </div>
                    <div>
                        <DeleteBtn :url="route('categories.destroy', { category: category.id })" module-name="category" v-tooltip:top.tooltip="'Delete Category'" />
                    </div>

                    <button v-tooltip:top.tooltip="'Move'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                        </svg>
                    </button>

                    <button type="button" class="" v-if="hasChildren" @click="toggleChildren" @keypress="toggleChildren" v-tooltip:top.tooltip="'DropDown'">
                        <span class="sr-only">Dropdown</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="toggleChildrenIcon" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="hasChildren" v-show="showChildren">
            <Category v-for="category in category.children" :key="category.id" :category="category" :spacing="spacing + 50" :showAddCategory="showAddCategory" />
        </div>
    </div>
</template>

<script>
import EditBtn from '@/Components/EditBtn.vue'
import DeleteBtn from '@/Components/DeleteBtn.vue'

export default {
    components: {
        EditBtn,
        DeleteBtn,
    },

    props: {
        categories: {},
        category: Object,
        showAddCategory: {},
        spacing: {
            type: Number,
            default: 0,
        },
    },

    data() {
        return {
            showChildren: false,
        }
    },

    computed: {
        cateMargin() {
            return {
                'margin-left': `${this.spacing}px`,
            }
        },

        hasChildren() {
            const { children } = this.category
            return children && children.length > 0
        },

        toggleChildrenIcon() {
            return this.showChildren ? 'M19 9l-7 7-7-7' : 'M9 5l7 7-7 7'
        },
    },

    methods: {
        toggleChildren() {
            this.showChildren = !this.showChildren
        },
    },
}
</script>

<style></style>
