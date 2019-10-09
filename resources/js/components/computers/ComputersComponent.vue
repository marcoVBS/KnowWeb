<template>
    <div>
        <div class="divider"></div>
        <div v-if="create_computer" class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="computadores/novo" data-position="left" data-tooltip="Novo!">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div v-if="list_computers" class="col s12">

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">search</i>
                <input id="icon_prefix" type="text" v-model="search_query" class="validate">
                <label for="icon_prefix">Buscar computador...</label>
            </div>

            <table class="striped">
                <thead>
                    <tr>
                        <th>Placa-Mãe</th>
                        <th>Processador</th>
                        <th>RAM</th>
                        <th>Armazenamento</th>
                        <th>Identificador</th>
                        <th>Setor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody v-if="computers.length > 0">
                        <tr v-for="(pc, index) in filteredData" :key="index">
                        <td> {{pc.placa_mae}} </td>
                        <td> {{pc.processador}} </td>
                        <td> {{pc.memoria_ram}} </td>
                        <td> {{pc.unidade_armazenamento}} </td>
                        <td> {{pc.identificador_computador}} </td>
                        <td> {{pc.setor}} </td>
                        <td class="row">
                                <a v-if="edit_computer" :href="`computadores/atualizar/${pc.id_computador}`"><i class="material-icons">edit</i></a>
                                <a v-if="view_computer" :href="`computadores/${pc.id_computador}`" class="green-text"><i class="material-icons">remove_red_eye</i></a>
                                <a v-if="delete_computer" class="red-text" href="#" @click.prevent="confirmDelete(pc.id_computador)"><i class="material-icons">delete</i></a>
                        </td>
                        </tr>
                </tbody>
                <tbody v-else>
                        <tr><td class="green-text">Nenhum computador cadastrado...</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
export default {
    props: ['list_computers', 'view_computer', 'create_computer', 'edit_computer', 'delete_computer'],
    data() {
        return {
            computers: [],
            search_query: ''
        }
    },
    computed: {
        filteredData: function(){
            var filterKey = this.search_query && this.search_query.toLowerCase()
            var dataFilter = this.computers
            if (filterKey) {
                dataFilter = dataFilter.filter(function (row) {
                return Object.keys(row).some(function (key) {
                    return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                })
                })
            }
            return dataFilter
        }
    },
    methods: {
        getComputers(){
            if(!this.list_computers){
                return false;
            }
            
            let vm = this
                        
            axios.get("computadores/all")
            .then(function(response){
                vm.computers = response.data.computers
            })
        },
        confirmDelete(id){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o computador?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteComputer(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteComputer(id){
            if(!this.delete_computer){
                return false;
            }
            
            let vm = this
            axios.delete(`computadores/delete/${id}`)
            .then(function(response){
                let stored = response.data.deleted
                let message = response.data.message

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.getComputers()
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao excluir o Computador!', 'Erro')))
        }
    },
    mounted() {
        this.getComputers()
    }
}
</script>

<style scoped>

</style>