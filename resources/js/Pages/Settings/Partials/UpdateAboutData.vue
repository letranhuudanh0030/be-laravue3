<template>
    <jet-form-section @submitted="updateAboutInformation">
        <template #title> About Us Information </template>

        <template #description> Update the about us section data.</template>

        <template #form>
            <!-- Photo -->
            <div class="col-span-6 sm:col-span-6" v-if="$page.props.jetstream.managesProfilePhotos">
                <AppImage label="Photo" :image-url="settings.data.about_image_url" :error-message="form.errors.about_image" v-model="form.about_image" />
            </div>

            <!-- Description -->
            <div class="col-span-6 sm:col-span-6">
                <jet-label for="description" value="Description" />
                <AppCkeditor v-model="form.about_description" />
                <jet-input-error :message="form.errors.about_description" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3"> Saved. </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Save </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import AppTextarea from '@/Components/Textarea.vue'
import AppImage from '@/Components/Image.vue'
import AppCkeditor from '@/Components/Ckeditor.vue'
import JetLabel from '@/Jetstream/Label.vue'

export default defineComponent({
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        AppTextarea,
        AppImage,
        AppCkeditor,
        JetLabel,
    },

    props: ['settings'],

    data() {
        return {
            form: this.$inertia.form({
                about_description: this.settings.data.about_description,
                about_image: null,
            }),
        }
    },

    methods: {
        updateAboutInformation() {
            // if (this.$refs.photo) {
            //     this.form.about_image = this.$refs.photo.files[0];
            // }

            this.form.post(route('settings.save-about'), {
                errorBag: 'updateAboutInformation',
                preserveScroll: true,
                // onSuccess: () => this.clearPhotoFileInput(),
            })
        },

        // clearPhotoFileInput() {
        //     if (this.$refs.photo?.value) {
        //         this.$refs.photo.value = null;
        //     }
        // },
    },
})
</script>
