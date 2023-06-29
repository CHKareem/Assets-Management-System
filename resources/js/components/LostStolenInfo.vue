<template>
    
    <div class="modal fade" id="lostStolen-info-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $t('lostStolenInfo') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-row">

                    <div class="form-group col-md-6">
                      <label for="assetId">{{ $t('codeNamaa') }}</label>
      <output type="text" class="form-control" id="assetId"> {{ asset_id }} </output>          
                      </div>

                      <div class="form-group col-md-6">
                        <label for="alterAssetId">{{ $t('alterCodeNamaa') }}</label>
                        <output type="text" class="form-control" id="alterAssetId"> {{ alter_asset_id }} </output>  
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentNumber">{{ $t('docNumber') }}</label>
                        <output type="text" class="form-control" id="documentNumber"> {{ document_number }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="lostDate">{{ $t('lostDate') }}</label>
                        <output type="text" class="form-control" id="lostDate"> {{ lost_date }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="isStolen">{{ $t('stolen') }}</label>
                        <output type="text" class="form-control" id="isStolen"> {{ is_stolen }} </output>
                      </div>

                      </div>
            </div>

</div>

</div>

</div> 

</template>


<script>

export default ({

props:['lostStolenId'],

data:() => ({
    asset_id:'',
    alter_asset_id:'',
    lost_date: '',
    is_stolen: '',
    document_number: '',
}),
methods:{
  async getLostStolenData(lostStolenindex){
    await this.axios.get(this.$store.state.apiLostStolen +'/'+ lostStolenindex).then(res =>{
       res.data.map(lostStolen=>{
            this.asset_id = lostStolen.assets.codeNamaa;
            this.alter_asset_id = lostStolen.alters.codeNamaa;
            this.lost_date = lostStolen.lostDate;
            this.is_stolen = lostStolen.isStolen == 1 ? 'Yes' : 'No';
            this.document_number = lostStolen.documentNumber;
       });
}).catch((error)=>{
    this.useToastr().error('Something Went Wrong');
  });
},

},

watch:{
    async lostStolenId(newLostStolen, oldLostStolen){
      await this.getLostStolenData(newLostStolen);
  },
},

})

</script>