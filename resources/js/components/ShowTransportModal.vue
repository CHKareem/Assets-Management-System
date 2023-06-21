<template>
    
    <div class="modal fade" id="transport-show-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Asset Info</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">

                <div class="form-row">

<div class="form-group col-md-3">
  <label for="assetId">Code Namaa</label>
  <div class="search-box">
    <input type="text" placeholder="Code Namaa" v-model="asset_id" @keyup="getAssetData" autocomplete="off" class="form-control" id="assetId" />          
        <ul>
        <li @click="getAssetName(asset.codeNamaa, asset.id)" v-for="asset in search_asset" :key="asset.id" v-text="asset.codeNamaa"></li>
        </ul>
        <p>{{ code_namaa }}</p>
    </div>
  </div>
  </div>

  <div v-for="transport in transports" :key="transport.id" >
                <p>{{ transport.transportDate }}</p>
            </div>
            </div>
            
</div>

</div>

</div> 

</template>


<script>

export default ({


data:() => ({
    asset_id:'',
    code_namaa:'',
    search_asset : [],
    transports:[],
    apiAsset:'http://localhost:8000/api/codeSearch',
    apiTransport: 'http://localhost:8000/api/showTransports',
}),
methods:{

    getAssetName(code, id){
      this.asset_id = id;
      this.code_namaa = code;
      this.getTransportData(id);
      this.search_asset = [];
    },
    async getAssetData(){
      this.search_asset = [];
      await this.axios.get(this.apiAsset, {params:{ codeNamaa : this.asset_id}}).then(res =>{
        this.search_asset = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async getTransportData(transportId){
        await this.axios.get(this.apiTransport +'/'+ transportId).then(res =>{
            this.transports = res.data;
    //        this.transports =  res.data.map(transport=>{
    //         this.code_namaa = transport.assets.codeNamaa;
    //         this.fullName = transport.employees.fullName;
    //         this.prevFullName = transport.prevs.fullName;
    //         this.positionName = transport.positions.positionName;
    //         this.asset_id = transport.asset_id,
    //       this.center_id = transport.center_id,
    //       this.department_id = transport.department_id,
    //       this.position_id = transport.position_id,
    //       this.employee_id = transport.employee_id,
    //       this.prev_employee_id = transport.employee_prev_id,
    //       this.document_type = transport.documentType,
    //       this.document_number = transport.documentNumber,
    //       this.transport_date = transport.transportDate,
    //       this.is_handed = transport.isHanded
    //   });
    }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
},

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