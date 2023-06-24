<template>
    
    <div class="row">

<div class="col-12">
    <div class="small-box bg-info ml-4 mt-4 mr-4">
    <div class="inner">
        <h3> {{ lostStolenCounts }} </h3>
        <p>Lost & Stolen Count</p>
    </div>
    <div class="icon">
        <i class="fas fa-exchange-alt"></i>
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
        
    <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openLostStolenModal">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Add New Lost & Stolen</span>
                            </button>

                            <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportModal">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Import Losts & Stolens</span>
                            </button>

                            <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_lostStolens">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Export Losts & Stolens</span>
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
        <th>Alter Code Namaa</th>
        <th>Document Number</th>
        <th>Lost Date</th>
        <th>Is Stolen</th>
        <th>Options</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="lostStolenArr in lostStolenArrs" :key="lostStolenArr.id">
        <td>{{ lostStolenArr.assets.codeNamaa }}</td>
        <td>{{ lostStolenArr.alters.codeNamaa }}</td>
        <td>{{ lostStolenArr.documentNumber }}</td>
        <td>{{ lostStolenArr.lostDate }}</td>
        <td>{{ lostStolenArr.isStolen == 1 ? 'Yes' : 'No' }}</td>
        <td>
        <a href="#" @click="editLostStolenModal(lostStolenArr.id)"><i class="fa fa-edit mr-2"></i></a>
        <a href="#" @click="confirm_delete(lostStolenArr.id)"><i class="fa fa-trash text-danger mr-2"></i></a>
        <a href="#" @click="showLostStolenInfo(lostStolenArr.id)"><i class="fas fa-info-circle text-success"></i></a>
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

<lost-stolen-model :lostStolenId ="lostStolenId" @sendLostStolenValue="receivedLostStolenValue" />

<lost-stolen-info :lostStolenId ="lostStolenId" />

<import-modal />

<conf-main />

</template>

<script>
import { useToastr } from '../toastr.js'
import LostStolenModel from '../components/LostStolenModel.vue'
import ImportModal from '../components/ImportModal.vue'
import LostStolenInfo from '../components/LostStolenInfo.vue'
import ConfMain from '../components/confirmModel.vue'
import $ from 'jquery';

export default{
  components: { ImportModal, LostStolenInfo, LostStolenModel, ConfMain },

    data:() => ({
        lostStolenCounts: '',
        lostStolenArrs: [],
        lostStolenId: '',
        deleteId: '',
    }),
    methods:{
      async receivedLostStolenValue(value){
        if(value == true){
          $('#lostStolen-modal').modal('hide');
          this.lostStolenId = '';
         await this.getLostStolens();
        }else{
         await this.getLostStolens();
        }
      },
    useToastr,
      async getLostStolens(){
           await this.axios.get(this.$store.state.apiLostStolen).then(res =>{
           this.lostStolenArrs = res.data;
           this.lostStolenCounts = res.data.length;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      openLostStolenModal(){
        $('#lostStolen-modal').modal('show');
      },
      openImportModal(){
        $('#import-modal').modal('show');
        this.$store.state.importUrl = this.$store.state.apiLostStolen;
              this.$store.state.importFuncLink = '/import_lostStolens';
              this.$store.state.importTitle = 'Import Lost & Stolen';
      },
      editLostStolenModal(lostStolenIndex){

            this.lostStolenId = lostStolenIndex;
            $('#lostStolen-modal').modal('show');
    },
    showLostStolenInfo(lostStolenIndex){
      this.lostStolenId = lostStolenIndex;
            $('#lostStolen-info-modal').modal('show');
    },
    confirm_delete(deleteIndex){
        // this.deleteId = deleteIndex;
        // $('#modal-default-lostStolen').modal('show');
        this.$store.state.deleteUrl = this.$store.state.apiLostStolen;
        this.$store.state.deleteData = deleteIndex;
        $('#modal-default-type').modal('show');
      },
      // async delete_lostStolen(){
      //       await this.axios.delete(this.$store.state.apiLostStolen +'/'+ this.deleteId).then(res =>{
      //         $('#modal-default-lostStolen').modal('hide');
      //         this.deleteId = '';
      //         this.useToastr().success('Lost & Stolen Deleted Successfully');
      //         this.getLostStolens();
      // }).catch((error)=>{
      //   this.useToastr().error('Something Went Wrong');
      // });
      // },
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
     await this.getLostStolens();
    },
    watch:{
        lostStolenIndex(newId, oldId){
        this.lostStolenId = newId;
      },
      async isDeleted(newValue, oldValue){
        if(newValue == true){
              this.useToastr().success('Lost & Stolen Deleted Successfully');
              this.$store.state.isDeleted = false;
              await this.getLostStolens();
        }
      },
      async isImported(newValue, oldValue){
        if(newValue == true){
          $('#import-modal').modal('hide');
              this.useToastr().success('Losts & Stolens Imported Successfully');
              this.$store.state.isImported = false;
              await this.getLostStolens();
        }
      },
    },
}
</script>  