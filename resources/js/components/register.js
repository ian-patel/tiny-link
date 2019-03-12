import Vue from 'vue';
import AntDesign from 'ant-design-vue';

import Topbar from './layout/Topbar.vue';
import Sidebar from './layout/Sidebar.vue';
import Titlebar from './Titlebar.vue';
import AddLinkButton from './AddLinkButton.vue';

Vue.component('topbar', Topbar);
Vue.component('sidebar', Sidebar);
Vue.component('AddLinkButton', AddLinkButton);
Vue.component('TitleBar', Titlebar);

Vue.use(AntDesign);
