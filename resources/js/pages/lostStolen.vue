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

                            <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportLostStolen">
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

<lost-stolen-model :lostStolenId ="lostStolenId" @yo="yo" />

<lost-stolen-info :lostStolenId ="lostStolenId" />

<import-lost-stolen @importLostStolenSuccess = "impSucc" />

<div class="modal fade" id="modal-default-lostStolen">
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
              <button type="button" class="btn btn-danger" @click="delete_lostStolen">Delete</button>
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
import LostStolenModel from '../components/LostStolenModel.vue'
import ImportLostStolen from '../components/ImportLostStolenModel.vue'
import LostStolenInfo from '../components/LostStolenInfo.vue'
import $ from 'jquery';

export default{
  components: { ImportLostStolen, LostStolenInfo, LostStolenModel },

    data:() => ({
        lostStolenCounts: '',
        lostStolenArrs: [],
        lostStolenId: '',
        deleteId: '',
        apiLostStolen:'http://localhost:8000/api/lostStolen',
    }),
    methods:{
      async impSucc(value){
        if(value == true){
          $('#lostStolen-import-modal').modal('hide');
         await this.getLostStolens();
        }
      },
      async yo(value){
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
           await this.axios.get(this.apiLostStolen).then(res =>{
            // console.log(res.data);
           this.lostStolenArrs = res.data;
           this.lostStolenCounts = res.data.length;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      openLostStolenModal(){
        $('#lostStolen-modal').modal('show');
      },
      openImportLostStolen(){
        $('#lostStolen-import-modal').modal('show');
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
        this.deleteId = deleteIndex;
        $('#modal-default-lostStolen').modal('show');
      },
      async delete_lostStolen(){
            await this.axios.delete(this.apiLostStolen +'/'+ this.deleteId).then(res =>{
              $('#modal-default-lostStolen').modal('hide');
              this.deleteId = '';
              this.useToastr().success('Lost & Stolen Deleted Successfully');
              this.getLostStolens();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
    async export_file(){
        await this.axios.get(this.apiAsset +'/export_employees').then(res =>{
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });

    },
    pp(){
      window.location.href='/api/asset/export_employees'
    }
      },

    async mounted(){
     await this.getLostStolens();
    },
    watch:{
        lostStolenIndex(newId, oldId){
        this.lostStolenId = newId;
      }
    },
}
</script>  