<template>
    <div
        v-if="$page.props.flash.success || $page.props.flash.failure"
        class="fixed bottom-4 right-4 items-center text-white rounded px-8 py-4 flex items-center"
        :class="{
            'bg-green-500': $page.props.flash.success,
            'bg-red-500': $page.props.flash.failure,
        }"
    >
        <div v-if="$page.props.flash.success">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash.failure">
            {{ $page.props.flash.failure }}
        </div>
        <div class="ml-4 cursor-pointer" @click="hideFlashMessage">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            timerInterval: null,
        }
    },

    mounted() {
        this.timerInterval = setTimeout(() => {
            this.$page.props.flash.success = ''
            this.$page.props.flash.failure = ''
        }, 3000)
    },

    unmounted() {
        clearTimeout(this.timerInterval)
    },

    methods: {
        hideFlashMessage() {
            this.$page.props.flash.success = ''
            this.$page.props.flash.failure = ''
        },
    },
}
</script>

<style></style>
