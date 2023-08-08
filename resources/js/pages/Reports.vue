<template>

<br>
    <div class="content">
        <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
                <div class="card card-primary card-outline">
                  
<div class="card-body">
                <!-- Tabs navs -->
                <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex-with-icons-tab-1" data-toggle="tab" href="#ex-with-icons-tabs-1" role="tab"
                    aria-controls="ex-with-icons-tabs-1" aria-selected="true"><i class="far fa-file-code mr-2 fa-fw me-2"></i>{{ $t('codeNamaaReport') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-2" data-toggle="tab" href="#ex-with-icons-tabs-2" role="tab"
                    aria-controls="ex-with-icons-tabs-2" aria-selected="false"><i class="fas fa-tools mr-2 fa-fw me-2"></i>{{ $t('maintenanceReport') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-3" data-toggle="tab" href="#ex-with-icons-tabs-3" role="tab"
                    aria-controls="ex-with-icons-tabs-3" aria-selected="false"><i class="fas fa-people-carry mr-2 fa-fw me-2"></i>{{ $t('transportReport') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-4" data-toggle="tab" href="#ex-with-icons-tabs-4" role="tab"
                    aria-controls="ex-with-icons-tabs-4" aria-selected="false"><i class="fa-solid fa fa-check mr-2 fa-fw me-2"></i>{{ $t('GPReport') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-5" data-toggle="tab" href="#ex-with-icons-tabs-5" role="tab"
                    aria-controls="ex-with-icons-tabs-5" aria-selected="false"><i class="fas fa-people-carry mr-2 fa-fw me-2"></i>{{ $t('tempTransportReport') }}e</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-6" data-toggle="tab" href="#ex-with-icons-tabs-6" role="tab"
                    aria-controls="ex-with-icons-tabs-6" aria-selected="false"><i class="far fa-address-card mr-2 fa-fw me-2"></i>f</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-7" data-toggle="tab" href="#ex-with-icons-tabs-7" role="tab"
                    aria-controls="ex-with-icons-tabs-7" aria-selected="false"><i class="fas fa-exclamation-triangle mr-2 fa-fw me-2"></i>g</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-8" data-toggle="tab" href="#ex-with-icons-tabs-8" role="tab"
                    aria-controls="ex-with-icons-tabs-8" aria-selected="false"><i class="fas fa-money-check-alt mr-2 fa-fw me-2"></i>h</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-9" data-toggle="tab" href="#ex-with-icons-tabs-9" role="tab"
                    aria-controls="ex-with-icons-tabs-9" aria-selected="false"><i class="fas fa-money-check-alt mr-2 fa-fw me-2"></i>i</a>
                </li>
                </ul>
                <!-- Tabs navs -->

                                <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                 <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel" aria-labelledby="ex-with-icons-tab-1"><code-namaa-report /></div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2"><maintenance-report /></div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-3" role="tabpanel" aria-labelledby="ex-with-icons-tab-3"><transport-report /></div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-4" role="tabpanel" aria-labelledby="ex-with-icons-tab-4"><asset-report /></div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-5" role="tabpanel" aria-labelledby="ex-with-icons-tab-5"><temp-transport /></div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-6" role="tabpanel" aria-labelledby="ex-with-icons-tab-6">f</div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-7" role="tabpanel" aria-labelledby="ex-with-icons-tab-7">g</div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-8" role="tabpanel" aria-labelledby="ex-with-icons-tab-8">h</div>

                 <div class="tab-pane fade show" id="ex-with-icons-tabs-9" role="tabpanel" aria-labelledby="ex-with-icons-tab-9">i</div>
</div>

            </div>
</div>

                </div>
</div> 
            </div>     
        </div>

</template>


<script>
import { useToastr } from '../toastr.js'
// import $ from 'jquery'
import CodeNamaaReport from '../components/codeNamaaReport.vue'
import MaintenanceReport from '../components/MaintenanceReport.vue'
import TransportReport from '../components/TransportReport.vue'
import AssetReport from '../components/AssetReport.vue'
import TempTransport from '../components/TempTransport.vue'

  export default ({
components:{CodeNamaaReport, MaintenanceReport, TransportReport, AssetReport, TempTransport},
    // props:['assetId'],

  data:() => ({

  }),
  methods:{
    useToastr,
  }

  })
  </script>
