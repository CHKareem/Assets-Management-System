<template>
   
    <div class="row">
 
 <div class="col-12">
     <div class="small-box bg-info ml-4 mt-4 mr-4">
     <div class="inner">
         <h3> {{ maintenanceCounts }} </h3>
         <p>{{ $t('maintenanceCount') }}</p>
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
                         <span>{{ $t('newMaintenance') }}</span>
                             </button>
 
                             <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportModal">
                                 <i class="fa fa-plus-circle mr-2"></i>
                         <span>{{ $t('impMaintenance') }}</span>
                             </button>
 
                             <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_maintenances">
                                 <i class="fa fa-plus-circle mr-2"></i>
                         <span>{{ $t('expMaintenance') }}</span>
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
         <th>{{ $t('codeNamaa') }}</th>
         <th>{{ $t('receiveDate') }}</th>
         <th>{{ $t('statusBefore') }}</th>
         <th>{{ $t('statusAfter') }}</th>
         <th>{{ $t('techNumber') }}</th>
         <th>{{ $t('options') }}</th>
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

 <import-modal />

 <conf-main />
 
 
 </template>
 
 <script>
 import { useToastr } from '../toastr.js'
 import MaintenanceModal from '../components/MaintenanceModal.vue'
 import ImportModal from '../components/ImportModal.vue'
 import MaintenanceInfo from '../components/MaintenanceInfo.vue'
 import ConfMain from '../components/confirmModel.vue'
 import $ from 'jquery';
 import i18n from '../i18n.js'

 export default{
   components: { MaintenanceModal, ImportModal, MaintenanceInfo, ConfMain },
 
     data:() => ({
         maintenanceCounts: '',
         maintenancesArrs: [],
         maintenanceId: '',
         deleteId: '',
     }),
     methods:{
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
       openImportModal(){
        $('#import-modal').modal('show');
        this.$store.state.importUrl = this.$store.state.apiMaintenance;
              this.$store.state.importFuncLink = '/import_maintenances';
              this.$store.state.importTitle = '';
              this.$store.state.importTitle = i18n.global.t('impMaintenance');
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
        //  this.deleteId = deleteIndex;
        //  $('#modal-default-maintenance').modal('show');
        this.$store.state.deleteUrl = this.$store.state.apiMaintenance;
        this.$store.state.deleteData = deleteIndex;
        $('#modal-default-type').modal('show');
       },
      //  async delete_maintenance(){
      //        await this.axios.delete(this.$store.state.apiMaintenance +'/'+ this.deleteId).then(res =>{
      //          $('#modal-default-maintenance').modal('hide');
      //          this.deleteId = '';
      //          this.useToastr().success('Maintenance Deleted Successfully');
      //          this.getMaintenances();
      //  }).catch((error)=>{
      //    this.useToastr().error('Something Went Wrong');
      //  });
      //  },
       },
       computed:{
    isDeleted(){
      return this.$store.state.isDeleted;
    },
    isImported(){
      return this.$store.state.isImported;
    }
  },
     async mounted(){
      await this.getMaintenances();
     },
     watch:{
       maintenanceIndex(newId, oldId){
         this.maintenanceId = newId;
       },
       async isDeleted(newValue, oldValue){
        if(newValue == true){
              this.useToastr().success('Maintenance Deleted Successfully');
              this.$store.state.isDeleted = false;
              await this.getMaintenances();
        }
      },
      async isImported(newValue, oldValue){
        if(newValue == true){
          $('#import-modal').modal('hide');
              this.useToastr().success('Maintenances Imported Successfully');
              this.$store.state.isImported = false;
              await this.getMaintenances();
        }
      },
     },
 }
 </script>  