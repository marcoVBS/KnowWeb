<template>
    <div>
        <div class="divider"></div>
        <div class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="computadores/novo" data-position="left" data-tooltip="Novo!">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div class="col s12">
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
                        <tr v-for="(pc, index) in computers" :key="index">
                        <td> {{pc.placa_mae}} </td>
                        <td> {{pc.processador}} </td>
                        <td> {{pc.memoria_ram}} </td>
                        <td> {{pc.unidade_armazenamento}} </td>
                        <td> {{pc.identificador_computador}} </td>
                        <td> {{pc.setor}} </td>
                        <td class="row">
                                <a :href="`computadores/atualizar/${pc.id_computador}`"><i class="material-icons">edit</i></a>
                                <a href="#" class="green-text"><i class="material-icons">remove_red_eye</i></a>
                                <a class="red-text" href="#" @click.prevent="confirmDelete(pc.id_computador)"><i class="material-icons">delete</i></a>
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
    data() {
        return {
            computers: []
        }
    },
    methods: {
        getComputers(){
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