<template>
    <div ref="vuesingleselect">
        <div v-if="!selectedOption" :class="classes.wrapper">
            <div class="relative inline-block w-full">
                <input ref="search" :class="[classes.input, isRequired]" tabindex="0" :id="inputId" @click="seedSearchText" @focus="seedSearchText" @keyup.esc="closeOut" @keyup.enter="selectPossibileMatch($event)" @keyup.down="movePointerDown($event)" :placeholder="placeholder" autocomplete="off" :required="required" v-model="searchText" />

                <div @click="toggleOpenSelect" :class="[classes.icon]" class="cursor-pointer absolute flex items-center">
                    <svg v-if="!openSelect" aria-hidden="true" viewBox="0 0 448 512">
                        <path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path>
                    </svg>
                    <svg v-else aria-hidden="true" viewBox="0 0 448 512">
                        <path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path>
                    </svg>
                </div>

                <ul tabindex="-1" ref="options" v-if="matchingOptions" :style="{ 'max-height': maxHeight }" style="z-index: 100;padding" class="shadow-md absolute w-full overflow-auto appearance-none border rounded mt-px text-grey-darker border-grey-lighter bg-white list-reset leading-normal text-left">
                    <li tabindex="0" v-for="(option, idx) in matchingOptions" :key="idx" :class="{ 'is-active': idx === pointer }" class="cursor-pointer px-1 py-2 outline-none" @mouseover="pointer = idx" @keyup.enter="setOption(option)" @keyup.shift.tab.exact="movePointerUp" @keyup.tab.exact="movePointerDown($event)" @keyup.up="movePointerUp()" @keyup.down="movePointerDown($event)" @click.prevent="setOption(option)" @keyup.esc="closeOut" v-text="optionDesciption(option)"></li>
                </ul>
            </div>
        </div>

        <div :class="classes.wrapper" v-if="selectedOption">
            <input id="inputId" :name="name" :class="[classes.input]" ref="match" :required="required" @input="switchToSearch($event)" @click="switchToSearch($event)" :placeholder="placeholder" :value="optionDesciption(selectedOption)" />

            <div :class="classes.icon" @click="closeOut" class="cursor-pointer absolute flex items-center">
                <svg @click="closeOut" aria-hidden="true" viewBox="0 0 512 512">
                    <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            required: true,
        },
        name: {
            type: String,
            required: false,
            default: () => '',
        },
        options: {
            type: Array,
            required: false,
            default: () => [],
        },
        optionLabel: {
            type: String,
            required: false,
            default: () => null,
        },
        optionKey: {
            type: String,
            required: false,
            default: () => null,
        },
        placeholder: {
            type: String,
            required: false,
            default: () => 'Search Here',
        },
        maxHeight: {
            type: String,
            default: () => '220px',
            required: false,
        },
        inputId: {
            type: String,
            default: () => 'single-select',
            required: false,
        },
        classes: {
            type: Object,
            required: false,
            default: () => {
                return {
                    wrapper: 'single-select-wrapper',
                    input: 'form-control',
                    icon: 'icon',
                    required: 'required',
                }
            },
        },
        initial: {
            type: String,
            required: false,
            default: () => null,
        },
        required: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        maxResults: {
            type: Number,
            required: false,
            default: () => 30,
        },
    },
    mounted() {
        document.addEventListener('keyup', this.handleClickOutside)
        document.addEventListener('click', this.handleClickOutside)
        this.searchText = this.initial
    },
    destroyed() {
        document.removeEventListener('keyup', this.handleClickOutside)
        document.removeEventListener('click', this.handleClickOutside)
    },
    data() {
        return {
            searchText: null,
            selectedOption: null,
            openSelect: false,
            pointer: -1,
            closed: false,
        }
    },
    watch: {
        searchText(curr, prev) {
            if (curr !== prev) {
                this.pointer = -1
            }
            this.closed = false
        },
        selectedOption(curr, prev) {
            if (curr === prev) {
                return
            }

            this.$emit('input', curr)

            if (this.closed) {
                return
            }
            if (curr) {
                return
            }

            this.$nextTick().then(() => {
                this.$refs.search.focus()
            })
        },
        openSelect(curr, prev) {
            if (curr === prev) {
                return
            }

            if (this.selectedOption) {
                this.searchText = this.optionDesciption(this.selectedOption)
                return
            }

            if (!curr) {
                this.searchText = null
                return
            }

            if (!this.searchText) {
                this.searchText = ''
            }
            this.$nextTick().then(() => {
                this.$refs.search.focus()
            })
        },
    },
    computed: {
        isRequired() {
            if (!this.required) {
                return ''
            }

            if (!this.closed) {
                return ''
            }

            return 'required'
        },
        matchingOptions() {
            if (this.searchText === null) {
                return null
            }

            if (!this.searchText.length) {
                return [...this.options].slice(0, this.maxResults)
            }

            if (this.optionLabel && this.optionKey) {
                return this.options
                    .filter((option) => {
                        return option[this.optionLabel].toString().toLowerCase().includes(this.searchText.toString().toLowerCase()) || this.searchText.toString().toLowerCase().includes(option[this.optionKey].toString().toLowerCase())
                    })
                    .slice(0, this.maxResults)
            }

            if (this.optionLabel) {
                return this.options.filter((option) => option[this.optionLabel].toString().toLowerCase().includes(this.searchText.toString().toLowerCase())).slice(0, this.maxResults)
            }

            if (this.optionKey) {
                return this.options.filter((option) => this.searchText.toString().toLowerCase().includes(option[this.optionKey].toString().toLowerCase())).slice(0, this.maxResults)
            }

            return this.options.filter((option) => option.toString().toLowerCase().includes(this.searchText.toString().toLowerCase())).slice(0, this.maxResults)
        },
    },
    methods: {
        seedSearchText() {
            if (!this.searchText) {
                this.searchText = ''
            }

            this.$nextTick().then(() => {
                this.closed = false
            })
        },
        resetSearch() {
            this.selectedOption = null
            this.openSelect = false
            this.searchText = null
        },
        switchToSearch(event) {
            this.searchText = event.target.value
            this.selectedOption = null
            this.$nextTick().then(() => {
                this.$refs.search.focus()
            })
        },
        selectPossibileMatch() {
            if (this.matchingOptions.length) {
                this.setOption(0)
            }
        },
        toggleOpenSelect() {
            this.openSelect = !this.openSelect
        },
        closeOut() {
            this.selectedOption = null
            this.openSelect = false
            this.searchText = null
            this.closed = true
        },
        movePointerDown(event) {
            if (this.pointer >= this.matchingOptions.length - 1) {
                return
            }
            this.pointer++

            if (event.target.tagName === 'INPUT') {
                this.$refs.options.firstElementChild.focus()
                return
            }

            event.target.focus()
        },
        movePointerUp() {
            if (this.pointer > 0) {
                this.pointer--
            }
        },
        setOption(option) {
            if (typeof this.matchingOptions[this.pointer] === 'undefined') {
                return
            }
            this.selectedOption = this.matchingOptions[this.pointer]
            this.searchText = null
            this.openSelect = false
            this.pointer = -1
            this.$nextTick().then(() => {
                this.$refs.match.focus()
            })
        },
        optionDesciption(option) {
            if (this.optionKey && this.optionLabel) {
                return option[this.optionKey] + ' ' + option[this.optionLabel]
            }
            if (this.optionLabel) {
                return option[this.optionLabel]
            }
            if (this.optionKey) {
                return option[this.optionKey]
            }

            return option
        },
        handleClickOutside(e) {
            if (!this.$el.contains(e.target)) {
                this.closeOut()
            }
        },
    },
}
</script>

<style></style>
