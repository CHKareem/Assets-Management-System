<template>
    
    <div class="modal fade" id="type-import-modal" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{this.$store.state.appLanguage == 'en' ? $t('impType'): $t('impType')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

    <form id="typeForm">

           
<div class="modal-body">
    <div class="form-row">
        <div class="form-group col">
            <label for="file1" class="drop-container">
<span class="drop-title">{{$t('drop')}}</span>
or
<input type="file" id="file1" name="file" required>
</label>

<button type="submit" class="btn btn-primary" @click.prevent="import_file"><i class="fa fa-save mr-1"></i>
            <span>{{$t('impFile')}}</span>
    </button>
        </div>
    </div>
</div>


</form>

</div>


</div>

</div>

</div>

</template>


<script>
import { useToastr } from '../toastr.js'
import $ from 'jquery';

export default{

  data:() => ({
    dd:[],
    apiType:'http://localhost:8000/api/type',
  }),
  methods:{
    useToastr,
    async import_file(){
        let data = new FormData($('#typeForm')[0]);
        await this.axios.post(this.apiType +'/import_types', data).then(res =>{
              this.useToastr().success('Types Added Successfully');
              this.$emit('importTypeSuccess', true);
      }).catch((error)=>{
        // this.errors = error.response.data.errors
        this.useToastr().error(error.response.data.errors);
      });
    },
  }

}
</script>

<style scoped>


.drop-container {
  position: relative;
  display: flex;
  gap: 10px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 200px;
  padding: 20px;
  border-radius: 10px;
  border: 2px dashed #555;
  color: #444;
  cursor: pointer;
  transition: background .2s ease-in-out, border .2s ease-in-out;
}

.drop-container:hover {
  background: #eee;
  border-color: #111;
}

.drop-container:hover .drop-title {
  color: #222;
}

.drop-title {
  color: #444;
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  transition: color .2s ease-in-out;
}

input[type=file] {
  width: 450px;
  max-width: 100%;
  color: #444;
  padding: 5px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid #555;
}

input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #084cdf;
  padding: 8px 10px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}

</style>

