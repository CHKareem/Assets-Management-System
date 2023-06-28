<template>
    <div class="row">

<div class="col-12">
    <div class="small-box bg-info ml-4 mt-4 mr-4">
    <div class="inner">
        <h3> {{ transportCounts }} </h3>
        <p>{{ $t('transportCount') }}</p>
    </div>
    <div class="icon">
        <i class="fas fa-people-carry"></i>
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
        
    <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openTransportModal">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('newTransport') }}</span>
                            </button>

                            <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportModal">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('impTransport') }}</span>
                            </button>

                            <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_transports">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('expTransport') }}</span>
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
        <th>{{ $t('asset') }}</th>
        <th>{{ $t('emp') }}</th>
        <th>{{ $t('docDate') }}</th>
        <th>{{ $t('docNumber') }}</th>
        <th>{{ $t('handed') }}</th>
        <th>{{ $t('options') }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="transportArr in transportArrs" :key="transportArr.id">
        <td>{{ transportArr.assets.codeNamaa }}</td>
        <td v-if="transportArr.employee_id == null">--</td>
        <td v-else>{{ transportArr.employees.fullName }}</td>
        <td >{{ transportArr.transportDate }}</td>
        <td>{{ transportArr.documentNumber }}</td>
        <td>{{ transportArr.isHanded == 1 ? 'Yes' : 'No' }}</td>
        <td>
        <a href="#" @click="editTransportModal(transportArr.id)"><i class="fa fa-edit mr-2"></i></a>
        <a href="#" @click="confirm_delete(transportArr.id)"><i class="fa fa-trash text-danger mr-2"></i></a>
        <a href="#" @click="showTransportInfo(transportArr.id)"><i class="fas fa-info-circle text-success"></i></a>
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

<transport-modal :transportId ="transportId" @sendTransportValue="receivedTransportValue" />

<transport-info :transportId ="transportId" />

<import-modal />

<conf-main />


</template>

<script>
import { useToastr } from '../toastr.js'
import TransportModal from '../components/TransportModel.vue'
import ImportModal from '../components/ImportModal.vue'
import TransportInfo from '../components/TransportInfo.vue'
import ConfMain from '../components/confirmModel.vue'
import $ from 'jquery';

export default{
  components: { TransportModal, ImportModal, TransportInfo, ConfMain },

    data:() => ({
        transportCounts: '',
        transportArrs: [],
        transportId: '',
        deleteId: '',
    }),
    methods:{
      async receivedTransportValue(value){
        if(value == true){
          $('#transport-modal').modal('hide');
          this.transportId = '';
         await this.getTransports();
        }else{
         await this.getTransports();
        }
      },
    useToastr,
      async getTransports(){
           await this.axios.get(this.$store.state.apiTransport).then(res =>{
           this.transportArrs = res.data;
           this.transportCounts = res.data.length;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      openTransportModal(){
        $('#transport-modal').modal('show');
      },
      openImportModal(){
        $('#import-modal').modal('show');
        this.$store.state.importUrl = this.$store.state.apiTransport;
              this.$store.state.importFuncLink = '/import_transports';
              this.$store.state.importTitle = 'Import Transports';
      },
      editTransportModal(transportIndex){

            this.transportId = transportIndex;
            $('#transport-modal').modal('show');
    },
    showTransportInfo(transportIndex){
      this.transportId = transportIndex;
            $('#transport-info-modal').modal('show');
    },
    confirm_delete(deleteIndex){
        // this.deleteId = deleteIndex;
        // $('#modal-default-transport').modal('show');
        this.$store.state.deleteUrl = this.$store.state.apiTransport;
        this.$store.state.deleteData = deleteIndex;
        $('#modal-default-type').modal('show');
      },
      // async delete_transport(){
      //       await this.axios.delete(this.$store.state.apiTransport +'/'+ this.deleteId).then(res =>{
      //         $('#modal-default-transport').modal('hide');
      //         this.deleteId = '';
      //         this.useToastr().success('Transport Deleted Successfully');
      //         this.getTransports();
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
     await this.getTransports();
    },
    watch:{
        transportIndex(newId, oldId){
        this.transportId = newId;
      },
      async isDeleted(newValue, oldValue){
        if(newValue == true){
              this.useToastr().success('Transport Deleted Successfully');
              this.$store.state.isDeleted = false;
              await this.getTransports();
        }
      },
      async isImported(newValue, oldValue){
        if(newValue == true){
          $('#import-modal').modal('hide');
              this.useToastr().success('Transports Imported Successfully');
              this.$store.state.isImported = false;
              await this.getTransports();
        }
      },
    },
}
</script>  