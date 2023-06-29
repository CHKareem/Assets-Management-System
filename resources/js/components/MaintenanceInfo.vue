<template>
    
    <div class="modal fade" id="maintenance-info-modal" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $t('maintenanceInfo') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closed">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-row">

                    <div class="form-group col-md-4">
                      <label for="codeNamaa">{{ $t('codeNamaa') }}</label>
      <output type="text" class="form-control" id="codeNamaa"> {{ asset_id }} </output>          
                      </div>

                      <div class="form-group col-md-4">
                        <label for="sendDate">{{ $t('sendDate') }}</label>
                        <output type="text" class="form-control" id="sendDate"> {{ send_date }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="receiveDate">{{ $t('receiveDate') }}</label>
                        <output type="text" class="form-control" id="receiveDate"> {{ receive_date }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="statusBefore">{{ $t('statusBefore') }}</label>
                        <output type="text" class="form-control" id="statusBefore"> {{ status_before }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="statusAfter">{{ $t('statusAfter') }}</label>
                        <output type="text" class="form-control" id="statusAfter"> {{ status_after }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentType">{{ $t('docType') }}</label>
                        <output type="text" class="form-control" id="documentType"> {{ document_type }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="documentNumber">{{ $t('docNumber') }}</label>
                        <output type="text" class="form-control" id="documentNumber"> {{ document_number }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="technicalDisclosureNumber">{{ $t('techNumber') }}</label>
                         <output type="text" class="form-control" id="technicalDisclosureNumber"> {{ technical_disclosure_number }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="paymentPrice">{{ $t('payPrice') }}</label>
                        <output type="text" class="form-control" id="paymentPrice"> {{ payment_price }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="isPaid">{{ $t('paid') }}</label>
                        <output type="text" class="form-control" id="isPaid"> {{ is_paid }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="whereMaintained">{{ $t('whereMaintained') }}</label>
                        <output type="text" class="form-control" id="whereMaintained"> {{ where_maintained }} </output>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="reason">{{ $t('reason') }}</label>
                        <output type="text" class="form-control" id="reason"> {{ reason }} </output>
                      </div>

                      <div class="form-group col-md-12">
                        <label for="notes">{{ $t('notes') }}</label>
                        <output type="text" class="form-control" id="notes"> {{ notes }} </output>
                      </div>

                      </div>
            </div>

</div>

</div>

</div> 

</template>


<script>

export default ({

props:['maintenanceId'],

data:() => ({
    asset_id:'',
    send_date:'',
    receive_date:'',
    status_before:'',
    status_after:'',
    document_type:'',
    document_type:'',
    where_maintained:'',
    technical_disclosure_number:'',
    payment_price:'',
    is_paid:'',
    reason:'',
    notes: '',
}),
methods:{
  async getMaintenanceData(maintenanceId){
    await this.axios.get(this.$store.state.apiMaintenance +'/'+ maintenanceId).then(res =>{
       res.data.map(maintenance=>{
        this.asset_id = maintenance.assets.codeNamaa;
            this.send_date = maintenance.sendDate;
            this.receive_date = maintenance.receiveDate;
            this.status_after = maintenance.statusAfter;
            this.status_before = maintenance.statusBefore;
            this.is_paid = maintenance.isPaid == 1 ? 'Yes' : 'No';
            this.where_maintained = maintenance.whereMaintained == 1 ? 'External' : 'Internal';
            this.document_type = maintenance.documentType;
            this.document_number = maintenance.documentNumber;
            this.technical_disclosure_number = maintenance.technicalDisclosureNumber;
            this.payment_price = maintenance.paymentPrice;
            this.reason = maintenance.reason;
            this.notes = maintenance.notes;

  });
}).catch((error)=>{
    this.useToastr().error('Something Went Wrong');
  });
},
},
watch:{
    async maintenanceId(newMaintenance, oldMaintenance){
      await this.getMaintenanceData(newMaintenance);
  },
},

})

</script>