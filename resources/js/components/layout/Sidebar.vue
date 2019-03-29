<template>
  <a-layout-sider breakpoint="lg" width="110" collapsedWidth="0" class="sidebar" theme="light">
    <a-affix>
      <router-link :to="{ name: 'dashboard'}">
        <a-icon type="dingding" class="sidebar__logo"/>
      </router-link>
      <a-menu
        mode="inline"
        :inlineIndent="16"
        :defaultSelectedKeys="['Links']"
        class="siderbar_menu"
      >
        <template v-for="item in items">
          <a-menu-item :key="item.title" class="sidebar__menuitem">
            <router-link :to="{ name: item.name}">
              <a-icon :type="item.icon"/>
              <span class="nav-text">{{ item.title }}</span>
            </router-link>
          </a-menu-item>
        </template>
      </a-menu>
    </a-affix>
  </a-layout-sider>
</template>

<script>
export default {
  data() {
    return {
      items: [
        { title: 'Links', name: 'links', route: 'links', icon: 'link' },
        {
          title: 'Reports',
          name: 'reports',
          route: 'reports',
          icon: 'bar-chart'
        },
        {
          title: 'Domains',
          name: 'domains',
          route: 'domains',
          icon: 'upload'
        },
        {
          title: 'Settings',
          name: 'settings',
          route: 'settings',
          icon: 'setting'
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.sidebar {
  background: transparent linear-gradient(80deg, #0b4182 1%, #1a78cf 99%) repeat
    scroll 0% 0%;
  // border-right: 1px solid #e8e8e8 !important;
  padding-left: 0px !important;

  &__logo {
    margin: 30px;
    font-size: 44px;
    text-align: center;
    color: #84bef1;
  }

  &__menu {
    background: transparent !important;
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
      // color: #a1c8ee;
      font-weight: 700;
    }
  }
}

.ant-menu-inline,
.ant-menu-vertical,
.ant-menu-vertical-left {
  border-right: none !important;
  background: transparent !important;
}

.siderbar_menu a {
  color: #84bef1;
}

.siderbar_menu .ant-menu-item-selected,
.siderbar_menu .ant-menu-item-active {
  border-right: none !important;
  background: transparent !important;

  a {
    color: #fff !important;
  }

  &:after {
    width: 0;
    height: 0;
    border-bottom: 10px solid transparent;
    border-top: 10px solid transparent;
    border-right: 10px solid #ffffff;
    content: ' ';
    position: absolute;
    right: 0;
    top: 35px;
  }
}
</style>

<style>
.ant-layout-sider-zero-width-trigger {
  border: 1px solid #e8e8e8 !important;
}
</style>
