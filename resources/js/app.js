import Vue from 'vue';
import store from 'app/store';
import router from 'app/router';

import 'app/bootstrap';
import 'app/components/register';

Vue.config.productionTip = false;

// Create Vue instance and attach to the page
const app = new Vue({
  store,
  router,
});

app.$mount('#app');
