<template>
    <div>
        <div class="divider"></div>

        <div class="row">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">settings</i>Sistemas Operacionais</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <form method="post" @submit.prevent="onSubmitSO" action="#" id="form_so">
                                <div class="input-field col s12 m6">
                                    <input id="extensao" type="text" v-model="operSystem.nome" class="validate">
                                    <label for="extensao" v-bind:class="{active: updateSO}">Nome</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="versao" type="text" v-model="operSystem.versao" class="validate">
                                    <label for="versao" v-bind:class="{active: updateSO}">Versão</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="arq" type="text" v-model="operSystem.arquitetura" class="validate">
                                    <label for="arq" v-bind:class="{active: updateSO}">Arquitetura</label>
                                </div>

                                <div class="row">   
                                    <button class="btn waves-effect waves-light green" type="submit">Enviar
                                        <i class="material-icons right">send</i>
                                    </button>

                                    <button class="btn waves-effect waves-light red" type="reset">Limpar
                                        <i class="material-icons right">clear</i>
                                    </button>
                                </div>

                            </form>
                        </div>

                        <div class="row">
                            <div class="divider"></div><br>

                             <table>
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Nome</th>
                                        <th>Versão</th>
                                        <th>Arquitetura</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody v-if="operSystems.length > 0">
                                        <tr v-for="(SO, index) in operSystems" :key="index">
                                            <td> {{SO.id_sistema_operacional}} </td>
                                            <td> {{SO.nome}} </td>
                                            <td> {{SO.versao}} </td>
                                            <td> {{SO.arquitetura}} </td>
                                            <td class="row">
                                                    <a href="#" @click="loadFormSO(SO)"><i class="material-icons">edit</i></a>
                                                    <a class="red-text" href="#" @click.prevent="confirmDeleteSO(SO.id_sistema_operacional, SO.nome)"><i class="material-icons">delete</i></a>
                                            </td>
                                        </tr>
                                </tbody>
                                <tbody v-else>
                                        <tr><td class="green-text">Nenhum sistema operacional cadastrado...</td></tr>
                                </tbody>
                            </table>
                            
                        </div>

                    </div>
                </li>
            </ul>
        </div>

        <div class="row">
            <h5 class="header grey-text">Novo Computador</h5>

            <div class="row">
                <form method="post" action="#" id="form_computer">
                    
                    <div class="input-field col s12 m6">
                        <input id="placa_mae" type="text" v-model="computer.placa_mae" class="validate">
                        <label for="placa_mae" v-bind:class="{active: updateComputer}">Placa-mãe</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="processador" type="text" v-model="computer.processador" class="validate">
                        <label for="processador" v-bind:class="{active: updateComputer}">Processador</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="ram" type="text" v-model="computer.memoria_ram" class="validate">
                        <label for="ram" v-bind:class="{active: updateComputer}">Memória RAM</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="hd" type="text" v-model="computer.unidade_armazenamento" class="validate">
                        <label for="hd" v-bind:class="{active: updateComputer}">Unidade de armazenamento</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="mac_ethernet" type="text" v-model="computer.mac_ethernet" class="validate">
                        <label for="mac_ethernet" v-bind:class="{active: updateComputer}">Mac da plada de rede Ethernet</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="mac_wireless" type="text" v-model="computer.mac_wireless" class="validate">
                        <label for="mac_wireless" v-bind:class="{active: updateComputer}">Mac da plada de rede Wireless</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="senha_adm" type="password" v-model="computer.senha_usuario_adm " class="validate">
                        <label for="senha_adm" v-bind:class="{active: updateComputer}">Senha do Administrador do sistema</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="nome_pc" type="text" v-model="computer.nome_computador " class="validate">
                        <label for="nome_pc" v-bind:class="{active: updateComputer}">Nome do computador</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="id_pc" type="password" v-model="computer.identificador_computador" class="validate">
                        <label for="id_pc" v-bind:class="{active: updateComputer}">Identificador do computador</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <textarea id="programas" v-model="computer.programas_especificos" class="materialize-textarea"></textarea>
                        <label for="programas">Programas específicos</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select v-model="computer.sistema_operacional_id" id="SO">
                            <option value="" disabled selected>Selecione...</option>
                            <option v-for="(SO, index) in operSystems" :key="index" v-bind:value="SO.id_sistema_operacional"> {{ SO.nome }} - {{SO.versao}} - {{SO.arquitetura}}</option>
                        </select>
                        <label>Sistema Operacional</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select v-model="computer.setor_id">
                            <option value="" disabled selected>Selecione...</option>
                            <option v-for="(setor, index) in setores" :key="index" v-bind:value="setor.id_setor"> {{ setor.nome }} </option>        
                        </select>
                        <label>Setor</label>
                    </div>

                    <div class="row">   
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
    props: ['setores', 'sos'],
    data() {
        return {
            operSystems: [],
            operSystem: {},
            updateSO: false,
            computer: {},
            updateComputer: false
        }
    },
    methods: {
        onSubmitSO(){
            if(this.updateSO == true){
                this.updateSystem();
            }else{
                this.insertSO();
            }
        },
        getSOs(){
            let vm = this
                        
            axios.get("computadores/so/all")
            .then(function(response){
                vm.operSystems = response.data.SOs
            })
        },
        insertSO(){
            let vm = this
            
            axios.post('computadores/so/create', {
                nome: vm.operSystem.nome,
                versao: vm.operSystem.versao,
                arquitetura: vm.operSystem.arquitetura
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.getSOs();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.operSystem = {}
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao cadastrar sistema operacional!', 'Erro')
            })
            .finally(function() {
                $('#form_so').each(function(){
                    this.reset();
                })
            })    
        },
        confirmDeleteSO(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o sistema ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteSO(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteSO(id){
            let vm = this
            axios.delete(`computadores/so/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getSOs()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch((error) => (vm.$snotify.error('Falha ao excluir o sistema operacional!', 'Erro')))
        },
        loadFormSO(SO){
            this.updateSO = true
            this.operSystem = SO
        },
        updateSystem(){
            let vm = this
            axios.put('computadores/so/update', vm.operSystem)
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.operSystem = {}
                vm.updateSO = false
                vm.getSOs();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar sistema operacional', 'Erro')))
            .finally(function(){
                $('#form_so').each(function(){
                    this.reset();
                })
            })
        }
    },
    mounted() {
        this.operSystems = this.sos
    },
}
</script>
