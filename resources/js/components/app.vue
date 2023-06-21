<template>

<nav-main />

<side-nav-main />
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <router-view></router-view>
  </div>
  <!-- /.content-wrapper -->

  <footer-main />

</template>


<script>

  import  NavMain from '../components/Nav.vue';
  import SideNavMain from "../components/SideNav.vue";
  import FooterMain from "../components/Footer.vue";

export default {

  components:{
    'NavMain': NavMain,
    'SideNavMain': SideNavMain,
    'FooterMain': FooterMain,
  }

}
</script>