<template>
    <div>
        <div class="divider"></div><br>
        <a class="waves-effect waves-light btn modal-trigger" href="#modalsector" @click="newSector()">
                <i class="material-icons left">add_circle</i>Novo</a>
        <table>
            <thead>
                <tr>
                    <th>#Id</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody v-if="sectors.length > 0">
                    <tr v-for="(sector, index) in sectors" :key="index">
                    <td> {{sector.id_setor}} </td>
                    <td> {{sector.nome}} </td>
                    <td> {{sector.descricao}} </td>
                    <td class="row">
                            <a href="#modalsector" class="modal-trigger" @click="loadForm(sector)"><i class="material-icons">edit</i></a>
                            <a href="#" @click.prevent="confirmDelete(sector.id_setor, sector.nome)"><i class="material-icons">delete</i></a>
                    </td>
                    </tr>
            </tbody>
            <tbody v-else>
                    <tr><td class="green-text">Nenhum setor cadastrado...</td></tr>
            </tbody>
        </table>

        <div id="modalsector" class="modal">
            <div class="modal-content">
                <h5 v-if="update"  class="header grey-text center-align">Edição de setor</h5>
                <h5 v-else class="header grey-text center-align">Cadastro de setor</h5>

                <form @submit.prevent="onSubmit" action="#"  method="post" id="form_sector">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="nome" type="text" name="nome" v-model="sector.nome" required>
                            <label for="nome" v-bind:class="{active: update}">Nome</label>
                        </div>

                        <div class="input-field col s12">
                            <input id="descricao" type="text" v-model="sector.descricao" name="descricao">
                            <label for="descricao" v-bind:class="{active: update}">Descrição</label>
                        </div>
                    </div>

                    <div class="row center-align">   
                        <button class="btn waves-effect waves-light green" type="submit">Enviar
                            <i class="material-icons right">send</i>
                        </button>

                        <button class="btn waves-effect waves-light red" type="reset">Limpar
                            <i class="material-icons right">clear</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            sectors: [],
            sector: {},
            update: false
        }
    },
    methods:{
        closeModal(){
            $('.modal').modal('close')
        },
        newSector(){
            this.update = false
            this.sector = {}
        },
        onSubmit(){
            if(this.update == true){
                this.updateSector();
            }else{
                this.insertSector();
            }
        },
        getSectors(){
            let vm = this
                        
            axios.get("setores/all")
            .then(function(response){
                vm.sectors = response.data.sectors
            })
        },
        insertSector(){
            let vm = this
            
            axios.post('setores/create', {
                nome: vm.sector.nome,
                descricao : vm.sector.descricao
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeModal();
                vm.getSectors();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao cadastrar setor!', 'Erro')
                vm.closeModal()    
            })
            .finally(function() {
                $('#form_sector').each(function(){
                    this.reset();
                })
            })
        },
        updateSector(){
            let vm = this
            axios.put('setores/update', vm.sector)
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeModal();
                vm.getSectors();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar setor', 'Erro')))
            .finally(function(){
                $('#form_sector').each(function(){
                    this.reset();
                })
            })
        },
        confirmDelete(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o setor ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteSector(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteSector(id){
            let vm = this
            axios.delete(`setores/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getSectors()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch((error) => (vm.$snotify.error('Falha ao excluir o setor!', 'Erro')))
        },
        loadForm(sector){
            this.update = true
            this.sector = sector
        }
    },
    mounted(){
        this.getSectors();
    }
}
</script>