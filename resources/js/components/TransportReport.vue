<template>
    
    <section class="content">
          <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="modal-title mt-2 mb-3 ml-2">Filter Data Using</h5>
        </div>
    </div>

    <div class="row">
    
    <div class="col-12">

                      <a class="btn btn-primary col-md-auto mb-3 mt-2" :href="'/export_custom_transport/'+transportCode">
                          <i class="fa fa-plus-circle mr-2"></i>
                  <span>Export Custom Transport</span>
                      </a>

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


                      <div class="form-group col-md-4">
                      <label for="serialId" class="ml-1">Serial Number</label>
                      <div class="search-box">
      <input type="text" placeholder="Serial Number" v-model="serial_id" @keyup="getSerialNumberData" autocomplete="off" class="form-control" id="serialId" />          
        <ul>
          <li @click="getSerialNumberName(serial.serialNumber, serial.id)" v-for="serial in search_serial" :key="serial.id" v-text="serial.serialNumber"></li>
        </ul>
        <p>{{ serialNumber }}</p>
      </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="employeeId" class="ml-1">Employee Name</label>
                        <div class="search-box">   
                        <input type="text" placeholder="Employee Name" v-model="employee_id" @keyup="getEmployeeData" autocomplete="off" class="form-control" id="employeeId" />                 
                            <ul>
                            <li v-for="employees in search_employee" :key="employees.id" @click="getEmployeeName(employees.fullName, employees.id)" v-text="employees.fullName"></li>
                        </ul>
                            <p>{{ fullName }}</p>
                        </div>
                      </div>

                    </div>

                    <div v-for="transport in filterTransports" :key="transport.id" >
                      <div class="card text-center">
            <div class="card-header">
                <b><img class="fa-solid fa-map-pin mr-2"></b>
                <h5 class="card-title float-none" v-if="transport.assets.codeNamaa == null">Asset Code: <b> -- </b></h5>
                <h5 class="card-title float-none" v-else>Asset Code: <b>{{ transport.assets.codeNamaa }}</b></h5>
                <h5 class="card-title float-none" v-if="transport.assets.serialNumber == null">Serial Number: <b> -- </b></h5>
                <h5 class="card-title float-none" v-else>Serial Number: <b>{{ transport.assets.serialNumber }}</b></h5>
  </div>
  <div class="card-body">
    <h5 class="card-title float-none">Item Name: <b class="ml-2">{{ transport.assets.items.itemName }}</b></h5>
    <h5 class="card-title float-none">Type Name: <b class="ml-2">{{ transport.assets.types.typeName }}</b></h5>
    <h5 class="card-title float-none">Description: <b class="ml-2">{{ transport.assets.description}}</b></h5>
    <h5 class="card-title float-none" v-if="transport.employee_id == null">Employee Name: <b class="ml-2"> -- </b></h5>
    <h5 class="card-title float-none" v-else>Employee Name: <b class="ml-2">{{ transport.employees.fullName }}</b></h5>
    <h5 class="card-title float-none" v-if="transport.employee_prev_id == null">Prev Employee Name: <b class="ml-2"> -- </b></h5>
    <h5 class="card-title float-none" v-else>Prev Employee Name: <b class="ml-2">{{ transport.prevs.fullName }}</b></h5>
    <h5 class="card-title float-none">Transport Date: <b class="ml-2">{{ transport.transportDate}}</b></h5>
    <h5 class="card-title float-none" v-if="transport.position_id == null">Position: <b class="ml-2"> -- </b></h5>
    <h5 class="card-title float-none" v-else>Position: <b class="ml-2">{{ transport.positions.positionName}}</b></h5>
    <h5 class="card-title float-none">Department: <b class="ml-2">{{ transport.departments.departmentName}}</b></h5>
    <h5 class="card-title float-none">Center: <b class="ml-2">{{ transport.centers.centerName}}</b></h5>
    <h5 class="card-title float-none">Document Type: <b class="ml-2">{{ transport.documentType}}</b></h5>
    <h5 class="card-title float-none">Document Number: <b class="ml-2">{{ transport.documentNumber}}</b></h5>
    <h5 class="card-title float-none">Is Handed: <b class="ml-2">{{ transport.isHanded == 1 ? 'Yes' : 'No'}}</b></h5>

  </div>
</div>
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
    serial_id:'',
    serialNumber:'',
    employee_id:'',
    fullName:'',
    search_asset : [],
    search_serial : [],
    search_employee:[],
    filterTransports:[],
    transportCode:'',
    apiAsset:'http://localhost:8000/api/codeSearch',
    apiEmployee: 'http://localhost:8000/api/employee',
    apiSerial: 'http://localhost:8000/api/serialSearch',
    apiTransport: 'http://localhost:8000/api/showTransports',
}),
  methods:{
    useToastr,
    getAssetName(code, id){
      this.asset_id = id;
      this.codeNamaa = code;
      this.getFilterTransport(id);
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
    getSerialNumberName(code, id){
      this.serial_id = id;
      this.serialNumber = code;
      this.getFilterTransport(id);
      this.search_serial = [];
    },
    async getSerialNumberData(){
      this.search_serial = [];
      await this.axios.get(this.apiSerial, {params:{ serialNumber : this.serial_id }}).then(res =>{
        this.search_serial = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getEmployeeName(name, id){
      this.employee_id = id;
      this.fullName = name;
      this.getFilterTransport(id);
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
    async getFilterTransport(transportId){
      this.transportCode = transportId;
        await this.axios.get(this.apiTransport + '/' + transportId).then(res =>{
        this.filterTransports = res.data;
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