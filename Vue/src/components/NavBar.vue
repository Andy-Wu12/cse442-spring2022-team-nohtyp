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
        <el-menu-item index="/">Dot.Plan</el-menu-item>
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
            <el-menu-item @click="logout" v-show="this.$store.state.user.isLoggedIn" >
                Log Out
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
          setTimeout(()=>{
            this.$store.commit('setLoading', false)
            this.$message({
            type: 'success',
            message: 'You have logged out'
          });
        }, 1000)
        }).catch(() => {
        });
      }
    },
    computed:{
    }
  }
</script>