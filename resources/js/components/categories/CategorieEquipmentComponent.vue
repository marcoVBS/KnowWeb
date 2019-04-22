<template>
        <div class="row">
           <h5 class="header grey-text center-align">Categorias de equipamento
                <a class="waves-effect waves-light btn modal-trigger" href="#modalequipament" @click="newRoute()">
                <i class="material-icons left">add_circle</i>Nova</a>
           </h5>
           <!-- Modal Structure -->
                <div id="modalequipament" class="modal">
                        <div class="modal-content">
                                <h5 v-if="update"  class="header grey-text center-align">Edição de categoria de equipamento</h5>
                                <h5 v-else class="header grey-text center-align">Cadastro de categoria de equipamento</h5>
                                
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
                            <td> {{categorie.id_categoria_equipamento}} </td>
                            <td> {{categorie.nome}} </td>
                            <td> {{categorie.descricao}} </td>
                            <td class="row">
                                <a href="#modalequipament" class="modal-trigger" @click="loadForm(categorie)"><i class="material-icons">edit</i></a>
                                <a href="#" @click.prevent="confirmDelete(categorie.id_categoria_equipamento, categorie.nome)"><i class="material-icons">delete</i></a>
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
                        
                        axios.get("categorias/equipamento/all")
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
                        axios.delete(`categorias/equipamento/delete/${id}`)
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
                        this.route = 'categorias/equipamento/update'
                },
                newRoute(){
                        this.route = 'categorias/equipamento/create'
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
