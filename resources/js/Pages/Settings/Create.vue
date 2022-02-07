<template>
    <app-layout title="Settings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateHeroData :settings="settings" />

                <jet-section-border />

                <UpdateAboutData :settings="settings" />

                <jet-section-border />

                <UpdateContactData :settings="settings" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateHeroData from "@/Pages/Settings/Partials/UpdateHeroData.vue";
import UpdateAboutData from "@/Pages/Settings/Partials/UpdateAboutData.vue";
import UpdateContactData from "@/Pages/Settings/Partials/UpdateContactData.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";

export default defineComponent({
    props: ["settings"],

    components: {
        AppLayout,
        UpdateHeroData,
        JetSectionBorder,
        UpdateAboutData,
        UpdateContactData,
    },
});
</script>
