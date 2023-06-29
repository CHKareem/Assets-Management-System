<template>
    

    <section class="content">
      <div class="container-fluid">

        <div class="row">

          <div class="col-12">
                <div class="card card-primary card-outline">
                <div class="card-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span v-if="typeView">{{ $t('editType') }}</span>
                    <span v-if="!typeView">{{ $t('newType') }}</span>
</h5><br>
<div class="d-flex justify-content-between">
<div class="col-5">
                        <input v-model="type_name" type="text" class="form-control" id="typeName" :placeholder="$t('typeName')">
                        </div>
                        <div class="col-5">
                        <input v-model="arabic_type_name" type="text" class="form-control" id="arabicTypeName" :placeholder="$t('arabicTypeName')">
                        </div>
                        <div class="col">
                        <button v-if="!typeView" class="btn btn-primary" v-on:click="add_type">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('save') }}</span>
                            </button>

                            <button v-if="typeView" class="btn btn-primary" v-on:click="edit_type">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>{{ $t('saveChange') }}</span>
                            </button>
</div>
</div>
                    </div>
                    </div>
                    </div>


          <div class="col-12">


            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ $t('typeName') }}</th>
                    <th>{{ $t('arabicTypeName') }}</th>
                    <th>{{ $t('options') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(typeArr, key) in typeArrs" :key="key">
                    <td>{{ typeArr.typeName }}</td>
                    <td>{{ typeArr.arabicTypeName }}</td>
                    <td>
                    <a href="#" @click="editTypeButton(typeArr.id)"> <i class="fa fa-edit mr-2"></i></a>
                    <a href="#" @click="confirm_delete(typeArr.id)"><i class="fa fa-trash text-danger"></i></a>
                </td>
                  </tr>
                  <tfoot></tfoot>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

            </div>

            </div>

            </div>

            </section>

            <conf-main />


            
            <!-- <conf-main @deleteType="getisDeleted" /> -->


            <!-- <div class="modal fade" id="modal-default-types">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p> Are You Sure You Want To Delete ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-danger" @click="delete_type">Delete</button>
            </div>
          </div> -->
          <!-- /.modal-content -->
        <!-- </div> -->
        <!-- /.modal-dialog -->
      <!-- </div> -->
      <!-- /.modal -->

</template>


<script>
import { useToastr } from '../toastr.js'
import ConfMain from "../components/confirmModel.vue"
import $ from 'jquery';

export default{
  components:{
    ConfMain
  },

  props:['typeSuccess'],

  data:() => ({
    type_name: '',
    arabic_type_name:'',
    // isDeleted: false,
    // showModal: false,
    deleteId: '',
    typeView: false,
    getTypeId:'',
    typeArrs:[],
    typeCounts:'',
  }),
  methods:{
    // getisDeleted(value){
    //   this.isDeleted = value;
    //   this.delete_type();
    // },
    useToastr,
    async add_type(){
      let data = {'typeName':this.type_name, 'arabicTypeName':this.arabic_type_name};
            await this.axios.post(this.$store.state.apiType, data).then(res =>{
              this.type_name = '';
              this.arabic_type_name = '';
              this.useToastr().success('Type Added Successfully');
              this.getTypes();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
      async getTypes(){
           await this.axios.get(this.$store.state.apiType).then(res =>{
           this.typeArrs = res.data;
           this.typeCounts = res.data.length;
           this.$emit('typeCount', this.typeCounts);
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      // confirm_delete(deleteIndex){
      //   this.showModal = true;
      //   this.deleteId = deleteIndex;
      //   $('#modal-default-type').modal('show');
      // },
        confirm_delete(deleteIndex){
        // this.deleteId = deleteIndex;
        this.$store.state.deleteUrl = this.$store.state.apiType;
        this.$store.state.deleteData = deleteIndex;
        // console.log(this.deleteId, deleteIndex);
        $('#modal-default-type').modal('show');
        // if(this.$store.state.isDeleted == true){
        //       this.useToastr().success('Type Deleted Successfully');
        //       this.$store.state.isDeleted = false;
        //       this.getTypes();
        // }
      },
    //   async delete_type(){
    //     if(this.isDeleted){
    //         await this.axios.delete(this.apiType +'/'+ this.deleteId).then(res =>{
    //           $('#modal-default-type').modal('hide');
    //           this.showModal = false;
    //           this.deleteId = '';
    //           this.isDeleted = false;
    //           this.useToastr().success('Type Deleted Successfully');
    //           this.getTypes();
    //   }).catch((error)=>{
    //     this.useToastr().error('Something Went Wrong');
    //   });
    // }
    //   },
      //     async delete_type(){
      //       await this.axios.delete(this.$store.state.apiType +'/'+ this.deleteId).then(res =>{
      //         $('#modal-default-type').modal('hide');
      //         this.deleteId = '';
      //         this.useToastr().success('Type Deleted Successfully');
      //         this.getTypes();
      // }).catch((error)=>{
      //   this.useToastr().error('Something Went Wrong');
      // });
      // },
    async editTypeButton(getIndex){
        await this.axios.get(this.$store.state.apiType +'/'+ getIndex).then(res =>{
           res.data.map(type=>{
        this.type_name = type.typeName;
        this.arabic_type_name = type.arabicTypeName;
        this.getTypeId = type.id;
      });
      this.typeView = true;
    });
    },
    async edit_type(){
      let data = {'typeName': this.type_name, 'arabicTypeName':this.arabic_type_name};
            await this.axios.put(this.$store.state.apiType +'/'+ this.getTypeId, data).then(res =>{
              this.type_name = '';
              this.arabic_type_name = '';
              this.useToastr().success('Type Edited Successfully');
              this.typeView = false;
              this.getTypes();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
  },
  computed:{
    isDeleted(){
      return this.$store.state.isDeleted;
    }
  },
    async mounted(){
     await this.getTypes();
    },
    watch:{
    async typeSuccess(newType, oldType){
      if(newType == true){
        await this.getTypes();
      }
  },
  async isDeleted(newValue, oldValue){
        if(newValue == true){
              this.useToastr().success('Type Deleted Successfully');
              this.$store.state.isDeleted = false;
              await this.getTypes();
        }
      },
},
}

</script>