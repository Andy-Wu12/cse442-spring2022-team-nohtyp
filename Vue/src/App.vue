<template>
  <div id="app">
    <el-container v-loading="loading">
      <el-aside width="auto">
        <NavMenu/>
      </el-aside>
      <el-container>
        <el-header style="height: 60px; padding:0;">
          <NavBar/>
        </el-header>
        <el-main>
          <router-view v-slot="{ Component, route }" :key="$route.fullPath">
            <transition :name="route.meta.transition || 'fade'">
              <component :is="Component" />
            </transition>
          </router-view>
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script>
  // import HelloWorld from './components/HelloWorld'
  // import CardsStack from './components/CardsStack'
  import NavBar from './components/NavBar'
  import NavMenu from './components/NavMenu'
  import Vue from 'vue'
  import axios from 'axios'
  import VueAxios from 'vue-axios'

  Vue.use(VueAxios, axios)

export default {
    name: 'App',
    components: {
    // HelloWorld,
    // CardsStack,
    NavBar,
    NavMenu,
    },
    data: () => ({
      isLoggedIn: false,
      selection: 1,
    }),
    computed:{
      loading(){
        return this.$store.state.user.loading
      }
    },
    methods: {
      reserve () {
        this.loading = true
        setTimeout(() => (this.loading = false), 1000)
      },
      updateLoginStatus(){
        let self = this
        axios.get(axios.defaults.baseURL + 'session.php')
          .then(function (response) {
            self.isLoggedIn = response.data.status === 'success';
          })
          .catch(function (error) {
            console.log(error);
        });
      }
    },
    mounted(){
      this.updateLoginStatus()
      console.log(this.$store.state.user)
      if(this.$store.state.user.email && this.$store.state.user.email.length > 0){
          this.$notify.info({
              title: 'Reminder',
              dangerouslyUseHTMLString: true,
              message: 'You have ' + `<h1>${this.$store.state.user.tasks.length}</h1>` + ' tasks',
              duration: 4500,
              offset: 70
          });
      }
    },
  }
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
