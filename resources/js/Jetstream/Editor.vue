<template>
<div>
    <div v-if="editor" class="border">
      <button title="Bold" @click="editor.chain().focus().toggleBold().run()" :class="{ 'text-yellow-500': editor.isActive('bold') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-bold"></i>
      </button>
      <button title="Italic" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'text-yellow-500': editor.isActive('italic') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-italic"></i>
      </button>
      <button title="Strike through" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'text-yellow-500': editor.isActive('strike') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-strikethrough"></i>
      </button>
      <button title="Code" @click="editor.chain().focus().toggleCode().run()" :class="{ 'text-yellow-500': editor.isActive('code') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-code"></i>
      </button>
      <button title="Unset All Marks" @click="editor.chain().focus().unsetAllMarks().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-minus"></i>
      </button>
      <button title="Clear Nodes" @click="editor.chain().focus().clearNodes().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-remove-format"></i>
      </button>
      <button title="Paragraph" @click="editor.chain().focus().setParagraph().run()" :class="{ 'text-yellow-500': editor.isActive('paragraph') }" class="w-6 text-gray-500 hover:bg-gray-300">
        p
      </button>
      <button title="Heading 1" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'text-yellow-500': editor.isActive('heading', { level: 1 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h1
      </button>
      <button title="Heading 2" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'text-yellow-500': editor.isActive('heading', { level: 2 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h2
      </button>
      <button title="Heading 3" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'text-yellow-500': editor.isActive('heading', { level: 3 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h3
      </button>
      <button title="4" @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'text-yellow-500': editor.isActive('heading', { level: 4 }) }" class="w-6 text-gray-500 hover:bg-gray-300">
        h4
      </button>
      <button title="Bullet List" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'text-yellow-500': editor.isActive('bulletList') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-list"></i>
      </button>
      <button title="Number List" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'text-yellow-500': editor.isActive('orderedList') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-list-ol"></i>
      </button>
      <button title="Code Block" @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'text-yellow-500': editor.isActive('codeBlock') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-code"></i>
      </button>
      <button title="Block Quote" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'text-yellow-500': editor.isActive('blockquote') }" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-quote-right"></i>
      </button>
      <button title="Horizonal Line" @click="editor.chain().focus().setHorizontalRule().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-ruler-horizontal"></i>
      </button>
      <button title="Hard Break" @click="editor.chain().focus().setHardBreak().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-plus"></i>
      </button>
      <button title="Undo" @click="editor.chain().focus().undo().run()" class="w-6 text-gray-500 hover:bg-gray-300">
        <i class="fas fa-undo"></i>
      </button>
      <button title="Redo" @click="editor.chain().focus().redo().run()" class="w-6 text-gray-500 hover:bg-gray-300">
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
      editorProps: {
            attributes: {
            class:
                "prose prose-sm sm:prose lg:prose-lg xl:prose-2xl m-5 focus:outline-none"
            }
        },
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
