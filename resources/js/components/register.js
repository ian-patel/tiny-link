import Vue from 'vue';
import AntDesign from 'ant-design-vue';

import Topbar from './layout/Topbar.vue';
import Sidebar from './layout/Sidebar.vue';
import Titlebar from './Titlebar.vue';
import ViewLink from './Link/View.vue';
import CreateLinkButton from './Link/CreateButton.vue';

Vue.component('topbar', Topbar);
Vue.component('sidebar', Sidebar);
Vue.component('ViewLink', ViewLink);
Vue.component('CreateLinkButton', CreateLinkButton);
Vue.component('TitleBar', Titlebar);

Vue.use(AntDesign);
