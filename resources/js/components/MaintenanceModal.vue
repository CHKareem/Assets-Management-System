<template>
    

    <div class="modal fade" id="maintenance-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="!edit">{{ $t('newMaintenance') }}</h4>
              <h4 class="modal-title" v-else>{{ $t('editMaintenance') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-row">

                    <div class="form-group col-md-4">
                      <label for="assetId">{{ $t('codeNamaa') }}</label>
                      <div class="search-box">
      <input type="text" :placeholder="$t('codeNamaa')" v-model="asset_id" @keyup="getAssetData" autocomplete="off" class="form-control" id="assetId" />          
        <ul>
          <li @click="getAssetName(asset.codeNamaa, asset.id)" v-for="asset in search_asset" :key="asset.id" v-text="asset.codeNamaa"></li>
        </ul>
        <p>{{ codeNamaa }}</p>
      </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="sendDate">{{ $t('sendDate') }}</label>
                        <input v-model="send_date" type="text" class="form-control" id="sendDate" :placeholder="$t('sendDate')" onfocus="(this.type='date')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="receiveDate">{{ $t('receiveDate') }}</label>
                        <input v-model="receive_date" type="text" class="form-control" id="receiveDate" :placeholder="$t('receiveDate')" onfocus="(this.type='date')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="statusBefore">{{ $t('statusBefore') }}</label>
                        <input v-model="status_before" type="text" class="form-control" id="statusBefore" :placeholder="$t('statusBefore')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="statusAfter">{{ $t('statusAfter') }}</label>
                        <input v-model="status_after" type="text" class="form-control" id="statusAfter" :placeholder="$t('statusAfter')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentType">{{ $t('docType') }}</label>
                        <input v-model="document_type" type="text" class="form-control" id="documentType" :placeholder="$t('docType')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentNumber">{{ $t('docNumber') }}</label>
                        <input v-model="document_number" type="text" class="form-control" id="documentNumber" :placeholder="$t('docNumber')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="technicalDisclosureNumber">{{ $t('techNumber') }}</label>
                        <input v-model="technical_disclosure_number" type="text" class="form-control" id="technicalDisclosureNumber" :placeholder="$t('techNumber')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="paymentPrice">{{ $t('payPrice') }}</label>
                        <input v-model="payment_price" type="text" class="form-control" id="paymentPrice" :placeholder="$t('payPrice')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="isPaid">{{ $t('paid') }}</label>
                        <select class="custom-select rounded-0" v-model="is_paid" id="isPaid">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="whereMaintained">{{ $t('whereMaintained') }}</label>
                        <select class="custom-select rounded-0" v-model="where_maintained" id="whereMaintained">
                                <option value="0">Internal</option>
                                <option value="1">External</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="reason">{{ $t('reason') }}</label>
                        <input v-model="reason" type="text" class="form-control" id="reason" :placeholder="$t('reason')">
                      </div>

                      <div class="form-group col-md-12">
                        <label for="notes">{{ $t('notes') }}</label>
                        <textarea v-model="notes" cols="5" rows="4" class="form-control" id="notes" :placeholder="$t('notes')"></textarea>
                      </div>

                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="closed">{{ $t('close') }}</button>
              <button type="button" class="btn btn-info" v-if="!edit" @click="add_maintenance">{{ $t('save') }}</button>
              <button type="button" class="btn btn-info" v-else @click="edit_maintenance">{{ $t('saveChange') }}</button>
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

    props:['maintenanceId'],

  data:() => ({
    codeNamaa : '',
    asset_id:'',
    send_date:'',
    receive_date:'',
    status_before:'',
    status_after:'',
    document_type:'',
    where_maintained:'',
    document_type:'',
    technical_disclosure_number:'',
    payment_price:'',
    is_paid:'',
    reason:'',
    search_asset : [],
    edit: false,
    notes: '',
    maintenanceIndex: '',
  }),
  methods:{
    useToastr,
    getAssetName(name, id){
      this.asset_id = id;
      this.codeNamaa = name;
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
    closed(){
      $('#maintenance-modal').modal('hide');
                this.asset_id = '';
                this.send_date = '';
                this.receive_date = '';
                this.status_after = '';
                this.status_before = '';
                this.is_paid = '';
                this.document_number = '';
                this.document_type = '';
                this.technical_disclosure_number = '';
                this.where_maintained = '';
                this.payment_price = '';
                this.reason = '';
                this.notes = '';
                this.codeNamaa = '';
                this.$emit('sendMaintenanceValue ', true);
                this.edit = false;
    },
      async edit_maintenance(){
        let data = {
          'asset_id': this.asset_id,
          'sendDate': this.send_date,
          'receiveDate': this.receive_date,
          'statusAfter': this.status_after,
          'statusBefore': this.status_before,
          'isPaid': this.is_paid,
          'whereMaintained': this.where_maintained,
          'documentType': this.document_type,
          'documentNumber': this.document_number,
          'technicalDisclosureNumber': this.technical_disclosure_number,
          'paymentPrice': this.payment_price,
          'reason': this.reason,
          'notes': this.notes,
                  };
              await this.axios.put(this.$store.state.apiMaintenance +'/'+ this.maintenanceIndex, data).then(res =>{
                this.useToastr().success('Maintenance Edited Successfully');
                this.closed();
                this.$emit('sendMaintenanceValue', true);
        }).catch((error)=>{
          this.useToastr().error('Something Went Wrong');
        });
      },
      async getMaintenanceData(maintenanceIndex){
        await this.axios.get(this.$store.state.apiMaintenance +'/'+ maintenanceIndex).then(res =>{
           res.data.map(maintenance=>{
            this.asset_id = maintenance.asset_id;
            this.send_date = maintenance.sendDate;
            this.receive_date = maintenance.receiveDate;
            this.status_after = maintenance.statusAfter;
            this.status_before = maintenance.statusBefore;
            this.is_paid = maintenance.isPaid;
            this.where_maintained = maintenance.whereMaintained;
            this.document_type = maintenance.documentType;
            this.document_number = maintenance.documentNumber;
            this.technical_disclosure_number = maintenance.technicalDisclosureNumber;
            this.payment_price = maintenance.paymentPrice;
            this.reason = maintenance.reason;
            this.notes = maintenance.notes;
            this.codeNamaa = maintenance.assets.codeNamaa;

      });
    }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async add_maintenance(){
      let data = {
        'asset_id': this.asset_id,
          'sendDate': this.send_date,
          'receiveDate': this.receive_date,
          'statusAfter': this.status_after,
          'statusBefore': this.status_before,
          'isPaid': this.is_paid,
          'whereMaintained':this.where_maintained,
          'documentType': this.document_type,
          'documentNumber': this.document_number,
          'technicalDisclosureNumber': this.technical_disclosure_number,
          'paymentPrice': this.payment_price,
          'reason': this.reason,
          'notes': this.notes,
                  };
            await this.axios.post(this.$store.state.apiMaintenance, data).then(res =>{
              this.useToastr().success('Maintenance Added Successfully');
              this.closed();
                this.$emit('sendMaintenanceValue', true);
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
  },
  watch:{
    async maintenanceId(newMaintenance, oldMaintenance){
        this.maintenanceIndex = newMaintenance;
      this.edit = true;
      await this.getMaintenanceData(newMaintenance);
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
