<template>
  <div id="components-layout-demo-basic">
    <a-layout>
      <a-layout-header>
        <topbar :items="items" />
      </a-layout-header>
      <a-layout-content>
        <router-view />
      </a-layout-content>
      <a-layout-footer>Footer</a-layout-footer>
    </a-layout>
  </div>
</template>

<script>

import { mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      items: [
        { title: 'Dashboard', name: '/dashboard', route: 'dashboard', icon: '😬' },
        { title: 'Links', name: '/links', route: 'links', icon: '🤔' },
      ]
    }
  },
  computed: {
    ...mapGetters(['user', 'isLoggedIn']),
  },
  watch: {
    isLoggedIn(val) {
      if (!val) this.$router.push({ name: 'login', query: { r: this.$route.fullPath } });
    },
  },
  methods: mapActions(['logout']),
};
</script>
