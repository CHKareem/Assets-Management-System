<template>
   
   <div class="row">

<div class="col-12">
    <div class="small-box bg-info ml-4 mt-4 mr-4">
    <div class="inner">
        <h3> {{ assetCounts }} </h3>
        <p>{{ $t('assetCount') }}</p>
    </div>
    <div class="icon">
        <i class="fa fa-desktop"></i>
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

    <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openAssetModal">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('newAsset') }}</span>
                            </button>

                            <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportModal">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('impAsset') }}</span>
                            </button>

                            <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_assets">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('expAsset') }}</span>
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
        <th>{{ $t('status') }}</th>
        <th>{{ $t('serNumber') }}</th>
        <th>{{ $t('docNumber') }}</th>
        <th>{{ $t('serviced') }}</th>
        <th>{{ $t('options') }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="assetsArr in assetsArrs" :key="assetsArr.id">
        <td>{{ assetsArr.codeNamaa }}</td>
        <td>{{ assetsArr.status }}</td>
        <td>{{ assetsArr.serialNumber }}</td>
        <td>{{ assetsArr.documentNumber }}</td>
        <td>{{ assetsArr.inService == 1 ? 'In Service' : 'Not In Service' }}</td>
        <td>
        <a href="#" @click="editAssetModal(assetsArr.id)"><i class="fa fa-edit mr-2"></i></a>
        <a href="#" @click="confirm_delete(assetsArr.id)"><i class="fa fa-trash text-danger mr-2"></i></a>
        <a href="#" @click="showAssetInfo(assetsArr.id)"><i class="fas fa-info-circle text-success"></i></a>
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

<asset-modal :assetId ="assetId" @sendAssetValue="receivedAssetValue" />

<asset-info :assetId ="assetId" />

<import-modal />

<conf-main />

</template>

<script>
import { useToastr } from '../toastr.js'
import AssetModal from '../components/AssetModal.vue'
import ImportModal from '../components/ImportModal.vue'
import AssetInfo from '../components/AssetInfo.vue'
import $ from 'jquery';
import ConfMain from '../components/confirmModel.vue'

export default{
  components: { AssetModal, ImportModal, AssetInfo, ConfMain },

    data:() => ({
        assetCounts: '',
        assetsArrs: [],
        assetId: '',
        deleteId: '',
    }),
    methods:{
      async receivedAssetValue(value){
        if(value == true){
          $('#asset-modal').modal('hide');
          this.assetId = '';
         await this.getAssets();
        }else{
         await this.getAssets();
        }
      },
    useToastr,
      async getAssets(){
           await this.axios.get(this.$store.state.apiAsset).then(res =>{
           this.assetsArrs = res.data;
           this.assetCounts = res.data.length;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      openAssetModal(){
        $('#asset-modal').modal('show');
      },
      openImportModal(){
        $('#import-modal').modal('show');
        this.$store.state.importUrl = this.$store.state.apiAsset;
              this.$store.state.importFuncLink = '/import_assets';
              this.$store.state.importTitle = 'Import Assets';
      },
      editAssetModal(assetIndex){

            this.assetId = assetIndex;
            $('#asset-modal').modal('show');
    },
    showAssetInfo(assetIndex){
      this.assetId = assetIndex;
            $('#asset-info-modal').modal('show');
    },
    confirm_delete(deleteIndex){
        // this.deleteId = deleteIndex;
        this.$store.state.deleteUrl = this.$store.state.apiAsset;
        this.$store.state.deleteData = deleteIndex;
        $('#modal-default-type').modal('show');
      },
      // async delete_asset(){
      //       await this.axios.delete(this.$store.state.apiAsset +'/'+ this.deleteId).then(res =>{
      //         $('#modal-default-asset').modal('hide');
      //         this.deleteId = '';
      //         this.useToastr().success('Asset Deleted Successfully');
      //         this.getAssets();
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
     await this.getAssets();
    },
    watch:{
      assetIndex(newId, oldId){
        this.assetId = newId;
      },
      async isDeleted(newValue, oldValue){
        if(newValue == true){
              this.useToastr().success('Asset Deleted Successfully');
              this.$store.state.isDeleted = false;
              await this.getAssets();
        }
      },
      async isImported(newValue, oldValue){
        if(newValue == true){
          $('#import-modal').modal('hide');
              this.useToastr().success('Assets Imported Successfully');
              this.$store.state.isImported = false;
              await this.getAssets();
        }
      },
    },
}
</script>  