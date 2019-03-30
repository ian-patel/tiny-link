<template>
  <a-layout>
    <sidebar/>
    <a-layout>
      <topbar/>
      <a-layout-content :style="{ margin: '0px 16px 0' }" type="flex" justify="center">
        <div class="container" :style="{ padding: '0px 20px', minHeight: window.height }">
          <router-view/>
        </div>
      </a-layout-content>
      <!-- <a-layout-footer style="textAlign: center">2ny link ©2019</a-layout-footer> -->
    </a-layout>
  </a-layout>
</template>

<script>
export default {
  mounted() {
    this.handleHeight();
  },
  methods: {
    handleHeight() {
      this.window.height = window.innerHeight + 'px';
    }
  },
  data() {
    return {
      window: {
        height: 0
      }
    };
  }
};
</script>