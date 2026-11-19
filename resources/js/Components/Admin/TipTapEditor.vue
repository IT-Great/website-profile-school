<script setup>
import { ref, watch, onBeforeUnmount } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import TextAlign from '@tiptap/extension-text-align'
import Underline from '@tiptap/extension-underline'
import Link from '@tiptap/extension-link'
import Placeholder from '@tiptap/extension-placeholder'
import Highlight from '@tiptap/extension-highlight'
import Subscript from '@tiptap/extension-subscript'
import Superscript from '@tiptap/extension-superscript'
import Youtube from '@tiptap/extension-youtube'
import CharacterCount from '@tiptap/extension-character-count'
import TaskList from '@tiptap/extension-task-list'
import TaskItem from '@tiptap/extension-task-item'
import { Table, TableRow, TableHeader, TableCell } from '@tiptap/extension-table'
import { TextStyle, Color } from '@tiptap/extension-text-style'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Mulai menulis artikel...',
    },
    // Endpoint yang menerima POST multipart (field "image") dan membalas JSON { url: "..." }
    uploadUrl: {
        type: String,
        default: '/upload-image',
    },
    maxImageSizeMb: {
        type: Number,
        default: 2,
    },
})

const fileInput = ref(null)
const uploading = ref(false)
const uploadError = ref('')

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        // Di Tiptap v3, StarterKit sudah menyertakan Underline & Link.
        // Dinonaktifkan di sini agar tidak duplikat dengan konfigurasi di bawah.
        StarterKit.configure({
            underline: false,
            link: false,
            heading: { levels: [1, 2, 3, 4] },
        }),
        Underline,
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                class: 'text-blue-600 underline',
                target: '_blank',
                rel: 'noopener noreferrer',
            },
        }),
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Image.configure({
            // Dukungan resize bergantung pada versi ekstensi yang terpasang.
            resize: {
                enabled: true,
                minWidth: 80,
                minHeight: 40,
                preserveAspectRatio: true,
            },
            HTMLAttributes: {
                class: 'article-image',
            },
        }),
        Placeholder.configure({
            placeholder: props.placeholder,
        }),
        TextStyle,
        Color,
        Highlight,
        Subscript,
        Superscript,
        TaskList,
        TaskItem.configure({ nested: true }),
        Table.configure({ resizable: true }),
        TableRow,
        TableHeader,
        TableCell,
        Youtube.configure({
            width: 640,
            height: 360,
            nocookie: true,
        }),
        CharacterCount,
    ],
    editorProps: {
        attributes: {
            class: 'tiptap-content focus:outline-none',
        },
        // Paste (Ctrl+V) gambar dari clipboard
        handlePaste: (view, event) => {
            const files = Array.from(event.clipboardData?.files || []).filter(
                (file) => file.type.startsWith('image/'),
            )
            if (!files.length) return false

            event.preventDefault()
            files.forEach(uploadImage)
            return true
        },
        // Drag & drop gambar ke area editor
        handleDrop: (view, event) => {
            const files = Array.from(event.dataTransfer?.files || []).filter(
                (file) => file.type.startsWith('image/'),
            )
            if (!files.length) return false

            event.preventDefault()
            files.forEach(uploadImage)
            return true
        },
    },
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML())
    },
})

watch(
    () => props.modelValue,
    (value) => {
        if (!editor.value) return

        if (value !== editor.value.getHTML()) {
            editor.value.commands.setContent(value || '', {
                emitUpdate: false,
            })
        }
    },
)

function blockValue() {
    for (const level of [1, 2, 3, 4]) {
        if (editor.value.isActive('heading', { level })) return `h${level}`
    }
    return 'p'
}

function setBlock(value) {
    const chain = editor.value.chain().focus()

    if (value === 'p') {
        chain.setParagraph().run()
    } else {
        chain.setHeading({ level: Number(value.slice(1)) }).run()
    }
}

function addLink() {
    if (!editor.value) return

    const previousUrl = editor.value.getAttributes('link').href || ''
    const url = window.prompt('Masukkan URL:', previousUrl)

    if (url === null) return

    if (url.trim() === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run()
        return
    }

    editor.value
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url.trim() })
        .run()
}

function addImage() {
    if (!editor.value) return

    const url = window.prompt('Masukkan URL gambar:')

    if (url?.trim()) {
        editor.value.chain().focus().setImage({
            src: url.trim(),
            alt: 'Article image',
        }).run()
    }
}

function pickImage() {
    uploadError.value = ''
    fileInput.value?.click()
}

function onFileChange(event) {
    const files = Array.from(event.target.files || [])
    files.forEach(uploadImage)
    event.target.value = '' // supaya file yang sama bisa dipilih ulang
}

