
require('./bootstrap');

window.Vue = require('vue');

//importa Snotify
import Snotify from 'vue-snotify'
Vue.use(Snotify, {toast: {showProgressBar: false, timeout: 5000}})

//importa Axios
import Axios from 'axios'
Vue.use(Axios)

//Importação de componentes
Vue.component('form-helpdesk-component', require('./components/helpdesk/FormHelpDeskComponent.vue').default);
Vue.component('categorie-helpdesk-component', require('./components/categories/CategorieHelpDeskComponent.vue').default);
Vue.component('categorie-archive-component', require('./components/categories/CategorieArchiveComponent.vue').default);
Vue.component('categorie-article-component', require('./components/categories/CategorieArticleComponent.vue').default);
Vue.component('categorie-equipament-component', require('./components/categories/CategorieEquipamentComponent.vue').default);
Vue.component('form-categorie-component', require('./components/categories/FormCategorieComponent.vue').default);


const app = new Vue({
    el: '#app'
});

$(document).ready(function(){
    $('select').formSelect();
    $('.sidenav').sidenav();
    $('.dropdown-trigger').dropdown();
    $('.collapsible').collapsible();
    $('.tabs').tabs();
    $('.modal').modal();

    $('#telefone_user').mask('(00) 00000-0000');
    $('#cpf_user').mask('000.000.000-00');

});