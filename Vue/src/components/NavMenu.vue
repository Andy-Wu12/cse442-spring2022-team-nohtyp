<template>
    <div id="leftmenu" style="background-color:#d9d8d7">
        <el-radio-group v-model="isCollapse" style="padding-top:10px">
          <el-button type="primary" icon="el-icon-menu" @click=" isCollapse = !isCollapse" circle></el-button>
        </el-radio-group>
        <el-menu 
          default-active="2"
          class="el-menu-vertical-demo" 
          @open="handleOpen" 
          @close="handleClose" 
          :collapse="isCollapse" 
          background-color="#d9d8d7"
          style="height:93vh"
          router>
            <el-submenu index="1">
                <template slot="title">
                <i class="el-icon-location"></i>
                <span slot="title">Navigator One</span>
                </template>
                <el-menu-item-group>
                <span slot="title">Group One</span>
                <el-menu-item index="1-1">item one</el-menu-item>
                <el-menu-item index="1-2">item two</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="Group Two">
                <el-menu-item index="1-3">item three</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="1-4">
                <span slot="title">item four</span>
                <el-menu-item index="1-4-1">item one</el-menu-item>
                </el-submenu>
            </el-submenu>
            <el-menu-item index="/" v-show="isLoggedIn">
                <i class="el-icon-menu"></i>
                <span slot="title">User Home</span>
            </el-menu-item>
            <el-menu-item index="/" v-show="!isLoggedIn">
                <i class="el-icon-menu"></i>
                <span slot="title">Introduction</span>
            </el-menu-item>
            <el-menu-item index="edit" v-show="isLoggedIn">
                <i class="el-icon-menu"></i>
                <span slot="title">Edit</span>
            </el-menu-item>
            <el-menu-item index="settings" route="settings" v-show="isLoggedIn">
                <i class="el-icon-setting"></i>
                <span slot="title">Settings</span>
            </el-menu-item>
        </el-menu>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        isCollapse: false,
        num:1
      };
    },
    methods: {      
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      },
      toggleNav(){
        this.isCollapse = !this.isCollapase
        this.num++
        return this.isCollapse
      }
    },
    computed:{
      isLoggedIn(){
        return this.$store.state.user.token && this.$store.state.user.token.length > 0
      }
    }
  }
</script>

<style>
  #menu{
    position: absolute;
    top: 0;
    left:0;
    bottom:0;
  }
  .el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
  }
</style>