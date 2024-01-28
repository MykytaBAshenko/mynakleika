<template>
    <transition name="fade">
        <div>
            <div class="preview" v-if="showPreview">
                <b-img :src="preview.src" fluid/>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "FilePreviewFormComponent",

    props: ['bus'],

    data() {
        return {
            showPreview: false,
            preview: new Image(),
        }
    },

    created() {
        this.bus.$on('previewLoaded', (data) => {
            this.preview.src = '/storage/' + data.form.fileName + '.tn.jpg';
            this.showPreview = true;
        })

        this.bus.$on('fileChanged', () => {
            this.showPreview = false;
            this.preview = new Image();
        });
    },
}
</script>
