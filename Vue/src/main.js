import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import VueCardStack from "vue-card-stack";
import vuetify from '@/plugins/vuetify' // path to vuetify export
import VueRouter from 'vue-router'
import router from './router'

Vue.config.productionTip = false
Vue.use(ElementUI)
Vue.use(vuetify)
Vue.use(VueRouter)

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
  vuetify,
  render: h => h(App),
  router:router
}).$mount('#app')
