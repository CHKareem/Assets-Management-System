<template>
    

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-12">
                <div class="card card-primary card-outline">
                <div class="card-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span v-if="itemView">Edit Item</span>
                    <span v-if="!itemView">Add New Item</span>
</h5><br>
<div class="d-flex justify-content-between">
<div class="col-5">
                        <input v-model="item_name" type="text" class="form-control" id="itemName" placeholder="Item Name">
                        </div>
                        <div class="col-5">
                        <input v-model="arabic_item_name" type="text" class="form-control" id="arabicItemName" placeholder="Arabic Item Name">
                        </div>
                        <div class="col">
                        <button v-if="!itemView" class="btn btn-primary" v-on:click="add_item">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Save</span>
                            </button>

                            <button v-if="itemView" class="btn btn-primary" v-on:click="edit_item">
                                <i class="fa fa-plus-circle mr-2"></i>
                        <span>Save Changes</span>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Item Name</th>
                    <th>Arabic Item Name</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(itemArr, key) in itemArrs" :key="key">
                    <td>{{ itemArr.itemName }}</td>
                    <td>{{ itemArr.arabicItemName }}</td>
                    <td>
                    <a href="#" @click="editItemButton(itemArr.id)"> <i class="fa fa-edit mr-2"></i></a>
                    <a href="#" @click="confirm_delete(itemArr.id)"><i class="fa fa-trash text-danger"></i></a>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

            </div>

            </div>

            </div>

            </section>


            <!-- <conf-main @deleteType="getisDeleted" v-show="showModall"/> -->

            <div class="modal fade" id="modal-default-item">
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
              <button type="button" class="btn btn-danger" @click="delete_item">Delete</button>
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
// import ConfMain from "../components/confirmModel.vue"
import $ from 'jquery';


export default{
  // components:{
  //   ConfMain
  // },

  props:['itemSuccess'],

  data:() => ({
    item_name: '',
    arabic_item_name:'',
    // isDeleted: false,
    // showModall: '',
    deleteId: '',
    itemView: false,
    getItemId:'',
    itemArrs: [],
    itemCounts:'',
    apiItem:'http://localhost:8000/api/item',
  }),
  methods:{
    useToastr,
    getisDeleted(value){
      this.isDeleted = value;
      this.delete_item();
    },
    async add_item(){
      let data = {'itemName':this.item_name, 'arabicItemName':this.arabic_item_name};
            await this.axios.post(this.apiItem, data).then(res =>{
              this.item_name = '';
              this.arabic_item_name = '';
              this.useToastr().success('Item Added Successfully');
              this.getItems();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
  async getItems(){
           await this.axios.get(this.apiItem).then(res =>{
           this.itemArrs = res.data;
           this.itemCounts = res.data.length;
           this.$emit('itemCount', this.itemCounts);
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
    //   confirm_delete(deleteIndex){
    //     this.showModall = true;
    //     this.deleteId = deleteIndex;
    //     $('#modal-default-type').modal('show');
    //   },
    //   async delete_item(){
    //     if(this.isDeleted){
    //         await this.axios.delete(this.apiItem +'/'+ this.deleteId).then(res =>{
    //           $('#modal-default-type').modal('hide');
    //           this.showModall = false;
    //           this.deleteId = '';
    //           this.isDeleted = false;
    //           this.useToastr().success('Item Deleted Successfully');
    //           this.getItems();
    //   }).catch((error)=>{
    //     this.useToastr().error('Something Went Wrong');
    //   });
    // }
    //   },
    confirm_delete(deleteIndex){
        this.deleteId = deleteIndex;
        $('#modal-default-item').modal('show');
      },
      async delete_item(){
            await this.axios.delete(this.apiItem +'/'+ this.deleteId).then(res =>{
              $('#modal-default-item').modal('hide');
              this.deleteId = '';
              this.useToastr().success('Item Deleted Successfully');
              this.getItems();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
      },
      async editItemButton(getIndex){
        await this.axios.get(this.apiItem +'/'+ getIndex).then(res =>{
           res.data.map(item=>{
        this.item_name = item.itemName;
        this.arabic_item_name = item.arabicItemName;
        this.getItemId = item.id;
      });
      this.itemView = true;
    });
    },
    async edit_item(){
      let data = {'itemName': this.item_name, 'arabicItemName':this.arabic_item_name};
            await this.axios.put(this.apiItem +'/'+ this.getItemId, data).then(res =>{
              this.item_name = '';
              this.arabic_item_name = '';
              this.useToastr().success('Item Edited Successfully');
              this.itemView = false;
              this.getItems();
      }).catch((error)=>{
        this.useToastr().error('Something Went Wrong');
      });
    },
  },
    async mounted(){
     await this.getItems();
    },
    watch:{
    async itemSuccess(newItem, oldItem){
      if(newItem == true){
        await this.getItems();
      }
  },
},
}

</script>