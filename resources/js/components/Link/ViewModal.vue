<template>
  <a-modal
    class="modal"
    width="800px"
    height="auto"
    :closable="true"
    :visible="visible"
    :footer="footer"
    :maskStyle="maskStyle"
    @cancel="closeModal"
  >
    <h1>{{ link.title }}</h1>
  </a-modal>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: {
    uuid: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters(['domains']),
    link() {
      return this.$store.getters.link(this.uuid);
    }
  },
  data() {
    return {
      visible: true,
      footer: null,
      maskStyle: {
        backgroundColor: 'rgba(0, 0, 0, .35)'
      }
    };
  },
  methods: {
    /**
     * Close modal
     */
    closeModal() {
      this.visible = false;
      this.$router.push({ name: 'links' });
    }
  }
};
</script>