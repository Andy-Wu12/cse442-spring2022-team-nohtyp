<template>
  <div>
    <el-row>
      <el-col>
        <el-carousel :interval="2500" arrow="hover" height="50vh" style="width: 80%; margin: 0 auto">
          <el-carousel-item v-for="item in desciptions" :key="item.desc">
            <img :src="item.imgSrc" style="width: 100%;height: auto;">
          </el-carousel-item>
        </el-carousel>
      </el-col>
    </el-row>
    <el-row style="width: 80%; margin: 0 auto; margin-top: 30px">
      <el-col :span="1">
          <img :src="logoImg" style="width: auto;height: auto; margin-top:30px">
      </el-col>
      <el-col :span="13" :offset="5">
        <h1 style="font-weight:bold; font-size: 30px;"> Time Management APP</h1>
          <br>
          <br>
        <h3 style="color:gray; font-weight:lighter; text-align:left">
          Effective time management begins with clear on exactly how you manage your time on your tasks. 
          <br>
          <br>
          If you are struggling to manage time then DotPlan app will help you go further, 
          <br>
          <br>
          It has simple user interface that easily customizable based on what you need for everyday use.  
        </h3>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  export default({
    components:{
    },
    data() {
      return {
        isCollapse: false,
        num:1,
        logoImg:require('../assets/logo.png'),
        desciptions:[
          {
            desc:"aaa",
            imgSrc: require('../assets/1.png')
          },
          {
            desc:"bbb",
            imgSrc: require('../assets/2.png')
          },{
            desc:"ccc",
            imgSrc: require('../assets/3.png')
          }
        ]
      };
    },
  })
</script>

<style scoped>
  .el-carousel__item h3 {
    color: #475669;
    font-size: 18px;
    opacity: 0.75;
    line-height: 300px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
</style>