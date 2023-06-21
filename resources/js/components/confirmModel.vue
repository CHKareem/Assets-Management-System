<template>
          <div class="modal fade" id="modal-default-type">
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
              <button type="button" class="btn btn-danger" @click="accept_delete_type">Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->





</template>

<script>


export default{
  data:() =>({
    deletedType: false,
  }),
  methods:{
    accept_delete_type(){
      // console.log(this.deleted);
      this.deletedType = true;
      // console.log(this.deleted);
      this.$emit('deleteType', this.deletedType);
      this.deletedType = false;
    }
  }
}

</script>