import AntDesign from 'ant-design-vue';
import Vue from 'vue';
// import ElementUI from 'element-ui';
// import locale from 'element-ui/lib/locale/lang/en'

import Topbar from './layout/Topbar.vue';
import Sidebar from './layout/Sidebar.vue';
// import PageContainer from './layout/PageContainer.vue';
// import SidebarLayout from './layout/SidebarLayout.vue';
// import InfiniteLoading from 'vue-infinite-loading';

Vue.component('topbar', Topbar);
Vue.component('sidebar', Sidebar);
// Vue.component('page-container', PageContainer);
// Vue.component('sidebar-layout', SidebarLayout);

Vue.use(AntDesign);
// Vue.use(ElementUI, { locale });
// Vue.component('infinite-loading', InfiniteLoading);