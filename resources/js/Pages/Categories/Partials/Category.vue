<template>
    <div>
        <div class="flex items-center w-full">
            <svg v-if="category.is_child" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" :style="cateMargin">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
            </svg>
            <div class="flex flex-1 justify-between bg-gray-100 hover:bg-gray-200 border shadow rounded py-3 px-4 mb-2">
                <div class="">
                    <span class="font-bold mr-2">{{ category.name }}</span>
                    <span class="text-gray-500">( {{ category.created_at_for_human }} )</span>
                </div>
                <div class="flex items-center justify-end space-x-2">
                    <div><EditBtn :url="route('categories.edit', { category: category.id })" /></div>
                    <div><DeleteBtn :url="route('categories.destroy', { category: category.id })" module-name="category" /></div>
                    <button type="button" class="" v-if="hasChildren" @click="toggleChildren" @keypress="toggleChildren">
                        <span class="sr-only">Dropdown</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="toggleChildrenIcon" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="hasChildren" v-show="showChildren">
            <Category v-for="category in category.children" :key="category.id" :category="category" :spacing="spacing + 50" />
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
