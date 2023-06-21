<template>
    <section class="content">
          <div class="container-fluid">
    
    <div class="row">
        <div class="modal-body">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                            <label for="firstDate">First Date</label>
                            <input v-model="first_date" type="text" class="form-control" id="firstDate" placeholder="First Date" onfocus="(this.type='date')">
                          </div>
    
                          <div class="form-group col-md-6">
                            <label for="secondDate">Second Date</label>
                            <input v-model="second_date" type="text" class="form-control" id="secondDate" placeholder="Second Date" onfocus="(this.type='date')">
                          </div>
    </div>
    </div>
    </div>
    
    
    
    
            <div class="row">
    
              <div class="col-12">
    
                                <a class="btn btn-primary col-md-auto mb-3 mt-2" :href="'/export_custom_code_namaa/'+first_date+'/'+second_date">
                                    <i class="fa fa-plus-circle mr-2"></i>
                            <span>Export Custom Code Namaa</span>
                                </a>

        </div>
    
        </div>
        </div>
        </section>
    
    </template>
    
    
    <script>
    import { useToastr } from '../toastr.js'
    // import $ from 'jquery'
    
    
      export default ({
    
        // props:['assetId'],
    
      data:() => ({
        first_date: '',
        second_date:'',
      }),
      methods:{
        useToastr,
      }
    
      })
      </script>
    