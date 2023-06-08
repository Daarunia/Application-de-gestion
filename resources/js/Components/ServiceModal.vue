<template>

  </template>

  <script>
  export default {
    props: {
      modalId: {
        type: String,
        required: true
      },
      modalTitle: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        visible: false
      };
    },
    methods: {
      showModal() {
        this.visible = true;
      },
      hideModal() {
        this.visible = false;
      },
    }
  };
  </script>

