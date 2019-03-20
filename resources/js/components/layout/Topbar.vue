<template>
  <a-row>
    <a-menu mode="horizontal" class="header">
      <!-- <AddLinkButton /> -->
      <a-sub-menu class="header__menu" trigger="click">
        <span slot="title" class="submenu-title-wrapper">
          <!-- <a-avatar size="default" :src="user.avatar" shape="square"/> -->
          Welcome, {{ user.name }}
          <a-icon type="caret-down" :style="{fontSize: '10px'}"/>
        </span>
        <a-menu-item key="account-settings">
          <a-icon type="user"/>Account Settings
        </a-menu-item>
        <a-menu-item key="ap-key">
          <a-icon type="key"/>API keys
        </a-menu-item>
        <a-menu-divider/>
        <a-menu-item key="logout" @click="logout">
          <a-icon type="logout"/>Logout
        </a-menu-item>
      </a-sub-menu>
    </a-menu>
  </a-row>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['user', 'isLoggedIn'])
  },
  watch: {
    isLoggedIn(val) {
      if (!val) {
        this.$router.push({
          name: 'login'
        });
      }
    }
  },
  methods: mapActions(['logout'])
};
</script>

<style lang="scss" scoped>
.header {
  float: right;
  border: none;
  // margin-top: 15px;

  &__menu {
    &:hover {
      border-bottom: 2px solid transparent !important;
    }
  }
}
.logo {
  font-size: 25px;
}
</style>