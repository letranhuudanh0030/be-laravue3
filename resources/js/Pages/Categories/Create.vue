<template>
    <app-layout title="Categories">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>
        <AppContainer>
            <AppCard class="mt-4">
                <form @submit.prevent="saveCategory">
                    <!-- Name -->
                    <div>
                        <jet-label for="name" value="Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="off" />
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- Slug -->
                    <div class="mt-4">
                        <jet-label for="slug" value="Slug" />
                        <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" autocomplete="off" />
                        <jet-input-error :message="form.errors.slug" class="mt-2" />
                    </div>

                    <!-- Category Parent -->
                    <div class="mt-4" v-if="category.data.id">
                        <jet-label for="Parent" value="Parent" />
                        <AppSelect :data="categories.data" :inputId="'parent'" :inputClass="'w-full'" :placeholder="'Search for category...'" v-model="form.parent" autocomplete="off" />

                        <!-- <AppSingleSelect
                            v-if="true"
                            name="foo"
                            option-label="name"
                            option-key="id"
                            v-model="form.parent"
                            :options="categories.data"
                            you-like-bootstrap="yes"
                            :classes="{
                                input: 'form-control',
                                wrapper: 'single-select-wrapper',
                                icon: 'icon',
                            }"
                            :required="true"
                            placeholder="find me"
                        ></AppSingleSelect> -->
                    </div>

                    <div class="mt-4">
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            <span v-if="edit">Updated.</span>
                            <span v-else>Saved.</span>
                        </jet-action-message>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <span v-if="edit">Update</span>
                            <span v-else>Save</span>
                        </jet-button>
                    </div>
                </form>
            </AppCard>
        </AppContainer>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import { strSlug } from '@/helpers.js'
import AppContainer from '@/Components/Container.vue'
import AppCard from '@/Components/Card.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'
import AppSelect from '@/Components/Select.vue'
import AppSingleSelect from '@/Components/SingleSelect.vue'

export default defineComponent({
    props: {
        categories: {},
        edit: Boolean,
        category: Object,
    },

    components: {
        AppLayout,
        JetButton,
        JetLabel,
        JetInput,
        JetInputError,
        JetActionMessage,
        AppContainer,
        AppCard,
        AppBreadcrumbs,
        JetCheckbox,
        AppSelect,
        AppSingleSelect,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                slug: '',
                parent: this.category.data,
            }),
        }
    },

    computed: {
        breadcrumbs() {
            return [
                {
                    label: 'Categories',
                    url: route('categories.index'),
                },
                {
                    label: `${this.edit ? 'Edit' : 'Add'} Category`,
                },
            ]
        },
    },

    watch: {
        'form.name'(name) {
            this.form.slug = strSlug(name)
        },
    },

    methods: {
        saveCategory() {
            this.edit ? this.form.put(route('categories.update', { id: this.category.data.id })) : this.form.post(route('categories.store'))
        },
    },

    mounted() {
        if (this.edit) {
            this.form.name = this.category.data.name
            this.form.slug = this.category.data.slug
            this.form.parent = this.category.data
        }
    },
})
</script>
