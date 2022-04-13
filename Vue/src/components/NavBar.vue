<template>
    <div>
        <div class="line"></div>
        <el-menu
        :default-active="activeIndex2"
        class="el-menu-demo"
        mode="horizontal"
        background-color="#005BBB"
        text-color="#fff"
        active-text-color="#ffffff"
        router>
        <el-menu-item index="/">DotPlan</el-menu-item>
            <!-- <el-submenu index="2">
                <template slot="title">Workspace</template>
                <el-menu-item index="2-1">item one</el-menu-item>
                <el-menu-item index="2-2">item two</el-menu-item>
                <el-menu-item index="2-3">item three</el-menu-item>
                <el-submenu index="2-4">
                <template slot="title">item four</template>
                <el-menu-item index="2-4-1">item one</el-menu-item>
                <el-menu-item index="2-4-2">item two</el-menu-item>
                <el-menu-item index="2-4-3">item three</el-menu-item>
                </el-submenu>
            </el-submenu> -->
            <el-menu-item index="signup" route="signup" v-show="!this.$store.state.user.isLoggedIn">
                Sign Up
            </el-menu-item>
            <el-menu-item index="login" route="login" v-show="!this.$store.state.user.isLoggedIn">
                Log In
            </el-menu-item>
            <el-menu-item style="float:right" v-show="this.$store.state.user.isLoggedIn">
              <el-dropdown>
              <el-button type="primary"  style="float:right; color:white">
                {{this.$store.state.user.email}}
                <i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item>
                  <el-link :underline="false" @click="goSettings">Settings</el-link>
                </el-dropdown-item>
                <el-dropdown-item>
                  <el-link :underline="false" @click="logout">Log Out</el-link>
                </el-dropdown-item>
              </el-dropdown-menu>
              </el-dropdown>
            </el-menu-item>
            <el-menu-item @click="logout" v-show="this.$store.state.user.isLoggedIn" style="float:right">
            </el-menu-item>
        </el-menu>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        activeIndex: '1',
        activeIndex2: '1'
      };
    },
    methods: {
      logout(){
        this.$confirm('Are you sure to log out?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.$store.commit('clearToken')
          this.$store.commit('clearEmail')
          this.$store.commit('setIsLoggedIn', false)
          this.$store.commit('setLoading', true)
          this.$store.commit('clearTasks')
          this.$store.commit('clearCards')
          this.$store.commit('clearStacks')
          this.$router.push({name: 'UserHome'})
          setTimeout(()=>{
            this.$store.commit('setLoading', false)
            this.$message({
            type: 'success',
            message: 'You have logged out'
          });
        }, 1000)
        }).catch(() => {
        });
      },
      goSettings(){
        if(this.$route.name !== 'SettingPage'){
          this.$store.commit('setLoading', true)
          setTimeout(()=>{
            this.$store.commit('setLoading', false)
            this.$router.push({name:"SettingPage"})
          }, 500)
        }
      }
    },
    computed:{
    }
  }
</script>