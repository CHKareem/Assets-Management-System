<template>
    
    <section class="content">
          <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="modal-title mt-2 mb-3 ml-2">{{ $t('filter') }}</h5>
        </div>
    </div>

    <div class="row">
    
    <div class="col-12">

                      <a class="btn btn-primary col-md-auto mb-3 mt-2" :href="'/export_custom_temp_transport/' + transport_type + '/' + first_date + '/' + second_date">
                          <i class="fa fa-plus-circle mr-2"></i>
                  <span>{{ $t('expCustomTempTransport') }}</span>
                      </a>


                      <a class="btn btn-primary col-md-auto mb-3 mt-2 float-right" :href="'/export_word_report_temp_transport/' + transport_type + '/' + first_date + '/' + second_date">
                          <i class="fa fa-plus-circle mr-2"></i>
                  <span>{{ $t('expCustomPrintTempTransport') }}</span>
                      </a>

</div>

</div>

    <div class="row">
        <div class="modal-body">
                  <div class="form-row">

                      <div class="form-group col-md-4">
                            <label for="firstDate">{{ $t('firstDate') }}</label>
                            <input v-model="first_date" type="text" class="form-control" id="firstDate" :placeholder="$t('firstDate')" onfocus="(this.type='date')">
                          </div>
    
                          <div class="form-group col-md-4">
                            <label for="secondDate">{{ $t('secondDate') }}</label>
                            <input v-model="second_date" type="text" class="form-control" id="secondDate" :placeholder="$t('secondDate')" onfocus="(this.type='date')">
                          </div>

                          <div class="form-group col-md-4">
                      <label for="transportType" class="ml-1">{{ $t('docType') }}</label>
                      <div class="search-box">
      <input type="text" :placeholder="$t('docType')" v-model="transport_type" @keyup="getTransportTypeData" autocomplete="off" class="form-control" id="transportType" />          
        <ul>
          <li @click="getTransportTypeName(transportType.documentType)" v-for="(transportType, index) in search_transortsType" :key="index" v-text="transportType.documentType"></li>
        </ul>
      </div>
                      </div>


                    </div>

                    <a class="btn btn-danger col-md-auto float-right mr-3" @click="resetValues">
                          <i class="fas fa-undo mr-2"></i>
                  <span>{{ $t('resetValues') }}</span>
                      </a>

                      <p class="card-title float-none">{{ $t('numberOfTransports') }} <b class="text-primary">{{ filterTransports.length }}</b></p><br>

                      <br>
                    <div v-for="transport in filterTransports" :key="transport.id" >
                      <div class="card text-center">
            <div class="card-header">
                <b><img class="fa-solid fa-map-pin mr-2"></b>
                <h5 class="card-title float-none" v-if="transport.assets.codeNamaa == null">{{ $t('codeNamaa') }}: <b> -- </b></h5>
                <h5 class="card-title float-none" v-else>{{ $t('codeNamaa') }}: <b>{{ transport.assets.codeNamaa }}</b></h5>
                <h5 class="card-title float-none" v-if="transport.assets.serialNumber == null">{{ $t('serNumber') }}: <b> -- </b></h5>
                <h5 class="card-title float-none" v-else>{{ $t('serNumber') }}: <b>{{ transport.assets.serialNumber }}</b></h5>
  </div>
  <div class="card-body">
    <h5 class="card-title float-none">{{ $t('itemName') }}: <b class="ml-2">{{ transport.assets.items.itemName }}</b></h5>
    <h5 class="card-title float-none">{{ $t('typeName') }}: <b class="ml-2">{{ transport.assets.types.typeName }}</b></h5>
    <h5 class="card-title float-none">{{ $t('description') }}: <b class="ml-2">{{ transport.assets.description}}</b></h5>
    <h5 class="card-title float-none" v-if="transport.employee_id == null">{{ $t('empName') }}: <b class="ml-2"> -- </b></h5>
    <h5 class="card-title float-none" v-else>{{ $t('empName') }}: <b class="ml-2">{{ transport.employees.fullName }}</b></h5>
    <h5 class="card-title float-none" v-if="transport.employee_prev_id == null">{{ $t('prevEmpName') }}: <b class="ml-2"> -- </b></h5>
    <h5 class="card-title float-none" v-else>{{ $t('prevEmpName') }}: <b class="ml-2">{{ transport.prevs.fullName }}</b></h5>
    <h5 class="card-title float-none">{{ $t('transportDate') }}: <b class="ml-2">{{ transport.transportDate}}</b></h5>
    <h5 class="card-title float-none" v-if="transport.position_id == null">{{ $t('position') }}: <b class="ml-2"> -- </b></h5>
    <h5 class="card-title float-none" v-else>{{ $t('position') }}: <b class="ml-2">{{ transport.positions.positionName}}</b></h5>
    <h5 class="card-title float-none">{{ $t('department') }}: <b class="ml-2">{{ transport.departments.departmentName}}</b></h5>
    <h5 class="card-title float-none">{{ $t('center') }}: <b class="ml-2">{{ transport.centers.centerName}}</b></h5>
    <h5 class="card-title float-none">{{ $t('docType') }}: <b class="ml-2">{{ transport.documentType}}</b></h5>
    <h5 class="card-title float-none">{{ $t('docNumber') }}: <b class="ml-2">{{ transport.documentNumber}}</b></h5>
    <h5 class="card-title float-none">{{ $t('handed') }}: <b class="ml-2">{{ transport.isHanded == 1 ? 'Yes' : 'No'}}</b></h5>

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
    first_date:'',
    second_date:'',
    transport_type:'',
    search_transortsType:[],
    filterTransports:[],
}),
  methods:{
    useToastr,
    resetValues(){
      this.transport_type = '';
      this.first_date = '';
      this.second_date = '';
      this.filterTransports = [];
    },

    getTransportTypeName(transportType){
        // getFilterTransport(transportType);
        this.transport_type = transportType;
        this.getFilterTransport(transportType);
      this.search_transortsType = [];
    },
    async getTransportTypeData(){
      this.search_transortsType = [];
      await this.axios.get(this.$store.state.apiTransportType, {params:{ documentType : this.transport_type }}).then(res =>{
        this.search_transortsType = res.data;
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
    async getFilterTransport(){
        await this.axios.get(this.$store.state.apiShowTempTransport + '/' + this.transport_type+ '/' + this.first_date + '/' + this.second_date).then(res =>{
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