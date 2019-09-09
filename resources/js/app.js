
require('./bootstrap');

window.Vue = require('vue');

//importa Snotify
import Snotify from 'vue-snotify'
Vue.use(Snotify, {toast: {showProgressBar: false, timeout: 4000}})

//importa Axios
import Axios from 'axios'
Vue.use(Axios)

//Importa o Vue jquery Mask
import vueMask from 'vue-jquery-mask';
Vue.use(vueMask)

//Importando componentes
Vue.component('form-helpdesk-component', require('./components/helpdesk/FormHelpDeskComponent.vue').default);
Vue.component('helpdesks-component', require('./components/helpdesk/HelpDesksComponent.vue').default);
Vue.component('helpdesk-component', require('./components/helpdesk/HelpDeskComponent.vue').default);
Vue.component('articles-component', require('./components/articles/ArticlesComponent.vue').default);
Vue.component('form-article-component', require('./components/articles/FormArticleComponent.vue').default);
Vue.component('categorie-helpdesk-component', require('./components/categories/CategorieHelpDeskComponent.vue').default);
Vue.component('categorie-archive-component', require('./components/categories/CategorieArchiveComponent.vue').default);
Vue.component('categorie-article-component', require('./components/categories/CategorieArticleComponent.vue').default);
Vue.component('categorie-equipment-component', require('./components/categories/CategorieEquipmentComponent.vue').default);
Vue.component('form-categorie-component', require('./components/categories/FormCategorieComponent.vue').default);
Vue.component('sectors-component', require('./components/sectors/SectorsComponent.vue').default);
Vue.component('archives-component', require('./components/archives/ArchivesComponent.vue').default);
Vue.component('equipments-component', require('./components/equipments/EquipmentsComponent.vue').default);
Vue.component('form-computer-component', require('./components/computers/FormComputerComponent.vue').default);
Vue.component('computers-component', require('./components/computers/ComputersComponent.vue').default);
Vue.component('passwords-component', require('./components/passwords/PasswordsComponent.vue').default);
Vue.component('profile-component', require('./components/profile/ProfileComponent.vue').default);


const app = new Vue({
    el: '#app',
});

$(document).ready(function(){
    $('select').formSelect();
    $('.sidenav').sidenav();
    $('.dropdown-trigger').dropdown();
    $('.collapsible').collapsible();
    $('.tabs').tabs();
    $('.modal').modal();
    $('.tooltipped').tooltip();

    $('#telefone_user').mask('(00) 00000-0000');
    $('#cpf_user').mask('000.000.000-00');
});