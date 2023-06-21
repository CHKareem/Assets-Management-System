<template>
    

    <div class="modal fade" id="transport-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="!edit">Add New Transport</h4>
              <h4 class="modal-title" v-else>Edit Transport</h4>
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

                      <div class="form-group col-md-3">
                        <label for="positionId">Position</label>
                        <div class="search-box">   
                        <input type="text" placeholder="Position Name" v-model="position_id" @keyup="getPositionData" autocomplete="off" class="form-control" id="positionId" />                 
                            <ul>
                            <li v-for="positions in search_position" :key="positions.id" @click="getPositionName(positions.positionName, positions.id)" v-text="positions.positionName"></li>
                        </ul>
                            <p>{{ positionName }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="centerId">Center</label>
                        <select class="custom-select rounded-0" v-model="center_id" id="centerId">
                                <option v-for="center in centers" :key="center.id" :value="center.id">{{ center.centerName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="departmentId">Department</label>
                        <select class="custom-select rounded-0" v-model="department_id" id="departmentId">
                                <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.departmentName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="employeeId">Employee Name</label>
                        <div class="search-box">   
                        <input type="text" placeholder="Employee Name" v-model="employee_id" @keyup="getEmployeeData" autocomplete="off" class="form-control" id="employeeId" />                 
                            <ul>
                            <li v-for="employees in search_employee" :key="employees.id" @click="getEmployeeName(employees.fullName, employees.id)" v-text="employees.fullName"></li>
                        </ul>
                            <p>{{ fullName }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="prevEmployeeId">Prev Employee Name</label>
                        <div class="search-box">   
                        <input type="text" placeholder="Prev Employee Name" v-model="prev_employee_id" @keyup="getPrevEmployeeData" autocomplete="off" class="form-control" id="prevEmployeeId" />                 
                            <ul>
                            <li v-for="prevEmployees in search_prev_employee" :key="prevEmployees.id" @click="getPrevEmployeeName(prevEmployees.fullName, prevEmployees.id)" v-text="prevEmployees.fullName"></li>
                        </ul>
                            <p>{{ prevFullName }}</p>
                        </div>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="documentNumber">Document Number</label>
                        <input v-model="document_number" type="text" class="form-control" id="documentNumber" placeholder="Document Number">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="isHanded">Is Handed ?</label>
                        <select class="custom-select rounded-0" v-model="is_handed" id="isHanded">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                        </select>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="transportDate">Transport Date</label>
                        <input v-model="transport_date" type="text" class="form-control" id="transportDate" placeholder="Transport Date" onfocus="(this.type='date')">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="documentType">Document Type</label>
                        <input v-model="document_type" type="text" class="form-control" id="documentType" placeholder="Document Type">
                      </div>

                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="closed">Close</button>
              <button type="button" class="btn btn-info" v-if="!edit" @click="add_transport">Save</button>
              <button type="button" class="btn btn-info" v-else @click="edit_transport">Save Changes</button>
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
    asset_id:'',
    code_namaa : '',
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
    transport_date:'',
    document_number:'',
    document_type:'',
    centers:[],
    is_handed:'',
    transportIndex: '',
    department_id:'',
    center_id:'',
    apiAsset:'http://localhost:8000/api/codeSearch',
    apiTransport: 'http://localhost:8000/api/transport',
    apiCenter: 'http://localhost:8000/api/center',
    apiDepartment: 'http://localhost:8000/api/department',
    apiPosition: 'http://localhost:8000/api/position',
    apiEmployee: 'http://localhost:8000/api/employee',
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
      await this.axios.get(this.apiAsset, {params:{ codeNamaa : this.asset_id}}).then(res =>{
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
      await this.axios.get(this.apiPosition, {params:{ positionName : this.position_id}}).then(res =>{
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
      await this.axios.get(this.apiEmployee, {params:{ fullName : this.employee_id}}).then(res =>{
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
      await this.axios.get(this.apiEmployee, {params:{ fullName : this.prev_employee_id}}).then(res =>{
        this.search_prev_employee = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    closed(){
      $('#transport-modal').modal('hide');
      this.asset_id = '',
          this.center_id = '',
          this.department_id = '',
          this.position_id = '',
          this.employee_id = '',
          this.prev_employee_id = '',
          this.document_type = '',
          this.document_number = '',
          this.transport_date = '',
          this.is_handed = '',
          this.positionName = '',
          this.fullName = '',
          this.prevFullName = '',
          this.code_namaa = '',
                this.$emit('yo ', true);
                this.edit = false;
    },
      async edit_transport(){
        let data = {
            'asset_id': this.asset_id,
          'center_id': this.center_id,
          'department_id': this.department_id,
          'position_id': this.position_id,
          'employee_id': this.employee_id,
          'employee_prev_id': this.prev_employee_id,
          'documentType': this.document_type,
          'documentNumber': this.document_number,
          'transportDate': this.transport_date,
          'isHanded': this.is_handed,
                  };
              await this.axios.put(this.apiTransport +'/'+ this.transportIndex, data).then(res =>{
                this.asset_id = '',
          this.center_id = '',
          this.department_id = '',
          this.position_id = '',
          this.employee_id = '',
          this.prev_employee_id = '',
          this.document_type = '',
          this.document_number = '',
          this.transport_date = '',
          this.is_handed = '',
                this.useToastr().success('Asset Edited Successfully');
                // $('#asset-modal').modal('hide');
                this.closed();
                this.$emit('yo', true);
        }).catch((error)=>{
          this.useToastr().error('Something Went Wrong');
        });
      },
      async getTransportData(transportId){
        await this.axios.get(this.apiTransport +'/'+ transportId).then(res =>{
           res.data.map(transport=>{
            this.code_namaa = transport.assets.codeNamaa;
            this.fullName = transport.employees.fullName;
            this.prevFullName = transport.prevs.fullName;
            this.positionName = transport.positions.positionName;
            this.asset_id = transport.asset_id,
          this.center_id = transport.center_id,
          this.department_id = transport.department_id,
          this.position_id = transport.position_id,
          this.employee_id = transport.employee_id,
          this.prev_employee_id = transport.employee_prev_id,
          this.document_type = transport.documentType,
          this.document_number = transport.documentNumber,
          this.transport_date = transport.transportDate,
          this.is_handed = transport.isHanded
      });
    }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async getCenters(){
           await this.axios.get(this.apiCenter).then(res =>{
           this.centers = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      async getDepartments(){
           await this.axios.get(this.apiDepartment).then(res =>{
           this.departments = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      async getPositions(){
           await this.axios.get(this.apiPosition).then(res =>{
           this.positions = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      async getEmployees(){
           await this.axios.get(this.apiEmployee).then(res =>{
           this.employees = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
    async add_transport(){
      let data = {
          'asset_id': this.asset_id,
          'center_id': this.center_id,
          'department_id': this.department_id,
          'position_id': this.position_id,
          'employee_id': this.employee_id,
          'employee_prev_id': this.prev_employee_id,
          'documentType': this.document_type,
          'documentNumber': this.document_number,
          'transportDate': this.transport_date,
          'isHanded': this.is_handed,
                  };
            await this.axios.post(this.apiTransport, data).then(res =>{
          this.asset_id = '',
          this.center_id = '',
          this.department_id = '',
          this.position_id = '',
          this.employee_id = '',
          this.prev_employee_id = '',
          this.document_type = '',
          this.document_number = '',
          this.transport_date = '',
          this.is_handed = '',
          this.positionName = '',
          this.fullName = '',
          this.prevFullName = '',
          this.code_namaa = '',
              this.useToastr().success('Transport Added Successfully');
              this.closed();
                this.$emit('yo', true);
              // $('#asset-modal').modal('hide');
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
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

  </style>
