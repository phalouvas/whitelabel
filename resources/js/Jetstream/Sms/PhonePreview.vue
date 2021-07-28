<template>
  <div class="container">
    <div :style="preview_style">
      <div style="padding-top: 10px; padding-left: 20px; padding-right: 20px;">
        </div>
        <div style="margin-top: 60px; margin-left: 25px; margin-right: 25px; border-radius: 10px; background-color: #E2F2F2; white-space: pre-line;">
            <div style="padding-top: 10px; padding-left: 10px; padding-right: 10px; font-size: 85%; font-style: italic;">{{content}}</div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    content: {
      type: String,
      required: false,
    },
  },

  computed: {
    preview_style: function () {
      return `width: 250px; height: 500px; background-image: url(${process.env.MIX_APP_URL}/images/PhonePreview.png); background-size: 250px 500px;`;
    },
  },
};
</script>
