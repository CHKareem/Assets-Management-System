<template>
    
    <div class="row">

<div class="col-12">
    <div class="small-box bg-info ml-4 mt-4 mr-4">
    <div class="inner">
        <h3> {{ transportCounts }} </h3>
        <p>Transport Count</p>
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
                        <span>Add New Transport</span>
                            </button>

                            <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportTransport">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Import Transports</span>
                            </button>

                            <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_transports">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Export Transports</span>
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
        <th>Asset</th>
        <th>Employee</th>
        <th>Document Date</th>
        <th>Document Number</th>
        <th>Is Handed</th>
        <th>Options</th>
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

<import-transport @importTransportSuccess = "impSucc" />

<div class="modal fade" id="modal-default-transport">
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
              <button type="button" class="btn btn-danger" @click="delete_transport">Delete</button>
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
import TransportModal from '../components/TransportModel.vue'
import ImportTransport from '../components/ImportTransportModel.vue'
import TransportInfo from '../components/TransportInfo.vue'
import $ from 'jquery';

export default{
  components: { TransportModal, ImportTransport, TransportInfo },

    data:() => ({
        transportCounts: '',
        transportArrs: [],
        transportId: '',
        deleteId: '',
    }),
    methods:{
      async impSucc(value){
        if(value == true){
          $('#transport-import-modal').modal('hide');
         await this.getTransports();
        }
      },
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
      openImportTransport(){
        $('#transport-import-modal').modal('show');
      },
      openShowTransport(){
        $('#transport-show-modal').modal('show');
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
        this.deleteId = deleteIndex;
        $('#modal-default-transport').modal('show');
      },
      async delete_transport(){
            await this.axios.delete(this.$store.state.apiTransport +'/'+ this.deleteId).then(res =>{
              $('#modal-default-transport').modal('hide');
              this.deleteId = '';
              this.useToastr().success('Transport Deleted Successfully');
              this.getTransports();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      },

    async mounted(){
     await this.getTransports();
    },
    watch:{
        transportIndex(newId, oldId){
        this.transportId = newId;
      }
    },
}
</script>  