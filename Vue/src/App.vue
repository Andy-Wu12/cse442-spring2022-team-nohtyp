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
      getStacks(){
        let self = this
        axios.get(axios.defaults.baseURL + 'stack.php' + '?email=' + this.$store.state.user.email)
          .then(function (response) {
            self.$store.commit('setStacks', response.data.stacks)
          })
          .catch(function (error) {
            console.log(error);
        });
      },
      getTasks(){
        let self = this
        axios.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.$store.state.user.email)
          .then(function (response) {
            self.$store.commit('setTasks', response.data.tasks)
            console.log(self.$store.state.user.tasks)
          })
          .catch(function (error) {
            console.log(error);
        });
      },
      getCards(){
        let self = this
        axios.get(axios.defaults.baseURL + 'card.php' + '?email=' + this.$store.state.user.email)
          .then(function (response) {
            self.$store.commit('setCards', response.data.cards)
            console.log(self.$store.state.user.cards)
          })
          .catch(function (error) {
            console.log(error);
        });
      },
      updateLoginStatus(){
        let self = this
        axios.get(axios.defaults.baseURL + 'session.php' + '?token=' + this.$store.state.user.token)
          .then(function (response) {
              self.$store.commit('setIsLoggedIn', response.data.status === 'success')
              if(response.data.email){
                self.$store.commit('setEmail', response.data.email)
              }
          })
          .catch(function (error) {
            console.log(error);
        });
      },
      showReminder(){
        if(this.$store.state.user.email && this.$store.state.user.email.length > 0){
          this.$notify.info({
              title: 'Reminder',
              dangerouslyUseHTMLString: true,
              message: 'You have ' + `<h1>${this.$store.state.user.tasks.length}</h1>` + ' tasks',
              duration: 4500,
              offset: 70
          });
        }
      }
    },
    mounted(){
      this.updateLoginStatus()
      this.showReminder()
      setTimeout(()=>{
        this.getStacks()  
        this.getTasks()  
        this.getCards()  
      }, 1000)
      console.log(this.$store.state.user)
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
