import Vue from 'vue';
import store from 'App/store';
import router from 'App/router';

import 'App/bootstrap';
import 'App/components/register';

Vue.config.productionTip = false;

// Create Vue instance and attach to the page
const app = new Vue({
  store,
  router,
});

app.$mount('#app');
