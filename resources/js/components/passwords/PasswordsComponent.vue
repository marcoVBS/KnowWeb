<template>
    <div>
        <div class="divider"></div>

        <div v-if="create_password" class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="#modalpassword" data-position="left" data-tooltip="Nova!" @click="newPassword()">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div id="modal_view" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Descrição da senha: {{ view.descricao }}</h5>
                <div class="divider"></div>
                <p><b>Login:</b> {{ view.login }}</p>
                <p v-if="view_password"><b>Senha:</b> 
                    <span v-if="show">{{ view.senha }}</span>
                    <a v-else href="#" @click.prevent="showPass()">Exibir senha</a>
                </p>
                <p><b>Observações:</b> {{ view.observacoes }}</p>
                
                <div class="divider"></div>

                <div v-if="view.equipamento">
                    <h6><b>Equipamento associado:</b></h6>
                    <p><b>Descrição: </b><br>{{ view.equipamento.descricao}}</p>
                    <p><b>Características: </b><br>{{ view.equipamento.caracteristicas}}</p>

                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat red-text">fechar</a>
            </div>
        </div>

        <div id="modalpassword" class="modal">
            <div class="modal-content">
                <h5 v-if="update"  class="header grey-text center-align">Edição de senha</h5>
                <h5 v-else class="header grey-text center-align">Cadastro de senha</h5>

                <form @submit.prevent="onSubmit" action="#"  method="post" id="form_password">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="descricao" type="text" v-model="password.descricao" required>
                            <label for="descricao" v-bind:class="{active: update}">Descricao</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">person</i>
                            <input id="login" type="text" v-model="password.login" required>
                            <label for="login" v-bind:class="{active: update}">Login</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i @click.prevent="viewPass" class="material-icons prefix">visibility</i>
                            <input id="senha" :type="typePass" v-model="password.senha" required>
                            <label for="senha" v-bind:class="{active: update}">Senha</label>
                        </div>

                        <div class="input-field col s12">
                            <textarea id="obs" class="materialize-textarea" v-model="password.observacoes"></textarea>
                            <label for="obs" v-bind:class="{active: update}">Observações</label>
                        </div>

                        <div :class="{busca_equipamento : !assoc}" class="input-field col s12">
                            <i class="material-icons prefix">router</i>
                            <input type="text" id="autocomplete-input" v-model="password.autocomplete" class="autocomplete">
                            <label for="autocomplete-input" v-bind:class="{active: update}">Buscar equipamento</label>
                        </div>

                        <div class="col s12">
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" v-model="assoc" />
                                    <span>Associar um equipamento</span>
                                </label>
                            </p>
                        </div>

                    </div>                   

                    <div class="row center-align">   
                        <button class="btn waves-effect waves-light green" type="submit">Enviar
                            <i class="material-icons right">send</i>
                        </button>

                        <button class="modal-close btn waves-effect waves-light red" type="reset">cancelar
                            <i class="material-icons right">clear</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="list_passwords" class="col s12">

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">search</i>
                <input id="icon_prefix" type="text" v-model="search_query" class="validate">
                <label for="icon_prefix">Buscar senha...</label>
            </div>

            <table class="striped">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Login</th>
                        <th>Equipamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody v-if="passwords.length > 0">
                        <tr v-for="(pass, index) in filteredData" :key="index">
                            <td> {{pass.descricao}} </td>
                            <td> {{pass.login}} </td>
                            <td v-if="pass.equipamento"> {{pass.equipamento.descricao}} </td>
                            <td v-else></td>
                            <td class="row">
                                    <a v-if="edit_password" href="#modalpassword" class="modal-trigger" @click.prevent="loadForm(pass)"><i class="material-icons">edit</i></a>
                                    <a v-if="view_password" href="#modal_view" class="modal-trigger green-text" @click.prevent="loadView(pass)"><i class="material-icons">remove_red_eye</i></a>
                                    <a v-if="delete_password" class="red-text" href="#" @click.prevent="confirmDelete(pass.id_senha, pass.descricao)"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                </tbody>
                <tbody v-else>
                        <tr><td class="green-text">Nenhuma senha cadastrada...</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>

export default {
    props: ['equipamentos', 'list_passwords', 'view_password', 'create_password', 'edit_password', 'delete_password'],
    data() {
        return {
            passwords: [],
            password: {},
            view: {},
            update: false,
            assoc: false,
            search_query: '',
            typePass: 'password',
            show: false
        }
    },
    computed: {
        filteredData: function(){
            var filterKey = this.search_query && this.search_query.toLowerCase()
            var dataFilter = this.passwords
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
        viewPass(){
            if(this.typePass == 'password'){
                this.typePass = 'text'
            }else if(this.typePass == 'text'){
                this.typePass = 'password'
            }
        },
        onSubmit(){
            if(this.update == true){
                this.updatePassword();
            }else{
                this.insertPassword();
            }
        },
        newPassword(){
            this.password = {}
            this.update = false
        },
        closeModal(){
            $('#modalpassword').modal('close')
        },
        selectEquipment(data){
            let regex = /[0-9]+(?=\s)/
            let id = data.match(regex)
            this.password.equipamento_id = id[0]
        },
        insertPassword(){
            if(!this.create_password){
                return false;
            }

            if (this.assoc == false) {
                this.password.equipamento_id = null
            }

            let vm = this
            
            axios.post('senhas/create', {
                descricao : vm.password.descricao,
                login : vm.password.login,
                senha : vm.password.senha,
                observacoes : vm.password.observacoes,
                equipamento_id: vm.password.equipamento_id
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeModal();
                vm.getPasswords();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.closeModal()
                vm.$snotify.error('Falha ao cadastrar senha!', 'Erro')   
            })
            .finally(function() {
                $('#form_password').each(function(){
                    this.reset();
                })
                vm.password = {}
            })
        },
        getPasswords(){
            if(!this.list_passwords){
                return false;
            }

            let vm = this
                        
            axios.get("senhas/all")
            .then(function(response){
                vm.passwords = response.data.passwords
            })
        },
        loadView(pass){
            this.show = false
            this.view = pass
            if(!this.view_password){
                this.view.senha = '';
            }
        },
        showPass(){
            this.show = true
        },
        loadForm(pass){
            this.update = true
            if(pass.equipamento){
                this.assoc = true
            }else{
                this.assoc = false
            }
            this.password = pass
            if(this.password.equipamento){
                this.password.autocomplete = this.password.equipamento.descricao
            }
        },
        updatePassword(){
            if(!this.edit_password){
                return false;
            }

            if(this.assoc == false){
                this.password.equipamento_id = null
            }
            let vm = this
            axios.put('senhas/update', vm.password)
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeModal();
                vm.getPasswords();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar senha', 'Erro')))
            .finally(function(){
                $('#form_password').each(function(){
                    this.reset();
                })
            })
        },
        confirmDelete(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir a senha: ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deletePassword(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deletePassword(id){
            if(!this.delete_password){
                return false;
            }

            let vm = this
            axios.delete(`senhas/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getPasswords()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch((error) => (vm.$snotify.error('Falha ao excluir a senha!', 'Erro')))
        },
    },
    mounted() {
        this.getPasswords()

        let dados = {}
        let vm = this
        vm.equipamentos.forEach(element => {
            dados[element.id_equipamento+' - '+element.descricao] = null                      
        })                
        $('input.autocomplete').autocomplete({
            data: dados,
            onAutocomplete: function(data) {
                vm.selectEquipment(data)
            }
        });
    }
}
</script>

<style scoped>
    .busca_equipamento{
        display: none;
    }
</style>