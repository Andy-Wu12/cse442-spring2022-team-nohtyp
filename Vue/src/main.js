import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import VueCardStack from "vue-card-stack";
import vuetify from '@/plugins/vuetify' // path to vuetify export
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
import axios from 'axios'
import apiConfigDev from '../apiConfig/apiConfigDev.json'
import apiConfigProd from '../apiConfig/apiConfigProd.json'

Vue.config.productionTip = false
Vue.use(ElementUI)
Vue.use(vuetify)
Vue.use(VueRouter) 

if (process.env.NODE_ENV !== 'development') {
  axios.defaults.baseURL = apiConfigProd.api
  Vue.prototype.apiConfig = apiConfigProd
}
else {
  axios.defaults.baseURL = apiConfigDev.api
  Vue.prototype.apiConfig = apiConfigDev
}
console.log(axios.defaults.baseURL)
router.beforeEach((to, from, next) => {
  store.commit('getToken')
  const token = store.state.user.token
  if (!token) {
    if ((to.name === 'SettingPage' || to.name === '')) {
      next({ name: "LoginPage" })
      console.log("blocked without token")
    }
    else {
      next()
    }
  }
  else if (token) {
    if ((to.name === 'SignupPage' || to.name === 'LoginPage')) {
      next({ name: "UserHome" })
      console.log("blocked with token")
    }
    else {
      next()      
    }
  }
})

export default {
  components: {
    VueCardStack,
  },
  data() {
    return {
      cards: [
        { background: "#00659d" },
        { background: "#00abbc" },
        { background: "#e2c58a" },
        { background: "#fc8890" },
        { background: "#b35d7f" },
      ],
    };
  }
};
new Vue({
  store,
  vuetify,
  render: h => h(App),
  router:router
}).$mount('#app')
