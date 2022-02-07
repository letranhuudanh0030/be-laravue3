<template>
    <app-layout title="Articles">
        <template #header>
            <AppBreadcrumbs :items="breadcrumbs" />
        </template>
        <AppContainer>
            <AppCard class="mt-4">
                <form @submit.prevent="saveArticle">
                    <!-- Image -->
                    <div class="mt-2">
                        <AppImage label="Image" :image-url="imageUrl" :error-message="form.errors.image" v-model="form.image" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <jet-label for="category" value="Category" />
                        <select name="category" id="category" class="block w-full form-input" v-model="form.category_id">
                            <option value="">Select</option>
                            <option v-for="category in categories.data" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <jet-input-error :message="form.errors.category_id" class="mt-2" />
                    </div>

                    <!-- Title -->
                    <div class="mt-4">
                        <jet-label for="title" value="Title" />
                        <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                        <jet-input-error :message="form.errors.title" class="mt-2" />
                    </div>

                    <!-- Slug -->
                    <div class="mt-4">
                        <jet-label for="slug" value="Slug" />
                        <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" autocomplete="slug" />
                        <jet-input-error :message="form.errors.slug" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <jet-label for="description" value="Description" />
                        <AppCkeditor v-model="form.description" />
                        <jet-input-error :message="form.errors.description" class="mt-2" />
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
import JetInputError from '@/Jetstream/InputError.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import { strSlug } from '@/helpers.js'
import AppContainer from '@/Components/Container.vue'
import AppCard from '@/Components/Card.vue'
import AppBreadcrumbs from '@/Components/Breadcrumbs.vue'
import AppCkeditor from '@/Components/Ckeditor.vue'
import AppImage from '@/Components/Image.vue'

export default defineComponent({
    props: {
        categories: {
            type: Object,
            default: function () {
                return {
                    data: [],
                }
            },
        },
        edit: Boolean,
        article: Object,
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
        AppCkeditor,
        AppImage,
    },

    data() {
        return {
            imageUrl: '',
            form: this.$inertia.form({
                _method: this.edit ? 'PUT' : '',
                category_id: '',
                image: '',
                title: '',
                slug: '',
                description: this.edit ? this.article.data.description : '',
            }),
        }
    },

    computed: {
        breadcrumbs() {
            return [
                {
                    label: 'Articles',
                    url: route('articles.index'),
                },
                {
                    label: `${this.edit ? 'Edit' : 'Add'} Article`,
                },
            ]
        },
    },

    watch: {
        'form.title'(title) {
            if (this.edit) return

            this.form.slug = strSlug(title)
        },
    },

    methods: {
        saveArticle() {
            this.edit ? this.form.put(route('articles.update', { id: this.article.data.id })) : this.form.post(route('articles.store'))
        },
    },

    mounted() {
        if (this.edit) {
            this.form.category_id = this.article.data.category_id
            this.form.title = this.article.data.title
            this.form.slug = this.article.data.slug
        }
        this.imageUrl = this.article.data.image_url
    },
})
</script>
