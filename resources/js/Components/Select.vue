<template>
    <div class="relative" v-click-outside="clickedOutside">
        <div class="relative">
            <!-- <input type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :class="inputClass" :id="inputId" :placeholder="placeholder" :value="modelValue.name" @input="handleInput" ref="input" /> -->
            <input type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :class="inputClass" :placeholder="placeholder" v-model="chosenOption" @keyup="showOptions = true" ref="input" />
            <button type="button" class="absolute right-2 top-2/4 -translate-y-2/4" @click="toggleOptions">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="toggleOptionsIcon" />
                </svg>
            </button>
        </div>

        <div v-show="showOptions" class="absolute w-full bg-white overflow-y-auto max-h-52 shadow">
            <ul>
                <li v-for="(item, index) in searchResults" :key="index" class="px-3 py-2 cursor-pointer hover:bg-gray-200" @click="handleClick(item)">
                    {{ item.name }}
                </li>
                <li v-if="!searchResults.length" class="px-3 py-2 cursor-pointer hover:bg-gray-200">No Matching Results</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        data: {
            type: Array,
            required: true,
        },
        modelValue: {
            type: Object,
            required: false,
        },
        inputClass: {
            type: String,
            required: false,
            default: '',
        },
        inputId: {
            type: String,
            required: false,
            default: '',
        },
        placeholder: {
            type: String,
            required: false,
        },
    },

    data() {
        return {
            showOptions: false,
            chosenOption: '',
            searchTerm: '',

        }
    },

    computed: {
        toggleOptionsIcon() {
            return this.showOptions ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'
        },

        searchResults() {
            // return this.data.filter((item) => {
            //     return item.name.toLowerCase().includes(this.searchTerm.toLowerCase())
            // })
            return this.resultQuery()
        },


    },

    mounted() {
        if(this.modelValue) {
            this.chosenOption = this.modelValue.name
            this.$emit('update:modelValue', this.modelValue.id)
        }
    },

    watch: {
        chosenOption(name) {

            this.searchTerm = name
        }
    },

    methods: {

        resultQuery() {
            if (this.searchTerm) {
                return this.data.filter((item) => {
                    return this.searchTerm
                        .toLowerCase()
                        .split(' ')
                        .every((v) => item.name.toLowerCase().includes(v))
                })
            } else {
                return this.data
            }
        },

        toggleOptions() {
            this.showOptions = !this.showOptions
            this.searchTerm = ''
        },

        handleClick(item) {
            this.$emit('update:modelValue', item.id)
            this.chosenOption = item.name
            this.showOptions = false
        },

        clickedOutside() {
            this.showOptions = false

            if (!this.chosenOption) {
                this.searchTerm = ''
            }
        },

        focus() {
            this.$refs.input.focus()
        },
    },
}
</script>

<style scoped>
.mh-48 {
    max-height: 10rem;
}
</style>
