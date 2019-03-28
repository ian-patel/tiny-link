<template>
  <div></div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: {
    uuid: {
      type: String,
      required: true
    },
    link: {
      type: Object
    }
  }
};
</script>
