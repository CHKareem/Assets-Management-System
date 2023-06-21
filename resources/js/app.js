import './bootstrap';


// jQuery
import 'admin-lte/plugins/jquery/jquery.min.js';

// Bootstrap 4
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';

// AdminLTE App
import 'admin-lte/dist/js/adminlte.min.js';

// select 2
// import 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js';
// import 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';


import $ from 'jquery';
// window.$ = window.jQuery = $;

// import 'jquery-ui/ui/widgets/datepicker.js';

import 'admin-lte/plugins/datatables/jquery.dataTables';
import 'admin-lte/plugins/datatables/jquery.dataTables.min.js';
import 'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4';
import'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js';
import'admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js';
import'admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js';

// import'admin-lte/plugins/select2/js/select2.full.min.js';


// $("#example1").DataTable({
//     "responsive": true,
//     "autoWidth": false,
//   });


// $(function () {
  $(document).ready( function() {
  // $('#myTable').dataTable();
  setTimeout(function(){
  $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "searching": true,"paging": true,
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  });}, 1000);

  // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  setTimeout(function(){
  $("#example2").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "searching": true,"paging": true,
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  });}, 1000);
  // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});



import {createApp} from 'vue'
import App from './components/app.vue'
import router from './router/index.js'
import axios from 'axios';
import VueAxios from 'vue-axios';

createApp(App).use(VueAxios, axios).use(router).mount('#app')
