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
import locale from '../node_modules/element-ui/lib/locale/lang/en.js'

Vue.config.productionTip = false
Vue.use(ElementUI, { locale })
Vue.use(vuetify)
Vue.use(VueRouter) 

Vue.prototype.getStacks = function () {
  let self = this
  axios.get(axios.defaults.baseURL + 'stack.php' + '?email=' + this.$store.state.user.email)
    .then(function (response) {
      self.$store.commit('setStacks', response.data.stacks)
    })
    .catch(function (error) {
      console.log(error);
    });
}

Vue.prototype.getCards = function () {
  let self = this
  axios.get(axios.defaults.baseURL + 'card.php' + '?email=' + this.$store.state.user.email)
    .then(function (response) {
      self.$store.commit('setCards', response.data.cards)
      console.log(self.$store.state.user.cards)
    })
    .catch(function (error) {
      console.log(error);
    });
}

Vue.prototype.getTasks = function () {
  let self = this
  axios.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.$store.state.user.email)
    .then(function (response) {
      self.$store.commit('setTasks', response.data.tasks)
      console.log(self.$store.state.user.tasks)
    })
    .catch(function (error) {
      console.log(error);
    });
}

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
  console.log(to)
  // UserHome, SignupPage, LoginPage
  const token = store.state.user.token
  if (typeof(token) === 'undefined' || token === null || token.length === 0) {
    if ((to.name !== 'LoginPage' && to.name !== 'SignupPage' && to.name !== 'UserHome')) {
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
      console.log("blocked with token", token)
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
