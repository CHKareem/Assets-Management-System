<template>
    
      <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

           <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" role="button">
          <i class="far fa-user"></i> username
        </a>
      </li>

      <li class="nav-item">
        <div class="dropdown">
        <button class="btn dropdown-toggle" id="dropdownMenuButton"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <i class="fa fa-language"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" role="button" v-if="this.$store.state.appLanguage == 'en' ? '' : 'active' " @click="setLocale('en')">en</a>
    <a class="dropdown-item" role="button" v-if="this.$store.state.appLanguage == 'ar' ? '' : 'active' " @click="setLocale('ar')">ar</a>
  </div>
</div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

</template>


<script>
import store from '../store.js'

export default{
methods:{
  setLocale(locale) {
    store.commit('setAppLanguage', {locale: locale});
      this.$i18n.locale = locale
      // this.$router.push({
      //   params: { lang: locale }
      // })
    }
  }
}

</script>