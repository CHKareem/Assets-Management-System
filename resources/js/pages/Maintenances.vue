<template>
   
    <div class="row">
 
 <div class="col-12">
     <div class="small-box bg-info ml-4 mt-4 mr-4">
     <div class="inner">
         <h3> {{ maintenanceCounts }} </h3>
         <p>Maintenance Count</p>
     </div>
     <div class="icon">
         <i class="fas fa-tools"></i>
     </div>
     </div>
 
 </div>
 </div>
 
 
 <section class="content">
       <div class="container-fluid">
 
         <div class="row">
 
           <div class="col-12">
                 <div class="card card-primary card-outline">
                 <div class="card-header">
 <div class="row justify-content-between">
         
     <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openMaintenanceModal">
                                 <i class="fa fa-plus-circle mr-2"></i>
                         <span>Add New Maintenance</span>
                             </button>
 
                             <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportMaintenance">
                                 <i class="fa fa-plus-circle mr-2"></i>
                         <span>Import Maintenances</span>
                             </button>
 
                             <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_maintenances">
                                 <i class="fa fa-plus-circle mr-2"></i>
                         <span>Export Maintenances</span>
                             </a>
     </div>
     </div>
     </div>
     </div>
 
 
     <div class="col-12">
 
 
 <div class="card">
   <!-- /.card-header -->
   <div class="card-body">
     <div class="table-responsive">
     <table id="example2" class="table table-bordered table-striped">
       <thead>
       <tr>
         <th>Code Namaa</th>
         <th>Receive date</th>
         <th>Status Before</th>
         <th>Status After</th>
         <th>Technical Disclosure Number</th>
         <th>Options</th>
       </tr>
       </thead>
       <tbody>
       <tr v-for="maintenancesArr in maintenancesArrs" :key="maintenancesArr.id">
         <td>{{ maintenancesArr.assets.codeNamaa }}</td>
         <td>{{ maintenancesArr.receiveDate }}</td>
         <td>{{ maintenancesArr.statusBefore }}</td>
         <td>{{ maintenancesArr.statusAfter }}</td>
         <td>{{ maintenancesArr.technicalDisclosureNumber }}</td>
         <td>
         <a href="#" @click="editMaintenanceModal(maintenancesArr.id)"><i class="fa fa-edit mr-2"></i></a>
         <a href="#" @click="confirm_delete(maintenancesArr.id)"><i class="fa fa-trash text-danger mr-2"></i></a>
         <a href="#" @click="showMaintenanceInfo(maintenancesArr.id)"><i class="fas fa-info-circle text-success"></i></a>
     </td>
       </tr>
       <tfoot></tfoot>
       </tbody>
     </table>
     </div>
   </div>
   <!-- /.card-body -->
 </div>
 
 </div>
 
     </div>
     </div>
     </section>
 
 <maintenance-modal :maintenanceId ="maintenanceId" @sendMaintenanceValue="receivedMaintenanceValue" />
 
 <maintenance-info :maintenanceId ="maintenanceId" />
 
 <import-maintenance @importSuccess = "impSucc" />
 
 <div class="modal fade" id="modal-default-maintenance">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
               <h4 class="modal-title">Delete Modal</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <p> Are You Sure You Want To Delete ?</p>
             </div>
             <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-danger" @click="delete_maintenance">Delete</button>
             </div>
           </div>
           <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
       </div>
       <!-- /.modal -->
 
 
 </template>
 
 <script>
 import { useToastr } from '../toastr.js'
 import MaintenanceModal from '../components/MaintenanceModal.vue'
 import ImportMaintenance from '../components/ImportMaintenanceModel.vue'
 import MaintenanceInfo from '../components/MaintenanceInfo.vue'
 import $ from 'jquery';
 
 export default{
   components: { MaintenanceModal, ImportMaintenance, MaintenanceInfo },
 
     data:() => ({
         maintenanceCounts: '',
         maintenancesArrs: [],
         maintenanceId: '',
         deleteId: '',
     }),
     methods:{
       async impSucc(value){
         if(value == true){
           $('#maintenance-import-modal').modal('hide');
          await this.getMaintenances();
         }
       },
       async receivedMaintenanceValue(value){
         if(value == true){
           $('#maintenance-modal').modal('hide');
           this.maintenanceId = '';
          await this.getMaintenances();
         }else{
          await this.getMaintenances();
         }
       },
     useToastr,
       async getMaintenances(){
            await this.axios.get(this.$store.state.apiMaintenance).then(res =>{
            this.maintenancesArrs = res.data;
            this.maintenanceCounts = res.data.length;
       }).catch((error)=>{
         this.useToastr().error('Something Went Wrong');
       });
       },
       openMaintenanceModal(){
         $('#maintenance-modal').modal('show');
       },
       openImportMaintenance(){
         $('#maintenance-import-modal').modal('show');
       },
       editMaintenanceModal(maintenanceIndex){
 
             this.maintenanceId = maintenanceIndex;
             $('#maintenance-modal').modal('show');
     },
     showMaintenanceInfo(maintenanceIndex){
       this.maintenanceId = maintenanceIndex;
             $('#maintenance-info-modal').modal('show');
     },
     confirm_delete(deleteIndex){
         this.deleteId = deleteIndex;
         $('#modal-default-maintenance').modal('show');
       },
       async delete_maintenance(){
             await this.axios.delete(this.$store.state.apiMaintenance +'/'+ this.deleteId).then(res =>{
               $('#modal-default-maintenance').modal('hide');
               this.deleteId = '';
               this.useToastr().success('Maintenance Deleted Successfully');
               this.getMaintenances();
       }).catch((error)=>{
         this.useToastr().error('Something Went Wrong');
       });
       },
       },
 
     async mounted(){
      await this.getMaintenances();
     },
     watch:{
       maintenanceIndex(newId, oldId){
         this.maintenanceId = newId;
       }
     },
 }
 </script>  