async function uploadImage(file) {
    if (!editor.value) return

    if (!file.type.startsWith('image/')) {
        uploadError.value = 'File harus berupa gambar.'
        return
    }

    if (file.size > props.maxImageSizeMb * 1024 * 1024) {
        uploadError.value = `Ukuran gambar maksimal ${props.maxImageSizeMb} MB.`
        return
    }

    uploading.value = true
    uploadError.value = ''

    try {
        const formData = new FormData()
        formData.append('image', file)

        // CSRF Laravel: pakai meta tag jika ada, kalau tidak pakai cookie XSRF-TOKEN
        const csrfMeta = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content')

        const xsrfCookie = document.cookie
            .split('; ')
            .find((row) => row.startsWith('XSRF-TOKEN='))
            ?.split('=')[1]

        const response = await fetch(props.uploadUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...(csrfMeta ? { 'X-CSRF-TOKEN': csrfMeta } : {}),
                ...(!csrfMeta && xsrfCookie
                    ? { 'X-XSRF-TOKEN': decodeURIComponent(xsrfCookie) }
                    : {}),
            },
        })

        if (!response.ok) throw new Error(`Upload gagal (${response.status})`)

        const data = await response.json()
        if (!data.url) throw new Error('Respons server tidak berisi url.')

        editor.value
            .chain()
            .focus()
            .setImage({ src: data.url, alt: file.name })
            .run()
    } catch (error) {
        uploadError.value = error.message || 'Upload gambar gagal.'
    } finally {
        uploading.value = false
    }
}

function addYoutube() {
    if (!editor.value) return

    const url = window.prompt('Masukkan URL YouTube:')

    if (url?.trim()) {
        editor.value.chain().focus().setYoutubeVideo({ src: url.trim() }).run()
    }
}

function setAlignment(alignment) {
    editor.value?.chain().focus().setTextAlign(alignment).run()
}

function setColor(event) {
    editor.value?.chain().focus().setColor(event.target.value).run()
}

onBeforeUnmount(() => {
    editor.value?.destroy()
})
</script>

