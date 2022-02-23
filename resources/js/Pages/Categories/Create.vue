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

                    <!-- Check Is Parent -->
                    <div class="mt-4 flex flex-wrap items-center">
                        <jet-label value="Check is parent" class="w-full" />
                        <JetCheckbox id="isparent" v-model:checked="isParent" />
                        <label for="isparent" class="ml-2">Is Parent</label>
                    </div>

                    <!-- Category Parent -->
                    <div class="mt-4" v-if="category && !isParent">
                        <jet-label for="Parent" value="Parent" />
                        <AppSelect :data="categories.data" :inputId="'parent'" :inputClass="'w-full'" :placeholder="'Search category here...'" v-model="form.parent_id" autocomplete="off" />
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
    },

    data() {
        return {
            isParent: this.category.data.parent ? false : true,
            form: this.$inertia.form({
                name: '',
                slug: '',
                parent_id: this.edit ? this.category.data.parent : this.category.data,
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
        isParent() {
            this.form.parent_id = this.isParent ? null : this.edit ? this.category.data.parent : this.category.data
        },
    },

    methods: {
        saveCategory() {
            this.edit ? this.form.put(route('categories.update', { category: this.category.data.id })) : this.form.post(route('categories.store'))
        },
    },

    mounted() {
        if (this.edit) {
            this.form.name = this.category.data.name
            this.form.slug = this.category.data.slug
        }
    },
})
</script>
