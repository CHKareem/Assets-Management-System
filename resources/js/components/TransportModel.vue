<template>
    

    <div class="modal fade" id="transport-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="!edit">{{$t('newTransport')}}</h4>
              <h4 class="modal-title" v-else>{{$t('editTransport')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-row">

                      <div class="form-group col-md-4">
                        <label for="positionId">{{$t('position')}}</label>
                        <div class="search-box">   
                        <input type="text" :placeholder="$t('posName')" v-model="position_id" @keyup="getPositionData" autocomplete="off" class="form-control" id="positionId" />                 
                            <ul>
                            <li v-for="positions in search_position" :key="positions.id" @click="getPositionName(positions.positionName, positions.id)" v-text="positions.positionName"></li>
                        </ul>
                            <p>{{ positionName }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="centerId">{{$t('center')}}</label>
                        <select class="custom-select rounded-0" v-model="center_id" id="centerId">
                                <option v-for="center in centers" :key="center.id" :value="center.id">{{ center.centerName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="departmentId">{{$t('department')}}</label>
                        <select class="custom-select rounded-0" v-model="department_id" id="departmentId">
                                <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.departmentName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-5">
                        <label for="employeeId">{{$t('empName')}}</label>
                        <div class="search-box">   
                        <input type="text" :placeholder="$t('empName')" v-model="employee_id" @keyup="getEmployeeData" autocomplete="off" class="form-control" id="employeeId" />                 
                            <ul>
                            <li v-for="employees in search_employee" :key="employees.id" @click="getEmployeeName(employees.fullName, employees.id)" v-text="employees.fullName"></li>
                        </ul>
                            <p>{{ fullName }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-5">
                        <label for="prevEmployeeId">{{$t('prevEmpName')}}</label>
                        <div class="search-box">   
                        <input type="text" :placeholder="$t('prevEmpName')" v-model="prev_employee_id" @keyup="getPrevEmployeeData" autocomplete="off" class="form-control" id="prevEmployeeId" />                 
                            <ul>
                            <li v-for="prevEmployees in search_prev_employee" :key="prevEmployees.id" @click="getPrevEmployeeName(prevEmployees.fullName, prevEmployees.id)" v-text="prevEmployees.fullName"></li>
                        </ul>
                            <p>{{ prevFullName }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-2">
                        <br>
                      <button class="btn btn-primary mt-2" @click="add_transport_array">
                                <i class="fa fa-plus-circle mr-2"></i>
                                <span>{{$t('addRow')}}</span>
                            </button>
                          </div>

                    </div>
            </div>

            <transition-group name="form-repeater">
                            <div class="modal-body" v-for="(transport, index) in transports" :key="index">
              <div class="form-row">

                <div class="form-group col-md-4">
                      <label for="assetId">{{$t('codeNamaa')}}</label>
                      <div class="search-box">
                        <input type="text" :placeholder="$t('codeNamaa')" v-model="transport.asset_id" @keyup="getAssetData(index)" autocomplete="off" class="form-control" id="assetId" />          
                            <ul>
                            <li @click="getAssetName(asset.codeNamaa, asset.id, index)" v-for="asset in search_asset" :key="asset.id" v-text="asset.codeNamaa"></li>
                            </ul>
                            <p>{{ code_namaa[index] }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentNumber">{{$t('docNumber')}}</label>
                        <input v-model="transport.document_number" type="text" class="form-control" id="documentNumber" :placeholder="$t('docNumber')">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="isHanded">{{$t('handed')}}</label>
                        <select class="custom-select rounded-0" v-model="transport.is_handed" id="isHanded">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                        </select>
                      </div>

                      <div class="form-group col-md-5">
                        <label for="transportDate">{{$t('transportDate')}}</label>
                        <input v-model="transport.transport_date" type="text" class="form-control" id="transportDate" :placeholder="$t('transportDate')" onfocus="(this.type='date')">
                      </div>

                      <div class="form-group col-md-5">
                        <label for="documentType">{{$t('docType')}}</label>
                        <input v-model="transport.document_type" type="text" class="form-control" id="documentType" :placeholder="$t('docType')">
                      </div>

                      <div class="form-group col-md-2">
                        <br>
                        <button class="btn btn-danger mt-2" @click="delete_transport_array(index)">
                                <i class="fa fa-trash mr-2"></i>
                                <span>{{$t('deleteRow')}}</span>
                            </button>
                      </div>

                      <br><hr style="width:95%; height:1px; background: rgba(0,0,0,.2); margin-top: 2em; margin-bottom: 1em;"><br>
                </div>
                </div>
                </transition-group>
                    
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="closed">{{$t('close')}}</button>
              <button type="button" class="btn btn-info" v-if="!edit" @click="add_transport">{{$t('save')}}</button>
              <button type="button" class="btn btn-info" v-else @click="edit_transport">{{$t('saveChange')}}</button>
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

    props:['transportId'],

  data:() => ({
    code_namaa : [],
    positionName : '',
    fullName:'',
    prevFullName:'',
    employee_id:'',
    prev_employee_id:'',
    search_asset : [],
    search_position : [],
    search_employee:[],
    search_prev_employee:[],
    edit: false,
    departments:[],
    centers:[],
    transportIndex: '',
    department_id:'',
    center_id:'',
    transports:[],
  }),
  methods:{
    useToastr,
    getAssetName(code, id, index){
      this.transports[index].asset_id = id;
      this.code_namaa[index] = code;
      this.search_asset = [];
    },
    async getAssetData(index){
      this.search_asset = [];
      await this.axios.get(this.$store.state.apiAssetSearch, {params:{ codeNamaa : this.transports[index].asset_id }}).then(res =>{
        this.search_asset = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getPositionName(name, id){
      this.position_id = id;
      this.positionName = name;
      this.search_position = [];
    },
    async getPositionData(){
      this.search_position = [];
      await this.axios.get(this.$store.state.apiPosition, {params:{ positionName : this.position_id}}).then(res =>{
        this.search_position = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getEmployeeName(name, id){
      this.employee_id = id;
      this.fullName = name;
      this.search_employee = [];
    },
    async getEmployeeData(){
      this.search_employee = [];
      await this.axios.get(this.$store.state.apiEmployee, {params:{ fullName : this.employee_id}}).then(res =>{
        this.search_employee = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getPrevEmployeeName(name, id){
      this.prev_employee_id = id;
      this.prevFullName = name;
      this.search_prev_employee = [];
    },
    async getPrevEmployeeData(){
      this.search_prev_employee = [];
      await this.axios.get(this.$store.state.apiEmployee, {params:{ fullName : this.prev_employee_id}}).then(res =>{
        this.search_prev_employee = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    closed(){
      $('#transport-modal').modal('hide');
      this.transports = [],
          this.center_id = '',
          this.department_id = '',
          this.position_id = '',
          this.employee_id = '',
          this.prev_employee_id = '',
          this.positionName = '',
          this.fullName = '',
          this.prevFullName = '',
          this.code_namaa = '',
                this.$emit('sendTransportValue ', true);
                this.edit = false;
    },
      async edit_transport(){
        let data = {
          'center_id': this.center_id,
          'department_id': this.department_id,
          'position_id': this.position_id,
          'employee_id': this.employee_id,
          'employee_prev_id': this.prev_employee_id,
          'transports':this.transports,
          };
              await this.axios.put(this.$store.state.apiTransport +'/'+ this.transportIndex, data).then(res =>{
          // this.center_id = '',
          // this.department_id = '',
          // this.position_id = '',
          // this.employee_id = '',
          // this.prev_employee_id = '',
          // this.transports = [],
                this.useToastr().success('Transport Edited Successfully');
                this.closed();
                this.$emit('sendTransportValue', true);
        }).catch((error)=>{
          this.useToastr().error('Something Went Wrong');
        });
      },
      async getTransportData(transportId){
        await this.axios.get(this.$store.state.apiTransport +'/'+ transportId).then(res =>{
           res.data.map(transport=>{
                this.transports = [{
      asset_id:'',
    transport_date:'',
    document_number:'',
    document_type:'',
    is_handed:'',
    }];
            this.fullName = transport.employee_id == null ? null : transport.employees.fullName;
            this.prevFullName = transport.employee_prev_id == null ? null : transport.prevs.fullName;
            this.positionName = transport.position_id == null ? null : transport.positions.positionName;
          this.center_id = transport.center_id,
          this.department_id = transport.department_id,
          this.position_id = transport.position_id,
          this.employee_id = transport.employee_id,
          this.prev_employee_id = transport.employee_prev_id,
          this.transports = [{
            'asset_id': transport.asset_id,
            'document_type':transport.documentType,
            'document_number':transport.documentNumber,
            'transport_date':transport.transportDate,
            'is_handed':transport.isHanded,
          }]
      })
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
      async getPositions(){
           await this.axios.get(this.$store.state.apiPosition).then(res =>{
           this.positions = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      async getEmployees(){
           await this.axios.get(this.$store.state.apiEmployee).then(res =>{
           this.employees = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
    async add_transport(){
      let data = {
          'center_id': this.center_id,
          'department_id': this.department_id,
          'position_id': this.position_id,
          'employee_id': this.employee_id,
          'employee_prev_id': this.prev_employee_id,
          'transports': this.transports,
                  };
            await this.axios.post(this.$store.state.apiTransport, data).then(res =>{
          // this.center_id = '',
          // this.department_id = '',
          // this.position_id = '',
          // this.employee_id = '',
          // this.prev_employee_id = '',
          // this.transports = [{
          //   asset_id:'',
          // transport_date:'',
          // document_number:'',
          // document_type:'',
          // is_handed:'',
          // }],
          // // this.positionName = '',
          // // this.fullName = '',
          // // this.prevFullName = '',
          // // this.code_namaa = '',
              this.useToastr().success('Transport Added Successfully');
              this.closed();
                this.$emit('sendTransportValue', true);
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    add_transport_array(){
      this.transports.push({
        asset_id:'',
    transport_date:'',
    document_number:'',
    document_type:'',
    is_handed:'',
      });
    },
    delete_transport_array(index){
      this.transports.splice(index, 1);
    },
  },
  watch:{
    async transportId(newTransport, oldTransport){
        this.transportIndex = newTransport;
      this.edit = true;
      await this.getTransportData(newTransport);
    },
  },
  async mounted(){
     await this.getCenters();
     await this.getDepartments();
     await this.getPositions();
     await this.getEmployees();
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

    .form-repeater-enter-from{
      opacity: 0;
      transform: scale(0.6);
    }
    .form-repeater-enter-to{
      opacity: 1;
      transform: scale(1);
    }
    .form-repeater-enter-active{
      transition: all 0.4s ease;
    }
    .form-repeater-leave-from{
      opacity: 1;
      transform: scale(1);
    }
    .form-repeater-leave-to{
      opacity: 0;
      transform: scale(0.6);
    }
    .form-repeater-leave-active{
      transition: all 0.4s ease;
      position: relative;
    }

    .form-repeater-move{
      transition: all 0.3s ease;
    }

  </style>
