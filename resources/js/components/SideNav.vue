<template>
    
      <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed; overflow-y: hidden; overflow-x: hidden;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Namaa - Asset's</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item" v-for="link in links" :key="link.routers">
            <router-link :to="link.routers" active-class="active" class="nav-link">
              <i :class="[link.icon, nav-icon, ml-2 ]"></i>
              <p  class="ml-2">
                {{ $t(link.title) }}
              </p>
            </router-link>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

</template>


<script>
export default{
data: () => ({
    links:[
          {title: 'dashboard', icon:'fas fa-tachometer-alt',routers:'/'},
          {title: 'itemType', icon:'fas fa-microchip',routers:'/items-types' },
          {title: 'assets', icon:'fa fa-desktop',routers:'/assets' },
          {title: 'transports', icon:'fas fa-people-carry',routers:'/transports' },
          {title: 'maintenances', icon:'fas fa-tools',routers:'/maintenance' },
          {title: 'lostStolen', icon: 'fas fa-exchange-alt', routers: '/lostStolen'},
          {title: 'reports', icon:'far fa-file',routers:'/Reports' }
         ],
}),

}
</script>