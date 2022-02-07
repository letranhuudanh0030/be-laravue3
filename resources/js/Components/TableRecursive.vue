<template>
    <table>
        <thead>
            <tr>
                <th v-for="(header, index) in headers" :key="`header-${index}`" :class="header.class || 'text-left'">{{ header.name }}</th>
            </tr>
        </thead>
        <slot></slot>
        <!-- <tbody>
            <tr v-if="items.data.length === 0">
                <td class="p-4" :colspan="headers.length">No data available.</td>
            </tr>
        </tbody> -->
    </table>
    <div v-if="items.data.length > 0 && !recursive" class="mt-4">
        <SimplePagination :prevUrl="items.links.prev" :nextUrl="items.links.next" />
    </div>
</template>

<script>
import SimplePagination from '@/Components/SimplePagination.vue'
export default {
    components: {
        SimplePagination,
    },
    props: {
        headers: {
            required: true,
            type: Array,
        },
        items: {
            required: true,
            type: Object,
        },
        recursive: false,
    },
}
</script>

<style></style>
