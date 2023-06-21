<template>
            <div class="row">

<div class="col-6">
    <div class="small-box bg-info ml-4 mt-4">
    <div class="inner">
        <h3> {{ itemCounts }} </h3>
        <p>Item Count</p>
    </div>
    <div class="icon">
        <i class="fas fa-microchip"></i>
    </div>
    </div>
</div>

<div class="col-6">
    <div class="small-box bg-info mr-4 mt-4">
    <div class="inner">
        <h3> {{ typeCounts }} </h3>
        <p>Type Count</p>
    </div>
    <div class="icon">
        <i class="fas fa-microchip"></i>
    </div>
    </div>
</div>
</div>

<section class="content">
  <div class="container-fluid">
<div class="row">
<div class="col-12">
      <div class="card card-primary card-outline">
      <div class="card-header">
<div class="row justify-content-between">

  <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportItem">
                      <i class="fa fa-plus-circle mr-2"></i>
              <span>Import Items</span>
                  </button>

                  <button class="btn btn-primary col-md-auto mb-3 mt-2" @click="openImportType">
                      <i class="fa fa-plus-circle mr-2"></i>
              <span>Import Types</span>
                  </button>

                  <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_items">
                      <i class="fa fa-plus-circle mr-2"></i>
              <span>Export Items</span>
                  </a>

                  <a class="btn btn-primary col-md-auto mb-3 mt-2" href="/export_types">
                      <i class="fa fa-plus-circle mr-2"></i>
              <span>Export Types</span>
                  </a>


</div>
</div>
</div>
</div>
</div>
</div>
</section>


    <item-main @itemCount="getItemCount" :itemSuccess="itemSuccess" />
    <div class="dropdown-divider"></div>
    <type-main @typeCount="getTypeCount" :typeSuccess="typeSuccess" />

    <!-- <conf-main /> -->
    <item-import @importItemSuccess = "impItemSucc" />

    <type-import @importTypeSuccess = "impTypeSucc" />


</template>


<script>

import  ItemMain from '../components/Item.vue';
import TypeMain from "../components/Type.vue";
import ItemImport from '../components/ImportItemModel.vue';
import TypeImport from '../components/ImportTypeModel.vue';
import $ from 'jquery';
// import ConfMain from "../components/confirmModel.vue";

export default {

  components:{
    ItemMain,
    TypeMain,
    ItemImport,
    TypeImport
    // ConfMain

  },
  data:() => ({
    itemCounts:'',
    typeCounts:'',
    itemSuccess:'',
    typeSuccess:'',
  }),
  methods:{
     getItemCount(value){
      this.itemCounts = value;
    },
    getTypeCount(value){
      this.typeCounts = value;
    },
    openImportItem(){
        $('#item-import-modal').modal('show');
      },
      openImportType(){
        $('#type-import-modal').modal('show');
      },
      impItemSucc(value){
        if(value == true){
          $('#item-import-modal').modal('hide');
          this.itemSuccess = true;
        }
      },
      impTypeSucc(value){
        if(value == true){
          $('#type-import-modal').modal('hide');
          this.typeSuccess = true;
        }
      },
  }
}
</script>