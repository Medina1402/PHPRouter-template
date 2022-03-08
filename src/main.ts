import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import 'boxicons'
//<box-icon animation="tada-hover" color="yellow" :type="statusSolidIcon" size="lg" border="square" name="lemon"/>

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
