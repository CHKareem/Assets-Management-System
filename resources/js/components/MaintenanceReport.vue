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
                  <span>Export Custom Maintenances</span>
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
    serial_id:'',
    serialNumber:'',
    employee_id:'',
    fullName:'',
    search_serial : [],
    search_employee:[],
    maintenanceCode:'',
    filterMaintenances:[],
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
      await this.axios.get(this.$store.state.apiAsset, {params:{ codeNamaa : this.asset_id }}).then(res =>{
        this.search_asset = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getSerialNumberName(code, id){
      this.serial_id = id;
      this.serialNumber = code;
      this.getFilterMaintenance(id);
      this.search_serial = [];
    },
    async getSerialNumberData(){
      this.search_serial = [];
      await this.axios.get(this.$store.state.apiSerialSearch, {params:{ serialNumber : this.serial_id }}).then(res =>{
        this.search_serial = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    getEmployeeName(name, id){
      this.employee_id = id;
      this.fullName = name;
      this.getFilterMaintenance(id);
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
    async getFilterMaintenance(maintenanceId){
      this.maintenanceCode = maintenanceId;
        await this.axios.get(this.$store.state.apiShowMaintenance + '/' + maintenanceId).then(res =>{
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