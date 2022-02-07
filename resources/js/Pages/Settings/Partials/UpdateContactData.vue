<template>
    <jet-form-section @submitted="updateContactInformation">
        <template #title> Contact Us Information </template>

        <template #description> Update the contact section data.</template>

        <template #form>
            <!-- Photo -->
            <div class="col-span-6 sm:col-span-6" v-if="$page.props.jetstream.managesProfilePhotos">
                <AppImage label="Photo" :image-url="settings.data.contact_image_url" :error-message="form.errors.contact_image" v-model="form.contact_image" />
            </div>

            <!-- Address -->
            <div class="col-span-6 sm:col-span-6">
                <jet-label for="address" value="Address" />
                <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" autocomplete="address" />
                <jet-input-error :message="form.errors.address" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="col-span-6 sm:col-span-6">
                <jet-label for="phone" value="Phone" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" autocomplete="phone" />
                <jet-input-error :message="form.errors.phone" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-6">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" autocomplete="email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Google Map Url -->
            <div class="col-span-6 sm:col-span-6">
                <jet-label for="google_map_url" value="Google Map Url" />
                <AppTextarea id="google_map_url" type="text" class="mt-1 block w-full" v-model="form.google_map_url" autocomplete="google_map_url" />
                <jet-input-error :message="form.errors.google_map_url" class="mt-2" />
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
        JetLabel,
    },

    props: ['settings'],

    data() {
        return {
            form: this.$inertia.form({
                address: this.settings.data.address,
                phone: this.settings.data.phone,
                email: this.settings.data.email,
                google_map_url: this.settings.data.google_map_url,
                contact_image: null,
            }),
        }
    },

    methods: {
        updateContactInformation() {
            // if (this.$refs.photo) {
            //     this.form.contact_image = this.$refs.photo.files[0];
            // }

            this.form.post(route('settings.save-contact'), {
                errorBag: 'updateContactInformation',
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