<template>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <!-- Toolbar -->
        <div
            v-if="editor"
            class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50 p-2"
        >
            <select
                class="toolbar-select"
                aria-label="Format teks"
                :value="blockValue()"
                @change="setBlock($event.target.value)"
            >
                <option value="p">Paragraph</option>
                <option value="h1">Heading 1</option>
                <option value="h2">Heading 2</option>
                <option value="h3">Heading 3</option>
                <option value="h4">Heading 4</option>
            </select>

            <div class="toolbar-sep" />

            <!-- Format teks -->
            <button
                type="button"
                title="Bold"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('bold') }"
                @click="editor.chain().focus().toggleBold().run()"
            >
                <strong>B</strong>
            </button>

            <button
                type="button"
                title="Italic"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('italic') }"
                @click="editor.chain().focus().toggleItalic().run()"
            >
                <em>I</em>
            </button>

            <button
                type="button"
                title="Underline"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('underline') }"
                @click="editor.chain().focus().toggleUnderline().run()"
            >
                <span class="underline">U</span>
            </button>

            <button
                type="button"
                title="Coret"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('strike') }"
                @click="editor.chain().focus().toggleStrike().run()"
            >
                <s>S</s>
            </button>

            <button
                type="button"
                title="Highlight"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('highlight') }"
                @click="editor.chain().focus().toggleHighlight().run()"
            >
                <mark class="rounded px-1">H</mark>
            </button>

            <label
                class="toolbar-btn relative cursor-pointer"
                title="Warna teks"
            >
                <span
                    class="border-b-2 leading-none"
                    :style="{
                        borderColor:
                            editor.getAttributes('textStyle').color || '#374151',
                    }"
                >
                    A
                </span>
                <input
                    type="color"
                    class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                    aria-label="Warna teks"
                    :value="editor.getAttributes('textStyle').color || '#374151'"
                    @input="setColor"
                />
            </label>

            <button
                type="button"
                title="Subscript"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('subscript') }"
                @click="editor.chain().focus().toggleSubscript().run()"
            >
                x<sub>2</sub>
            </button>

            <button
                type="button"
                title="Superscript"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('superscript') }"
                @click="editor.chain().focus().toggleSuperscript().run()"
            >
                x<sup>2</sup>
            </button>

            <button
                type="button"
                title="Hapus format"
                class="toolbar-btn"
                @click="editor.chain().focus().unsetAllMarks().clearNodes().run()"
            >
                Tx
            </button>

            <div class="toolbar-sep" />

            <!-- List -->
            <button
                type="button"
                title="Bullet list"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('bulletList') }"
                @click="editor.chain().focus().toggleBulletList().run()"
            >
                • List
            </button>

            <button
                type="button"
                title="Numbered list"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('orderedList') }"
                @click="editor.chain().focus().toggleOrderedList().run()"
            >
                1. List
            </button>

            <button
                type="button"
                title="Checklist"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('taskList') }"
                @click="editor.chain().focus().toggleTaskList().run()"
            >
                ☑ Tugas
            </button>

            <div class="toolbar-sep" />

            <!-- Rata teks -->
            <button
                v-for="alignment in [
                    { value: 'left', label: '⇤', title: 'Rata kiri' },
                    { value: 'center', label: '↔', title: 'Rata tengah' },
                    { value: 'right', label: '⇥', title: 'Rata kanan' },
                    { value: 'justify', label: '☰', title: 'Rata kiri-kanan' },
                ]"
                :key="alignment.value"
                type="button"
                :title="alignment.title"
                class="toolbar-btn"
                :class="{
                    'toolbar-active': editor.isActive({
                        textAlign: alignment.value,
                    }),
                }"
                @click="setAlignment(alignment.value)"
            >
                {{ alignment.label }}
            </button>

            <div class="toolbar-sep" />

            <!-- Blok -->
            <button
                type="button"
                title="Kutipan"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('blockquote') }"
                @click="editor.chain().focus().toggleBlockquote().run()"
            >
                ❝ Kutipan
            </button>

            <button
                type="button"
                title="Kode"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('codeBlock') }"
                @click="editor.chain().focus().toggleCodeBlock().run()"
            >
                &lt;/&gt;
            </button>

            <button
                type="button"
                title="Garis pemisah"
                class="toolbar-btn"
                @click="editor.chain().focus().setHorizontalRule().run()"
            >
                ―
            </button>

            <div class="toolbar-sep" />

            <!-- Sisipkan -->
            <button
                type="button"
                title="Tambah link"
                class="toolbar-btn"
                :class="{ 'toolbar-active': editor.isActive('link') }"
                @click="addLink"
            >
                Link
            </button>

            <button
                type="button"
                title="Upload gambar dari komputer"
                class="toolbar-btn"
                :disabled="uploading"
                @click="pickImage"
            >
                {{ uploading ? 'Mengunggah…' : '+ Gambar' }}
            </button>

            <button
                type="button"
                title="Tambah gambar dari URL"
                class="toolbar-btn"
                @click="addImage"
            >
                URL Gambar
            </button>

            <input
                ref="fileInput"
                type="file"
                accept="image/png,image/jpeg,image/webp,image/gif"
                multiple
                class="hidden"
                @change="onFileChange"
            />

            <button
                type="button"
                title="Tambah video YouTube"
                class="toolbar-btn"
                @click="addYoutube"
            >
                + Video
            </button>

            <button
                type="button"
                title="Tambah tabel"
                class="toolbar-btn"
                @click="
                    editor
                        .chain()
                        .focus()
                        .insertTable({ rows: 3, cols: 3, withHeaderRow: true })
                        .run()
                "
            >
                + Tabel
            </button>

            <div class="ml-auto flex gap-1">
                <button
                    type="button"
                    title="Undo"
                    class="toolbar-btn"
                    :disabled="!editor.can().undo()"
                    @click="editor.chain().focus().undo().run()"
                >
                    ↶
                </button>

                <button
                    type="button"
                    title="Redo"
                    class="toolbar-btn"
                    :disabled="!editor.can().redo()"
                    @click="editor.chain().focus().redo().run()"
                >
                    ↷
                </button>
            </div>
        </div>

        <!-- Kontrol tabel: muncul hanya saat kursor berada di dalam tabel -->
        <div
            v-if="editor && editor.isActive('table')"
            class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-white px-2 py-1.5 text-sm"
        >
            <span class="px-1 text-gray-500">Tabel:</span>
            <button type="button" class="toolbar-btn" @click="editor.chain().focus().addRowAfter().run()">+ Baris</button>
            <button type="button" class="toolbar-btn" @click="editor.chain().focus().deleteRow().run()">− Baris</button>
            <button type="button" class="toolbar-btn" @click="editor.chain().focus().addColumnAfter().run()">+ Kolom</button>
            <button type="button" class="toolbar-btn" @click="editor.chain().focus().deleteColumn().run()">− Kolom</button>
            <button type="button" class="toolbar-btn" @click="editor.chain().focus().toggleHeaderRow().run()">Header</button>
            <button type="button" class="toolbar-btn" @click="editor.chain().focus().mergeOrSplit().run()">Gabung/Pisah</button>
            <button type="button" class="toolbar-btn text-red-600" @click="editor.chain().focus().deleteTable().run()">Hapus tabel</button>
        </div>

        <p
            v-if="uploadError"
            role="alert"
            class="border-b border-red-200 bg-red-50 px-4 py-2 text-sm text-red-700"
        >
            {{ uploadError }}
        </p>

        <!-- Editor -->
        <EditorContent :editor="editor" />

        <!-- Penghitung kata -->
        <div
            v-if="editor"
            class="border-t border-gray-200 bg-gray-50 px-4 py-1.5 text-xs text-gray-500"
        >
            {{ editor.storage.characterCount.words() }} kata ·
            {{ editor.storage.characterCount.characters() }} karakter
        </div>
    </div>
