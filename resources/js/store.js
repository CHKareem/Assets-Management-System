import { createStore } from "vuex"
import createPersistedState from "vuex-persistedstate";

const store = createStore({
    state(){
        return{
            appLanguage: localStorage.getItem("appLanguage") || 'en',
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
            apiShowTempTransport: 'http://localhost:8000/api/showTempTransports',
            apiTransportType: 'http://localhost:8000/api/transportTypeSearch',
            apiLogin: 'http://localhost:8000/api/login',
                deleteUrl: '',
                deleteData: '',
                isDeleted: false,
                importUrl: '',
                importTitle: '',
                importFuncLink: '',
                isImported: false,
                user: '',

        };
    },
    plugins: [createPersistedState()],
    getters: {
        getAppLanguage: (state) => state.appLanguage,
        isAuthenticated: (state) => '' || state.user,
        userState: (state) => state.user,
      },
      mutations: {
        setAppLanguage(state, language) {
            localStorage.removeItem("appLanguage");
          state.appLanguage = language.locale;
          localStorage.setItem("appLanguage", language.locale);
        },
        setUser(state, data){
            state.user = data.stateOfUser;
        }
    }

})

export default store;