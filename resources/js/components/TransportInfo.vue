<template>
    
    <div class="modal fade" id="transport-info-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Transport Info</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-row">

                    <div class="form-group col-md-12">
                      <label for="codeNamaa">Asset Code</label>
      <output type="text" class="form-control" id="codeNamaa"> {{ code_namaa }} </output>          
                      </div>

                      <div class="form-group col-md-4">
                        <label for="centerId">Center</label>
                        <output type="text" class="form-control" id="centerId"> {{ center_id }} </output>  
                      </div>

                      <div class="form-group col-md-4">
                        <label for="departmentId">Department</label>
                        <output type="text" class="form-control" id="departmentId"> {{ department_id }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="positionId">Position</label>
                        <output type="text" class="form-control" id="positionId"> {{ position_id }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="employeeId">Employee Name</label>
                        <output type="text" class="form-control" id="employeeId"> {{ employee_id }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="prevEmployeeId">Prev Employee Name</label>
                        <output type="text" class="form-control" id="prevEmployeeId"> {{ prev_employee_id }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentType">Document Type</label>
                        <output type="text" class="form-control" id="documentType"> {{ document_type }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentNumber">Document Number</label>
                        <output type="text" class="form-control" id="documentNumber"> {{ document_number }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="isHanded">Is Handed</label>
                         <output type="text" class="form-control" id="isHanded"> {{ is_handed }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="transportDate">Transport Date</label>
                        <output type="text" class="form-control" id="transportDate"> {{ transport_date }} </output>
                      </div>

                      </div>
            </div>

</div>

</div>

</div> 

</template>


<script>

export default ({

props:['transportId'],

data:() => ({
code_namaa:'',
transport_date: '',
is_handed: '',
document_number: '',
document_type: '',
department_id:'',
center_id:'',
employee_id:'',
position_id:'',
prev_employee_id:'',
}),
methods:{
  async getTransportData(transportId){
    await this.axios.get(this.$store.state.apiTransport +'/'+ transportId).then(res =>{
       res.data.map(transport=>{
        this.code_namaa = transport.assets.codeNamaa;
        this.transport_date = transport.transportDate;
        this.is_handed = transport.isHanded == 1 ? 'Yes' : 'No';
        this.document_number = transport.documentNumber;
        this.document_type = transport.documentType;
        this.position_id = transport.position_id == null ? null : transport.positions.positionName;
        this.center_id = transport.centers.centerName;
        this.department_id = transport.departments.departmentName;
        this.employee_id = transport.employee_id == null ? null : transport.employees.fullName;
        this.prev_employee_id = transport.employee_prev_id == null ? null : transport.prevs.fullName;

  });
}).catch((error)=>{
    this.useToastr().error('Something Went Wrong');
  });
},

},

watch:{
    async transportId(newTransport, oldTransport){
      await this.getTransportData(newTransport);
  },
},

})

</script>