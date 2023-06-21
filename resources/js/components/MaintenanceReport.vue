<template>
    
    <section class="content">
          <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="modal-title mt-2 mb-3 ml-2">Filter Data Using</h5>
        </div>
    </div>

    <div class="row">
        <div class="modal-body">
                  <div class="form-row">

                    <div class="form-group col-md-4">
                      <label for="assetId" class="ml-1">Code Namaa</label>
                      <div class="search-box">
      <input type="text" placeholder="Code Namaa" v-model="asset_id" @keyup="getAssetData" autocomplete="off" class="form-control" id="assetId" />          
        <ul>
          <li @click="getAssetName(asset.codeNamaa, asset.id)" v-for="asset in search_asset" :key="asset.id" v-text="asset.codeNamaa"></li>
        </ul>
        <p>{{ codeNamaa }}</p>
      </div>
                      </div>


                    </div>

                    <div v-for="maintenance in filterMaintenances" :key="maintenance.id" >
                <p>{{ maintenance.sendDate }}</p>
            </div>

                    </div>
                    </div>
                    </div>
                    </section>
</template>

<script>

import { useToastr } from '../toastr.js'

export default ({

data:() => ({
    asset_id:'',
    codeNamaa:'',
    search_asset : [],
    filterMaintenances:[],
    apiAsset:'http://localhost:8000/api/codeSearch',
    apiMaintenance: 'http://localhost:8000/api/showMaintenances',
}),
  methods:{
    useToastr,
    getAssetName(code, id){
      this.asset_id = id;
      this.codeNamaa = code;
      this.getFilterMaintenance(id);
      this.search_asset = [];
    },
    async getAssetData(){
      this.search_asset = [];
      await this.axios.get(this.apiAsset, {params:{ codeNamaa : this.asset_id }}).then(res =>{
        this.search_asset = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async getFilterMaintenance(maintenanceId){
        await this.axios.get(this.apiMaintenance + '/' + maintenanceId).then(res =>{
        this.filterMaintenances = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    }
 }

})
</script>

<style scoped>
  .search-box .clear{
        clear:both;
        margin-top: 20px;
    }

    .search-box ul{
        list-style: none;
        padding: 0px;
        width: 100%;
        position: relative;
        margin: 0;
        background: white;
    }

    .search-box ul li{
        background: lavender;
        padding: 4px;
        margin-bottom: 1px;
    }

    .search-box ul li:nth-child(even){
        background: cadetblue;
        color: white;
    }

    .search-box ul li:hover{
        cursor: pointer;
    }

    .search-box input[type=text]{
        padding: 5px;
        width: 100%;
        letter-spacing: 1px;
    }
</style>