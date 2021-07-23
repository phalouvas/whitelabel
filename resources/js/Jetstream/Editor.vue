<template>
<div>
    <div v-if="editor" class="border">
      <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-bold"></i>
      </button>
      <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-italic"></i>
      </button>
      <button @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-strikethrough"></i>
      </button>
      <button @click="editor.chain().focus().toggleCode().run()" :class="{ 'is-active': editor.isActive('code') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-code"></i>
      </button>
      <button @click="editor.chain().focus().unsetAllMarks().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        clear marks
      </button>
      <button @click="editor.chain().focus().clearNodes().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        clear nodes
      </button>
      <button @click="editor.chain().focus().setParagraph().run()" :class="{ 'is-active': editor.isActive('paragraph') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-paragraph"></i>
      </button>
      <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h1
      </button>
      <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h2
      </button>
      <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h3
      </button>
      <button @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h4
      </button>
      <button @click="editor.chain().focus().toggleHeading({ level: 5 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h5
      </button>
      <button @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h6
      </button>
      <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-list"></i>
      </button>
      <button @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-list-ol"></i>
      </button>
      <button @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'is-active': editor.isActive('codeBlock') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-code"></i>
      </button>
      <button @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }" class="w-6 text-gray-500 hover:bg-gray-300">
        blockquote
      </button>
      <button @click="editor.chain().focus().setHorizontalRule().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-ruler-horizontal"></i>
      </button>
      <button @click="editor.chain().focus().setHardBreak().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        hard break
      </button>
      <button @click="editor.chain().focus().undo().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-undo"></i>
      </button>
      <button @click="editor.chain().focus().redo().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-redo"></i>
      </button>
    </div>
  <editor-content class="border p-3" :editor="editor" />
</div>
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

export default {
  components: {
    EditorContent,
  },

  props: {
    modelValue: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      editor: null,
    }
  },

  watch: {
    modelValue(value) {
      const isSame = this.editor.getHTML() === value

      if (isSame) {
        return
      }

      this.editor.commands.setContent(this.modelValue, false)
    },
  },

  mounted() {
    this.editor = new Editor({
      content: this.modelValue,
      extensions: [
        StarterKit,
      ],
      onUpdate: () => {
        this.$emit('update:modelValue', this.editor.getHTML())
      },
    })
  },

  beforeUnmount() {
    this.editor.destroy()
  },
}
</script>
