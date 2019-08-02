<template>
        <div class="row">

                <div class="fixed-action-btn">
                        <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="#modalhelpdesk" data-position="left" data-tooltip="Novo!" @click="newRoute()">
                                <i class="large material-icons">add</i>
                        </a>
                </div>

           <h5 class="header grey-text center-align">Categorias de atendimento</h5>
            <!-- Modal Structure -->
                <div id="modalhelpdesk" class="modal">
                        <div class="modal-content">
                                <h5 v-if="update"  class="header grey-text center-align">Edição de categoria de atendimento</h5>
                                <h5 v-else class="header grey-text center-align">Cadastro de categoria de atendimento</h5>
                                
                                <form-categorie-component @getCategories="getCategories" @closeModal="closeModal" 
                                        :route="route"
                                        :categorie="categorieUpdate" :update="update"></form-categorie-component>
                                
                        </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                        <tbody v-if="categories.length > 0">
                                <tr v-for="(categorie, index) in categories" :key="index">
                                <td> {{categorie.id_categoria_atendimento}} </td>
                                <td> {{categorie.nome}} </td>
                                <td> {{categorie.descricao}} </td>
                                <td class="row">
                                        <a href="#modalhelpdesk" class="modal-trigger" @click="loadForm(categorie)"><i class="material-icons">edit</i></a>
                                        <a class="red-text" href="#" @click.prevent="confirmDelete(categorie.id_categoria_atendimento, categorie.nome)"><i class="material-icons">delete</i></a>
                                </td>
                                </tr>
                        </tbody>
                        <tbody v-else>
                                <tr><td class="green-text">Nenhuma categoria cadastrada...</td></tr>
                        </tbody>
                </table>

        </div>
</template>

<script>

import FormCategorieComponent from './FormCategorieComponent.vue';

export default {
        data() {
                return {
                        route: '',
                        categories: [],
                        categorieUpdate: {},
                        update: false
                }
        },
        components:{
                FormCategorieComponent
        },
        methods: {
                closeModal(){
                        $('.modal').modal('close')
                },
                getCategories(){
                        let vm = this
                        
                        axios.get("categorias/helpdesk/all")
                        .then(function(response){
                                vm.categories = response.data.categories
                        })
                },
                confirmDelete(id, name){
                        let vm = this
                        vm.$snotify.confirm(`Deseja realmente excluir a categoria ${name}?`, 'Exclusão!', {
                                timeout: false,
                                position: 'centerCenter',
                                buttons:[
                                        {text: 'Sim', action: (toast) => {vm.deleteCategorie(id); vm.$snotify.remove(toast.id)}},
                                        {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                                ]
                        })
                },
                deleteCategorie(id){
                        let vm = this
                        axios.delete(`categorias/helpdesk/delete/${id}`)
                                .then(function(response){
                                        let stored = response.data.deleted
                                        let message = response.data.message

                                        if(stored == true){
                                        vm.$snotify.success(message, 'Sucesso')
                                        vm.getCategories()
                                        }else{
                                        vm.$snotify.error(message, 'Erro')
                                        }
                                })
                                .catch((error) => (vm.$snotify.error('Falha ao excluir a categoria', 'Erro')))
                },
                loadForm(categorie){
                        this.update = true
                        this.categorieUpdate = categorie
                        this.route = 'categorias/helpdesk/update'
                },
                newRoute(){
                        this.route = 'categorias/helpdesk/create'
                        this.update = false
                        this.categorieUpdate = {}
                }
        },
        mounted() {
                this.getCategories()  
        }
}
</script>

<style scoped>

</style>
