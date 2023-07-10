<template>

<nav-main  v-if="this.$store.getters.isAuthenticated" />

<side-nav-main v-if="this.$store.getters.isAuthenticated" />
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" :style="contentWrapper">
    <router-view></router-view>
  </div>
  <!-- /.content-wrapper -->

  <footer-main v-if="this.$store.getters.isAuthenticated" />

</template>


<script>

  import  NavMain from '../components/Nav.vue'
  import SideNavMain from "../components/SideNav.vue"
  import FooterMain from "../components/Footer.vue"

export default {

  components:{
    'NavMain': NavMain,
    'SideNavMain': SideNavMain,
    'FooterMain': FooterMain,
  },
  computed:{
    contentWrapper(){
      if(this.$store.getters.isAuthenticated){
        return '';
      }else{
        return 'margin-left: 0px';
      }
    }
  }
}
</script>