<template>
    
    <div class="modal fade" id="asset-info-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $t('assetInfo') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-row">

                    <div class="form-group col-md-3">
                      <label for="itemId">{{ $t('item') }}</label>
      <output type="text" class="form-control" id="itemId"> {{ item_id }} </output>          
                      </div>

                      <div class="form-group col-md-3">
                        <label for="typeId">{{ $t('type') }}</label> 
                        <output type="text" class="form-control" id="typeId"> {{ type_id }} </output>            
                      </div>

                      <div class="form-group col-md-3">
                        <label for="centerId">{{ $t('center') }}</label>
                        <select class="custom-select rounded-0" v-model="center_id" id="centerId" disabled>
                                <option v-for="center in centers" :key="center.id" :value="center_id">{{ center.centerName }}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="departmentId">{{ $t('departement') }}</label>
                         <select class="custom-select rounded-0" v-model="department_id" id="departmentId" disabled>
                                <option v-for="department in departments" :key="department.id" :value="department.id" >{{ department.departmentName }}</option>
                        </select> 
                      </div>

                      <div class="form-group col-md-3">
                        <label for="status">{{ $t('status') }}</label>
                        <output type="text" class="form-control" id="status"> {{ status }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="quantity">{{ $t('quantity') }}</label>
                        <output type="text" class="form-control" id="quantity"> {{ quantity }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="realPrice">{{ $t('reaPrice') }}</label>
                        <output type="text" class="form-control" id="realPrice"> {{ real_price }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="expectedPrice">{{ $t('expPrice') }}</label>
                        <output type="text" class="form-control" id="expectedPrice"> {{ expected_price }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="aquisitionType">{{ $t('aqType') }}</label>
                        <output type="text" class="form-control" id="aquisitionType"> {{ aquisition_type }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="fundedBy">{{ $t('funded') }}</label>
                        <output class="form-control" type="text" id="fundedBy"> {{ funded_by }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="documentNumber">{{ $t('docNumber') }}</label>
                        <output type="text" class="form-control" id="documentNumber"> {{ document_number }} </output>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="inService">{{ $t('serviced') }}</label>
                         <output type="text" class="form-control" id="inService"> {{ in_service }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="aquisitionDate">{{ $t('aqDate') }}</label>
                        <output type="text" class="form-control" id="aquisitionDate"> {{ aquisition_date }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="serialNumber">{{ $t('serNumber') }}</label>
                        <output type="text" class="form-control" id="serialNumber"> {{ serial_number }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="description">{{ $t('description') }}</label>
                        <output type="text" class="form-control" id="description"> {{ description }} </output>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="codeNamaa">{{ $t('codeNamaa') }}</label>
                        <output type="text" class="form-control" id="codeNamaa"> {{ code_namaa }} </output>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="notes">{{ $t('notes') }}</label>
                        <output type="text" class="form-control" id="notes"> {{ notes }} </output>
                      </div>

                      </div>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="closed">{{ $t('close') }}</button>
            </div>

</div>

</div>

</div> 

</template>


<script>

export default ({

props:['assetId'],

data:() => ({
description: '',
item_id: '',
type_id: '',
notes: '',
departments:[],
centers:[],
code_namaa:'',
serial_number: '',
aquisition_date: '',
in_service: '',
document_number: '',
aquisition_type: '',
funded_by: '',
expected_price: '',
real_price: '',
quantity: '',
status: '',
department_id:'',
center_id:'',
}),
methods:{
  async getAssetData(assetId){
    await this.axios.get(this.$store.state.apiAsset +'/'+ assetId).then(res =>{
       res.data.map(asset=>{
        this.item_id = asset.items.itemName;
        this.type_id = asset.types.typeName;
        this.notes = asset.notes;
        this.code_namaa = asset.codeNamaa;
        this.description = asset.description;
        this.serial_number = asset.serialNumber;
        this.aquisition_date = asset.aquisitionDate;
        this.in_service = asset.inService == 1 ? 'In Service' : 'Not In Service';
        this.document_number = asset.documentNumber;
        this.aquisition_type = asset.aquisitionType;
        this.funded_by = asset.fundedBy;
        this.expected_price = asset.expectedPrice;
        this.real_price = asset.realPrice;
        this.quantity = asset.quantity;
        this.status = asset.status;
        let cen = this.code_namaa.slice(0,2);
        let dep = this.code_namaa.slice(2,4);
        if(cen.slice(0,1) == 0){
          this.center_id = cen.slice(1,2);
        }else{
          this.center_id = cen;
        }

        if(dep.slice(0,1) == 0){
          this.department_id = dep.slice(1,2);
        }else{
          this.department_id = dep;
        }

  });
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
      closed(){
      this.item_id = '';
        this.type_id = '';
        this.notes = '';
        this.code_namaa = '';
        this.description = '';
        this.serial_number = '';
        this.aquisition_date = '';
        this.in_service = '';
        this.document_number = '';
        this.center_id = '';
        this.department_id = '';
        this.aquisition_type = '';
        this.funded_by = '';
        this.expected_price = '';
        this.real_price = '';
        this.quantity = '';
        this.status = '';
    },
},
async mounted(){
     await this.getCenters();
     await this.getDepartments();
    },
watch:{
    async assetId(newAsset, oldAsset){
      await this.getAssetData(newAsset);
  },
},

})

</script>