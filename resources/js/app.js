
require('./bootstrap');

window.Vue = require('vue');

//importa Snotify
import Snotify from 'vue-snotify'
Vue.use(Snotify, {toast: {showProgressBar: false, timeout: 5000}})

//importa Axios
import Axios from 'axios'
Vue.use(Axios)

//Exemplo de importação de componentes
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app'
});
