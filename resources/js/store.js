import { createStore } from "vuex";

const store = createStore({
    state(){
        return{
            apiTransport:'http://localhost:8000/api/transport',
            apiAssetSearch:'http://localhost:8000/api/codeSearch',
            apiCenter: 'http://localhost:8000/api/center',
            apiDepartment: 'http://localhost:8000/api/department',
            apiPosition: 'http://localhost:8000/api/position',
            apiEmployee: 'http://localhost:8000/api/employee',
            apiMaintenance:'http://localhost:8000/api/maintenance',
            apiLostStolen:'http://localhost:8000/api/lostStolen',
            apiAsset:'http://localhost:8000/api/asset',
            apiItemSearch: 'http://localhost:8000/api/itemSearch',
            apiTypeSearch: 'http://localhost:8000/api/typeSearch',
            apiType:'http://localhost:8000/api/type',
            apiItem:'http://localhost:8000/api/item',
            apiSerialSearch: 'http://localhost:8000/api/serialSearch',
            apiShowMaintenance: 'http://localhost:8000/api/showMaintenances',
            apiShowTransport: 'http://localhost:8000/api/showTransports',
        };
    },
})

export default store;