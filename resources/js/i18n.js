// import Vue from 'vue';
import {createI18n}  from "vue-i18n";
import store from './store.js'
// Vue.use(VueI18n);


const messages = {
    'en': {
        welcomeMsg: 'Welcome to Your Vue.js App',
        transportCount: 'Transports Count',
        newTransport: 'Add New Transport',
        impTransport: 'Import Transport',
        expTransport: 'Export Transport',
    },
    'ar': {
        welcomeMsg: 'مرحبا بكم',
        transportCount: 'عدد التنقلات',
        newTransport: 'إضافة تنقل جديد',
        impTransport: 'استيراد تنقلات',
        expTransport: 'تصدير تنقلات',
    }
};


const i18n = createI18n({
    locale: store.getters.getAppLanguage, // set locale
    fallbackLocale: 'ar', // set fallback locale
    messages, // set locale messages
});

export default i18n;