</template>

<style>
.toolbar-btn {
    display: inline-flex;
    min-width: 32px;
    height: 32px;
    align-items: center;
    justify-content: center;
    padding: 0 8px;
    border: 1px solid transparent;
    border-radius: 6px;
    color: #374151;
    font-size: 13px;
    background: transparent;
    cursor: pointer;
}

.toolbar-btn:hover:not(:disabled) {
    background: #e5e7eb;
}

.toolbar-btn:focus-visible,
.toolbar-select:focus-visible {
    outline: 2px solid #2563eb;
    outline-offset: 1px;
}

.toolbar-btn.toolbar-active {
    background: #e5e7eb;
    border-color: #d1d5db;
}

.toolbar-btn:disabled {
    cursor: not-allowed;
    opacity: 0.35;
}

.toolbar-sep {
    width: 1px;
    height: 24px;
    margin: 0 4px;
    background: #d1d5db;
}

/* padding kanan lebih besar agar panah dropdown tidak menimpa teks */
.toolbar-select {
    height: 32px;
    padding: 0 32px 0 10px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background-color: #fff;
    color: #374151;
    font-size: 13px;
    cursor: pointer;
}

.tiptap-content {
    min-height: 300px;
    padding: 16px;
    color: #374151;
    line-height: 1.75;
    overflow-wrap: anywhere;
}

.tiptap-content p {
    margin: 0 0 12px;
}

.tiptap-content h1 {
    margin: 28px 0 14px;
    font-size: 1.875rem;
    font-weight: 700;
    line-height: 1.25;
}

.tiptap-content h2 {
    margin: 24px 0 12px;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.3;
}

.tiptap-content h3 {
    margin: 20px 0 10px;
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.4;
}

.tiptap-content h4 {
    margin: 16px 0 8px;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
}

.tiptap-content ul {
    list-style: disc;
    padding-left: 24px;
}

.tiptap-content ol {
    list-style: decimal;
    padding-left: 24px;
}

.tiptap-content ul[data-type='taskList'] {
    list-style: none;
    padding-left: 4px;
}

.tiptap-content ul[data-type='taskList'] li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.tiptap-content ul[data-type='taskList'] li > label {
    margin-top: 4px;
}

.tiptap-content ul[data-type='taskList'] li > div {
    flex: 1;
}

.tiptap-content blockquote {
    margin: 16px 0;
    padding-left: 16px;
    border-left: 3px solid #d1d5db;
    color: #6b7280;
}

.tiptap-content pre {
    margin: 16px 0;
    padding: 12px 16px;
    overflow-x: auto;
    border-radius: 8px;
    background: #111827;
    color: #f3f4f6;
    font-size: 0.875rem;
}

.tiptap-content code {
    border-radius: 4px;
    background: #f3f4f6;
    padding: 2px 4px;
    font-size: 0.9em;
}

.tiptap-content pre code {
    background: transparent;
    padding: 0;
}

.tiptap-content hr {
    margin: 24px 0;
    border: 0;
    border-top: 1px solid #e5e7eb;
}

.tiptap-content mark {
    background: #fef08a;
    border-radius: 3px;
    padding: 0 2px;
}

.tiptap-content img {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 6px;
}

.tiptap-content a {
    color: #2563eb;
    text-decoration: underline;
}

.tiptap-content div[data-youtube-video] {
    margin: 16px 0;
}

.tiptap-content div[data-youtube-video] iframe {
    display: block;
    width: 100%;
    max-width: 100%;
    aspect-ratio: 16 / 9;
    height: auto;
    border-radius: 8px;
}

/* Tabel */
.tiptap-content table {
    width: 100%;
    margin: 16px 0;
    border-collapse: collapse;
    table-layout: fixed;
    overflow: hidden;
}

.tiptap-content th,
.tiptap-content td {
    position: relative;
    min-width: 60px;
    padding: 8px 10px;
    border: 1px solid #d1d5db;
    vertical-align: top;
    text-align: left;
}

.tiptap-content th {
    background: #f3f4f6;
    font-weight: 600;
}

.tiptap-content .selectedCell::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(37, 99, 235, 0.12);
    pointer-events: none;
}

.tiptap-content .column-resize-handle {
    position: absolute;
    top: 0;
    right: -2px;
    bottom: 0;
    width: 4px;
    background: #2563eb;
    pointer-events: none;
}

.tiptap-content p.is-editor-empty:first-child::before {
    float: left;
    height: 0;
    color: #9ca3af;
    content: attr(data-placeholder);
    pointer-events: none;
}
</style>