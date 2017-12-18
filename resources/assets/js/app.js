
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import VModal from 'vue-js-modal';
require('./bootstrap');
// Vue.use(VModal);
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('mobile-money', require('./components/account/mobile.vue'));
Vue.component('transaction-money', require('./components/account/transaction.vue'));
Vue.component('subscription-money', require('./components/account/subscription.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);


const app = new Vue({
    el: '#app'
});



// var app = new Vue ({
//     el: '#mobile',
//     data: {
//      phonenumber:'',
//      message: ' world',
//      textone: 'ok start',
//      htmlone: '<small>mambo</small>',
//      view:false,
//      view2:true 
//     }
// });
// var app2 = new Vue ({
//     el: '#bank',
//     data: {
//      account:'01j2031101200'
//     }
// });