<template>
    

    <div class="modal fade" id="asset-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="!edit">{{ $t('newAsset') }}</h4>
              <h4 class="modal-title" v-else>{{ $t('editAsset') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-row">

                    <div class="form-group col-md-3">
                      <label for="itemId">{{ $t('item') }}</label>
                      <div class="search-box">
      <input type="text" :placeholder="$t('itemName')" v-model="item_id" @keyup="getItemData" autocomplete="off" class="form-control" id="itemId" />          
        <ul>
          <li @click="getItemName(item.itemName, item.id)" v-for="item in search_item" :key="item.id" v-text="item.itemName"></li>
        </ul>
        <p>{{ itemName }}</p>
      </div>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="typeId">{{ $t('type') }}</label>
                        <div class="search-box">   
                        <input type="text" :placeholder="$t('typeName')" v-model="type_id" @keyup="getTypeData" autocomplete="off" class="form-control" id="typeId" />                 
        <ul>
          <li v-for="types in search_type" :key="types.id" @click="getTypeName(types.typeName, types.id)" v-text="types.typeName"></li>
    </ul>
        <p>{{ typeName }}</p>
      </div>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="centerId">{{ $t('center') }}</label>
                        <select class="custom-select rounded-0" v-model="center_id" id="centerId">
                                <option v-for="center in centers" :key="center.id" :value="center.id">{{ center.centerName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="departmentId">{{ $t('department') }}</label>
                        <select class="custom-select rounded-0" v-model="department_id" id="departmentId">
                                <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.departmentName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="status">{{ $t('status') }}</label>
                        <input v-model="status" type="text" class="form-control" id="status" :placeholder="$t('status')">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="quantity">{{ $t('quantity') }}</label>
                        <input v-model="quantity" type="text" class="form-control" id="quantity" :placeholder="$t('quantity')"><br>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="realPrice">{{ $t('reaPrice') }}</label>
                        <input v-model="real_price" type="text" class="form-control" id="realPrice" :placeholder="$t('reaPrice')">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="expectedPrice">{{ $t('expPrice') }}</label>
                        <input v-model="expected_price" type="text" class="form-control" id="expectedPrice" :placeholder="$t('expPrice')">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="aquisitionType">{{ $t('aqType') }}</label>
                        <input v-model="aquisition_type" type="text" class="form-control" id="aquisitionType" :placeholder="$t('aqType')">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="fundedBy">{{ $t('funded') }}</label>
                        <select class="custom-select rounded-0" v-model="funded_by" id="fundedBy">
                                <option value="Procured Directly By U.N.H.C.R">Procured Directly By U.N.H.C.R</option>
                                <option value="U.N.H.C.R-Funded Project">U.N.H.C.R-Funded Project</option>
                                <option value="Transfered From Other Partners">Transfered From Other Partners</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="documentNumber">{{ $t('docNumber') }}</label>
                        <input v-model="document_number" type="text" class="form-control" id="documentNumber" :placeholder="$t('docNumber')">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="inService">{{ $t('serviced') }}</label>
                        <select class="custom-select rounded-0" v-model="in_service" id="inService">
                                <option value="0">Not In Service</option>
                                <option value="1">In Service</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="aquisitionDate">{{ $t('aqDate') }}</label>
                        <input v-model="aquisition_date" type="text" class="form-control" id="aquisitionDate" :placeholder="$t('aqDate')" onfocus="(this.type='date')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="serialNumber">{{ $t('serNumber') }}</label>
                        <input v-model="serial_number" type="text" class="form-control" id="serialNumber" :placeholder="$t('serNumber')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="description">{{ $t('description') }}</label>
                        <input v-model="description" type="text" class="form-control" id="description" :placeholder="$t('description')">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="codeNamaa">{{ $t('codeNamaa') }}</label>
                        <input v-if="!edit" v-model="code_namaa" type="text" class="form-control" id="codeNamaa" :placeholder="$t('codeNamaa')">
                        <input v-else v-model="code_namaa_edit" type="text" class="form-control" id="codeNamaa" :placeholder="$t('codeNamaa')">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="notes">{{ $t('notes') }}</label>
                        <input v-model="notes" type="text" class="form-control" id="notes" :placeholder="$t('notes')">
                      </div>

                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="closed">{{ $t('close') }}</button>
              <button type="button" class="btn btn-info" v-if="!edit" @click="add_asset">{{ $t('save') }}</button>
              <button type="button" class="btn btn-info" v-else @click="edit_asset">{{ $t('saveChange') }}</button>
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

    props:['assetId'],

  data:() => ({
    itemName : '',
    typeName : '',
    description: '',
    search_item : [],
    search_type : [],
    edit: false,
    item_id: '',
    type_id: '',
    notes: '',
    departments:[],
    centers:[],
    code_namaa: [],
    code_namaa_edit:'',
    serial_number: '',
    aquisition_date: '',
    in_service: '',
    document_number: '',
    aquisition_type: '',
    funded_by: '',
    expected_price: '',
    real_price: '',
    quantity: '',
    status: '',
    assetIndex: '',
    department_id:'',
    center_id:'',
    aa:'',
    bb:'',
    cc:'',
    dd:'',
    ee:[],
  }),
  methods:{
    useToastr,
    getItemName(name, id){
      this.item_id = id;
      this.itemName = name;
      this.search_item = [];
    },
    async getItemData(){
      this.search_item = [];
      await this.axios.get(this.$store.state.apiItemSearch, {params:{ itemName : this.item_id}}).then(res =>{
        this.search_item = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getTypeName(name, id){
      this.type_id = id;
      this.typeName = name;
      this.search_type = [];
    },
    async getTypeData(){
      this.search_type = [];
      await this.axios.get(this.$store.state.apiTypeSearch, {params:{ typeName : this.type_id}}).then(res =>{
        this.search_type = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    abcde(){
      this.code_namaa = [];
      for(let i=0; i<this.ee.length; i++){
        this.code_namaa.push(this.aa + this.bb + this.cc + this.dd + this.ee[i]);
      }
    },
    closed(){
      $('#asset-modal').modal('hide');
      this.item_id = '';
                this.type_id = '';
                this.notes = '';
                this.code_namaa = [];
                this.serial_number = '';
                this.aquisition_date = '';
                this.in_service = '';
                this.document_number = '';
                this.aquisition_type = '';
                this.funded_by = '';
                this.expected_price = '';
                this.real_price = '';
                this.quantity = '';
                this.status = '';
                this.code_namaa_edit = '';
                this.$emit('sendAssetValue ', true);
                this.edit = false;
    },
      async edit_asset(){
        let data = {
          'item_id': this.item_id,
          'type_id': this.type_id,
          'notes': this.notes,
          'codeNamaa': this.code_namaa_edit,
          'serialNumber': this.serial_number,
          'description': this.description,
          'aquisitionDate': this.aquisition_date,
          'inService': this.in_service,
          'documentNumber': this.document_number,
          'aquisitionType': this.aquisition_type,
          'fundedBy': this.funded_by,
          'expectedPrice': this.expected_price,
          'realPrice': this.real_price,
          'quantity': this.quantity,
          'status': this.status,
                  };
              await this.axios.put(this.$store.state.apiAsset +'/'+ this.assetIndex, data).then(res =>{
                this.useToastr().success('Asset Edited Successfully');
                this.closed();
                this.$emit('sendAssetValue', true);
        }).catch((error)=>{
          this.useToastr().error('Something Went Wrong');
        });
      },
      async getAssetData(assetIndex){
        this.closed();
        await this.axios.get(this.$store.state.apiAsset +'/'+ assetIndex).then(res =>{
           res.data.map(asset=>{
            this.item_id = asset.item_id;
            this.type_id = asset.type_id;
            this.itemName = asset.items.itemName;
            this. typeName = asset.types.typeName;
            this.notes = asset.notes;
            this.code_namaa_edit = asset.codeNamaa;
            this.description = asset.description;
            this.serial_number = asset.serialNumber;
            this.aquisition_date = asset.aquisitionDate;
            this.in_service = asset.inService;
            this.document_number = asset.documentNumber;
            this.aquisition_type = asset.aquisitionType;
            this.funded_by = asset.fundedBy;
            this.expected_price = asset.expectedPrice;
            this.real_price = asset.realPrice;
            this.quantity = asset.quantity;
            this.status = asset.status;
            let cen = this.code_namaa_edit.slice(0,2);
            let dep = this.code_namaa_edit.slice(2,4);
            console.log(cen, dep);
            if(cen.slice(0,1) == 0){
              this.center_id = cen.slice(1,2);
            }else{
              this.center_id = cen;
            }

            if(dep.slice(0,1) == 0){
              this.department_id = dep.slice(1,2);
            }else{
              this.department_id = dep;
            }

      });
    }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async getCenters(){
           await this.axios.get(this.$store.state.apiCenter).then(res =>{
           this.centers = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      async getDepartments(){
           await this.axios.get(this.$store.state.apiDepartment).then(res =>{
           this.departments = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
    async add_asset(){
      let data = {
          'item_id': this.item_id,
          'type_id': this.type_id,
          'notes': this.notes,
          'codeNamaa': this.code_namaa,
          'serialNumber': this.serial_number,
          'aquisitionDate': this.aquisition_date,
          'inService': this.in_service,
          'documentNumber': this.document_number,
          'aquisitionType': this.aquisition_type,
          'fundedBy': this.funded_by,
          'expectedPrice': this.expected_price,
          'realPrice': this.real_price,
          'quantity': this.quantity,
          'status': this.status,
          'description':this.description,
                  };
            await this.axios.post(this.$store.state.apiAsset, data).then(res =>{
              this.useToastr().success('Asset Added Successfully');
              this.closed();
                this.$emit('sendAssetValue', true);
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
  },
  watch:{
    async assetId(newAsset, oldAsset){
        this.assetIndex = newAsset;
      this.edit = true;
      await this.getAssetData(newAsset);
  },
          item_id(newItem, oldItem){
        if(newItem >= 1 && newItem <= 9){
      this.cc = '0' + '0' + newItem;
    }if(newItem >= 10 && newItem <= 99 ){
      this.cc = '0' + newItem ;
    }if(newItem >= 100){
      this.cc = newItem;
    }
            this.abcde();
          },
          type_id(newType, oldType){
            if(newType >= 1 && newType <= 9){
            this.dd = '0' + newType;
          }if(newType >= 10){
            this.dd = newType ;
          }
            this.abcde();
          },
          center_id(newCenter, oldCenter){
            if(newCenter >= 1 && newCenter <= 9){
            this.aa = '0' + newCenter;
          }if(newCenter >= 10){
            this.aa = newCenter ;
          }
            this.abcde();
          },
          department_id(newDep, oldDep){
            if(newDep >= 1 && newDep <= 9){
            this.bb = '0' + newDep;
          }if(newDep >= 10){
            this.bb = newDep ;
          }
            this.abcde();
          },
          quantity(newQuan, oldQuan){
            if(newQuan != oldQuan){
              this.ee = [];
            if(newQuan >= 1){
              for(let i = 0; i < newQuan; i++){
              if(i >= 0 && i <= 9){
                let ii = Array.from(String(i), Number);
                this.ee.push('0' + '0' + ii);
              }if(i >= 10 && i <= 99){
                this.ee.push('0' + i);
                // this.ee = '0' + i ;
              }if(i >= 100 && i <= 999){
                this.ee.push(i);
              }
                this.abcde();
             }
            }
          }
          },
  },
  async mounted(){
     await this.getCenters();
     await this.getDepartments();
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
