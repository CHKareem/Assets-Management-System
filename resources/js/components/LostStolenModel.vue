<template>
    

    <div class="modal fade" id="lostStolen-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="!edit">{{ $t('newLostStolen') }}</h4>
              <h4 class="modal-title" v-else>{{ $t('editLostStolen') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-row">

                <div class="form-group col-md-6">
                      <label for="assetId">{{ $t('codeNamaa') }}</label>
                      <div class="search-box">
                        <input type="text" :placeholder="$t('codeNamaa')" v-model="asset_id" @keyup="getAssetData" autocomplete="off" class="form-control" id="assetId" />          
                            <ul>
                            <li @click="getAssetName(asset.codeNamaa, asset.id)" v-for="asset in search_asset" :key="asset.id" v-text="asset.codeNamaa"></li>
                            </ul>
                            <p>{{ code_namaa }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                      <label for="alterAssetId">{{ $t('alterCodeNamaa') }}</label>
                      <div class="search-box">
                        <input type="text" :placeholder="$t('alterCodeNamaa')" v-model="alter_asset_id" @keyup="getAlterAssetData" autocomplete="off" class="form-control" id="alterAssetId" />          
                            <ul>
                            <li @click="getAlterAssetName(alterAsset.codeNamaa, alterAsset.id)" v-for="alterAsset in search_alter_asset" :key="alterAsset.id" v-text="alterAsset.codeNamaa"></li>
                            </ul>
                            <p>{{ alter_code_namaa }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentNumber">{{ $t('docNumber') }}</label>
                        <input v-model="document_number" type="text" class="form-control" id="documentNumber" :placeholder="$t('docNumber')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="lostDate">{{ $t('lostDate') }}</label>
                        <input v-model="lost_date" type="text" class="form-control" id="lostDate" :placeholder="$t('lostDate')" onfocus="(this.type='date')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="isStolen">{{ $t('stolen') }}</label>
                        <select class="custom-select rounded-0" v-model="is_stolen" id="isStolen">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                        </select>
                      </div>

                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="closed">{{ $t('close') }}</button>
              <button type="button" class="btn btn-info" v-if="!edit" @click="add_lost_stolen">{{ $t('save') }}</button>
              <button type="button" class="btn btn-info" v-else @click="edit_lost_stolen">{{ $t('saveChange') }}</button>
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
import $ from 'jquery'


  export default ({

    props:['lostStolenId'],

  data:() => ({
    search_asset : [],
    search_alter_asset : [],
    asset_id:'',
    alter_asset_id:'',
    edit: false,
    lost_date: '',
    is_stolen: '',
    document_number: '',
    lostStolenIndex: '',
  }),
  methods:{
    useToastr,
    getAssetName(code, id){
      this.asset_id = id;
      this.code_namaa = code;
      this.search_asset = [];
    },
    async getAssetData(){
      this.search_asset = [];
      await this.axios.get(this.$store.state.apiAssetSearch, {params:{ codeNamaa : this.asset_id}}).then(res =>{
        this.search_asset = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getAlterAssetName(code, id){
      this.alter_asset_id = id;
      this.alter_code_namaa = code;
      this.search_alter_asset = [];
    },
    async getAlterAssetData(){
      this.search_alter_asset = [];
      await this.axios.get(this.$store.state.apiAssetSearch, {params:{ codeNamaa : this.alter_asset_id}}).then(res =>{
        this.search_alter_asset = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    closed(){
      $('#lostStolen-modal').modal('hide');
      this.asset_id = '';
                this.alter_asset_id = '';
                this.document_number = '';
                this.lost_date = '';
                this.is_stolen = '';
                this.$emit('sendLostStolenValue', true);
                this.edit = false;
    },
      async edit_lost_stolen(){
        let data = {
          'asset_id': this.asset_id,
          'asset_alter_id': this.alter_asset_id,
          'documentNumber': this.document_number,
          'lostDate': this.lost_date,
          'isStolen': this.is_stolen,
                  };
              await this.axios.put(this.$store.state.apiLostStolen +'/'+ this.lostStolenIndex, data).then(res =>{
                this.useToastr().success('Lost & Stolen Edited Successfully');
                this.closed();
                this.$emit('sendLostStolenValue', true);
        }).catch((error)=>{
          this.useToastr().error('Something Went Wrong');
        });
      },
      async getLostStolenData(lostStolenIndex){
        await this.axios.get(this.$store.state.apiLostStolen +'/'+ lostStolenIndex).then(res =>{
           res.data.map(lostStolen=>{
            this.code_namaa = lostStolen.assets.codeNamaa;
            this.alter_code_namaa = lostStolen.alters.codeNamaa;
            this.asset_id = lostStolen.asset_id;
            this.alter_asset_id = lostStolen.asset_alter_id;
            this.lost_date = lostStolen.lostDate;
            this.is_stolen = lostStolen.isStolen;
            this.document_number = lostStolen.documentNumber;
      });
    }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async add_lost_stolen(){
      let data = {
        'asset_id': this.asset_id,
          'asset_alter_id': this.alter_asset_id,
          'documentNumber': this.document_number,
          'lostDate': this.lost_date,
          'isStolen': this.is_stolen,
                  };
            await this.axios.post(this.$store.state.apiLostStolen, data).then(res =>{
              this.useToastr().success('Lost & Stolen Added Successfully');
              this.closed();
                this.$emit('sendLostStolenValue', true);
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
  },
  watch:{
    async lostStolenId(newLostStolen, oldLostStolen){
      this.lostStolenIndex = newLostStolen;
      this.edit = true;
      await this.getLostStolenData(newLostStolen);
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
