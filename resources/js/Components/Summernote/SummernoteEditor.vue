<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import $ from 'jquery';

import 'summernote/dist/summernote-bs5.css';
import 'summernote/dist/summernote-bs5.js';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },

    height: {
        type: Number,
        default: 400,
    },

    placeholder: {
        type: String,
        default: 'Write your article content here...',
    },
});

const emit = defineEmits(['update:modelValue']);

const editor = ref(null);

let isUpdating = false;

const initializeSummernote = () => {
    $(editor.value).summernote({
        height: props.height,

        placeholder: props.placeholder,

        minHeight: 300,

        dialogsInBody: true,

        toolbar: [
            ['style', ['style']],

            [
                'font',
                [
                    'bold',
                    'italic',
                    'underline',
                    'clear',
                ],
            ],

            [
                'fontname',
                ['fontname'],
            ],

            [
                'fontsize',
                ['fontsize'],
            ],

            [
                'color',
                ['color'],
            ],

            [
                'para',
                [
                    'ul',
                    'ol',
                    'paragraph',
                ],
            ],

            [
                'height',
                ['height'],
            ],

            [
                'insert',
                [
                    'link',
                    'picture',
                    'video',
                    'table',
                    'hr',
                ],
            ],

            [
                'view',
                [
                    'fullscreen',
                    'codeview',
                    'help',
                ],
            ],
        ],

        callbacks: {

            onChange: function (contents) {
                if (!isUpdating) {
                    emit('update:modelValue', contents);
                }
            },

            onImageUpload: function (files) {
                uploadImages(files);
            },
        },
    });

    $(editor.value).summernote(
        'code',
        props.modelValue || ''
    );
};

const uploadImages = async (files) => {

    for (const file of files) {

        const formData = new FormData();

        formData.append('image', file);

        try {

            const response = await window.axios.post(
                route('admin.posts.upload-image'),
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }
            );

            if (
                response.data &&
                response.data.success &&
                response.data.url
            ) {

                $(editor.value).summernote(
                    'insertImage',
                    response.data.url
                );

            }

        } catch (error) {

            console.error(
                'Image upload failed:',
                error
            );

            if (error.response?.data?.message) {
                alert(error.response.data.message);
            } else {
                alert('Failed to upload image.');
            }
        }
    }
};

watch(
    () => props.modelValue,
    (newValue) => {

        if (!editor.value) {
            return;
        }

        const currentValue =
            $(editor.value).summernote('code');

        if (newValue !== currentValue) {

            isUpdating = true;

            $(editor.value).summernote(
                'code',
                newValue || ''
            );

            isUpdating = false;
        }
    }
);

onMounted(() => {
    initializeSummernote();
});

onBeforeUnmount(() => {
    if (editor.value) {
        $(editor.value).summernote('destroy');
    }
});

</script>

<template>

    <div class="summernote-wrapper">

        <textarea
            ref="editor"
            class="hidden"
        ></textarea>

    </div>

</template>

<style>
/* Summernote container */

.summernote-wrapper .note-editor {
    border-radius: 0.75rem;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

/* Toolbar */

.summernote-wrapper .note-toolbar {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

/* Editing area */

.summernote-wrapper .note-editable {
    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;

    font-size: 15px;

    line-height: 1.7;

    color: #334155;
}

/* Placeholder */

.summernote-wrapper .note-placeholder {
    color: #94a3b8;
}

/* Images */

.summernote-wrapper .note-editable img {
    max-width: 100%;
}

/* Code view */

.summernote-wrapper .note-codable {
    font-family:
        "Fira Code",
        Consolas,
        monospace;

    font-size: 13px;
}
</style>