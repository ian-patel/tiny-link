<template>
  <a-layout-sider breakpoint="lg" width="110" collapsedWidth="0" theme="light" class="sidebar">
    <a-affix :offsetTop="64">
      <a-menu mode="inline" :inlineIndent="16" :defaultSelectedKeys="['Links']" theme="light">
        <template v-for="item in items">
          <a-menu-item :key="item.title" class="sidebar__menuitem">
            <router-link :to="{ name: item.name}">
              <a-icon :type="item.icon" />
              <span class="nav-text">{{ item.title }}</span>
            </router-link>
          </a-menu-item>
        </template>
      </a-menu>
    </a-affix>
  </a-layout-sider>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      items: [
        { title: "Links", name: "links", route: "links", icon: "link" },
        {
          title: "Reports",
          name: "dashboard",
          route: "reports",
          icon: "bar-chart"
        },
        {
          title: "Domains",
          name: "dashboard",
          route: "reports",
          icon: "upload"
        },
        { title: "Settings", name: "dashboard", route: "reports", icon: "setting" }
      ]
    };
  },
  computed: {
    ...mapGetters(["user", "isLoggedIn"])
  },
  watch: {
    isLoggedIn(val) {
      if (!val)
        this.$router.push({
          name: "login",
          query: { r: this.$route.fullPath }
        });
    }
  },
  methods: mapActions(["logout"])
};
</script>

<style lang="scss" scoped>
.sidebar {
  border-right: 1px solid #e8e8e8 !important;
  padding-left: 0px !important;

  &__logo {
    height: 32px;
    text-align: center;
    margin: 16px;
    margin-bottom: 40px;
  }

  &__menuitem {
    text-align: center;
    height: 80px !important;
    // margin: 12px 0 !important;

    .anticon {
      display: block;
      font-size: 18px !important;
      margin-right: 0 !important;
    }

    a {
      font-size: 16px !important;
      margin-top: 16px;
    }
  }
}

.ant-menu-inline,
.ant-menu-vertical,
.ant-menu-vertical-left {
  border-right: none !important;
}
</style>

<style>
.ant-layout-sider-zero-width-trigger {
  border: 1px solid #e8e8e8 !important;
}
</style>
