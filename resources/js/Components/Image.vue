<template>
    <div>
        <!-- Profile Photo File Input -->
        <input
            type="file"
            class="hidden"
            ref="photo"
            @change="updatePhotoPreview"
        />

        <jet-label for="photo" :value="label" />

        <!-- Current Profile Photo -->
        <div class="mt-2" v-show="!photoPreview">
            <img
                :src="imageUrl"
                alt="Current Photo"
                class="rounded-full h-20 w-20 object-cover"
            />
        </div>

        <!-- New Profile Photo Preview -->
        <div class="mt-2" v-show="photoPreview">
            <span
                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                :style="'background-image: url(\'' + photoPreview + '\');'"
            >
            </span>
        </div>

        <jet-secondary-button
            class="mt-2 mr-2"
            type="button"
            @click.prevent="selectNewPhoto"
        >
            Select A New Photo
        </jet-secondary-button>

        <jet-input-error :message="errorMessage" class="mt-2" />
    </div>
</template>

<script>
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInputError from "@/Jetstream/InputError.vue";

export default {
    components: {
        JetLabel,
        JetSecondaryButton,
        JetInputError,
    },

    props: {
        imageUrl: {},
        label: {},
        errorMessage: {},
    },

    data() {
        return {
            photoPreview: null,
        };
    },

    methods: {
        updatePhotoPreview() {
            const photo = this.$refs.photo.files[0];

            if (!photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(photo);

            this.$emit("update:modelValue", photo);
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },
    },
};
</script>

<style></style>
