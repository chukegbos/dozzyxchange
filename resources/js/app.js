require('./bootstrap');

window.Vue = require('vue');


import moment from 'moment';
import {
    Form,
    HasError,
    AlertError
} from 'vform';
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '4px'
})

window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);



import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 7000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast = Toast;

let Fuse = new Vue();
window.Fuse = Fuse;


import CKEditor from 'ckeditor4-vue';
Vue.use(CKEditor);

Vue.component('InfiniteLoading', require('vue-infinite-loading'));
import DashboardComponent from './components/DashboardComponent.vue';
import ServiceComponent from './components/ServiceComponent.vue';
import CryptoComponent from './components/CryptoComponent.vue';
import AirtimeComponent from './components/AirtimeComponent.vue';
import BuyCoinComponent from './components/BuyCoinComponent.vue';
import SellCoinComponent from './components/SellCoinComponent.vue';
import NetworkInvoiceComponent from './components/NetworkInvoiceComponent.vue';
import TransactionAirtimeComponent from './components/TransactionAirtimeComponent.vue';
import TransactionCryptoComponent from './components/TransactionCryptoComponent.vue';
import ConfirmEmailComponent from './components/ConfirmEmailComponent.vue';
import WalletComponent from './components/WalletComponent.vue';
import AccountComponent from './components/AccountComponent.vue';
import ProfileComponent from './components/ProfileComponent.vue';
import PasswordComponent from './components/PasswordComponent.vue';
import RateComponent from './components/RateComponent.vue';

let routes = [
    {
        path: '/home',
        component: DashboardComponent
    },

    {
        path: '/',
        component: DashboardComponent
    },
    {
        path: '/user',
        component: ProfileComponent
    },

    {
        path: '/password',
        component: PasswordComponent
    },

    {
        path: '/confirm-email',
        component: ConfirmEmailComponent
    },

    {
        path: '/services',
        component: ServiceComponent
    },

    {
        path: '/wallet',
        component: WalletComponent
    },

    {
        path: '/account',
        component: AccountComponent
    },

    {
        path: '/rates',
        component: RateComponent
    },

    {
        path: '/services/crypto',
        component: CryptoComponent
    },

    {
        path: '/services/airtime',
        component: AirtimeComponent
    },

    {
        path: '/transaction/airtime',
        component: TransactionAirtimeComponent
    },


    {
        path: '/transaction/crypto',
        component: TransactionCryptoComponent
    },


    {
        path: '/buycoin/:id',
        component: BuyCoinComponent
    },

    {
        path: '/sellcoin/:id',
        component: SellCoinComponent
    },

    {
        path: '/network/invoice/:ref_id',
        component: NetworkInvoiceComponent
    },
]


const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1);
})

Vue.filter('myDate', function (created) {
    if (!created) return ''
    return moment(created).format('MMMM Do YYYY');
})

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: '',
    },
    methods: {
        searchit() {
            Fuse.$emit('searching');
        }
    }
});
