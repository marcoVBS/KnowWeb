<template>
    <div>

        <div v-if="create_user" class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="#modaluser" data-position="left" data-tooltip="Novo!" @click="newSector()">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div id="modaluser" class="modal">
            <div class="modal-content">
                <h5 v-if="update"  class="header grey-text center-align">Edição de Usuário</h5>
                <h5 v-else class="header grey-text center-align">Cadastro de Usuário</h5>

                <form @submit.prevent="onSubmit" action="#"  method="post" id="form_user">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="nome" type="text" name="nome" v-model="user.nome" required>
                            <label for="nome" v-bind:class="{active: update}">Nome</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="email" type="email" name="email" v-model="user.email" required>
                            <label for="email" v-bind:class="{active: update}">Email</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                            <vue-mask id="telefone" type="text" mask="(00) 00000-0000" :raw="false" v-model="user.telefone" class="validate" required></vue-mask>
                            <label for="telefone" v-bind:class="{active: update}">Telefone</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <vue-mask id="cpf" type="text" mask="000.000.000-00" :raw="false" v-model="user.cpf" class="validate" required></vue-mask>
                            <label for="cpf" v-bind:class="{active: update}">CPF</label>
                        </div>
                   
                        <div class="input-field col s12 m6">
                            <select v-model="user.setor_id" required>
                                <option disabled value="">Selecione...</option>
                                <option v-for="(setor, index) in sectors" :key="index" :value="setor.id_setor"> {{ setor.nome }} </option>        
                            </select>
                            <label>Setor</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <select v-model="user.tipo_usuario" required>
                                <option disabled value="">Selecione...</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Membro">Membro TI</option>
                                <option value="Usuario">Usuario</option>
                            </select>
                            <label>Tipo do Usuário</label>
                        </div>

                        <div v-if="update_pass || !update">
                            <div class="input-field col s12 m6">
                                <input id="password" type="password" name="password" v-model="user.password">
                                <label for="password">Nova senha</label>
                                <span class="helper-text green-text">A senha deve conter no mínimo 8 caracteres!</span>
                            </div>

                            <div class="input-field col s12 m6">
                                <input id="confirm_password" type="password" name="confirm_password" v-model="user.password2">
                                <label for="confirm_password">Confirme a senha</label>
                            </div>
                        </div>

                        <p v-if="update">
                            <label>
                                <input type="checkbox" class="filled-in" v-model="update_pass" />
                                <span>Alterar senha</span>
                            </label>
                        </p>
                    </div>

                    <div class="row center-align">   
                        <button class="btn waves-effect waves-light green" type="submit">Enviar
                            <i class="material-icons right">send</i>
                        </button>

                        <button class="modal-close btn waves-effect waves-light red" type="reset">Cancelar
                            <i class="material-icons right">clear</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="manage_permissions" class="col s12">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">settings</i>Gerenciar permissões do sistema</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <form @submit.prevent="onSubmitPermission" method="post" action="#" id="form_permission">
                                <div class="input-field">
                                    <i class="material-icons prefix">add_circle</i>
                                    <input id="permissao" type="text" v-model="permission.label" class="validate">
                                    <label for="permissao">Nova permissão. Ex: create-user</label>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <span class="text-center">Permissões cadastradas no sistema:</span>
                            <div class="divider"></div><br>

                            <div v-for="(perm, index) in permissions" :key="index" class="chip">
                                <a href="#" @click.prevent="confirmDeletePermission(perm.id_permissao, perm.nome)"><i class="material-icons right close-tag red-text">close</i></a><b>{{ perm.nome }}</b>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>
        </div>

        <div v-if="list_users" class="col s12">

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">search</i>
                <input id="icon_prefix" type="text" v-model="search_query" class="validate">
                <label for="icon_prefix">Buscar usuários...</label>
            </div>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Tipo</th>
                        <th>Setor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in filteredData" :key="index">
                        <td v-if="user.foto">
                            <img :src="user.foto" alt="imagem_usuario" class="circle img-user">
                        </td>
                        <td v-else>
                            <img src="img/app/usuario-icon.png" alt="imagem_usuario" class="circle img-user">
                        </td>
                        <td>{{ user.nome }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.telefone }}</td>
                        <td>{{ user.tipo_usuario }}</td>
                        <td>{{ user.setor }}</td>
                        <td>
                            <a v-if="user.id_usuario !== user_logged.id_usuario && user.tipo_usuario == 'Membro' && set_user_permissions" :href="`usuarios/permissoes/${user.id_usuario}`" class="green-text darken-4"><i class="material-icons">lock_open</i></a>
                            <a v-if="edit_user" href="#modaluser" class="modal-trigger" @click.prevent="loadForm(user)"><i class="material-icons">edit</i></a>
                            <a v-if="user.id_usuario !== user_logged.id_usuario && disable_user && user.status == 1" class="red-text tooltipped" data-position="bottom" data-tooltip="I am a tooltip" href="#" @click.prevent="confirmStatus(user)"><i class="material-icons">block</i></a>
                            <a v-if="user.id_usuario !== user_logged.id_usuario && disable_user && user.status == 0" class="red-text tooltipped" data-position="bottom" data-tooltip="I am a tooltip" href="#" @click.prevent="confirmStatus(user)"><i class="material-icons">check</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user_logged', 'sectors', 'manage_permissions', 'set_user_permissions', 'list_users', 'create_user', 'disable_user', 'edit_user'],
    data() {
        return {
            users: [],
            user: {},
            update: false,
            update_pass: false,
            search_query: '',
            permissions: [],
            permission: {
                label: ""
            },
        }
    },
    computed: {
        filteredData: function(){
            var filterKey = this.search_query && this.search_query.toLowerCase()
            var dataFilter = this.users
            if (filterKey) {
                dataFilter = dataFilter.filter(function (row) {
                return Object.keys(row).some(function (key) {
                    return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                })
                })
            }
            return dataFilter
        },
    },
    methods: {
        getPermissions(){
            if(!this.manage_permissions){
                return false;
            }
            
            let vm = this
                        
            axios.get("usuarios/permissoes/get/all")
            .then(function(response){
                vm.permissions = response.data.permissions
                if(vm.user.permissoes){
                    vm.permissions.map(function(e){
                        if(vm.user.permissoes.indexOf(e.id_permissao) > -1){
                            e.check = true
                        }
                    })
                }
            })
        },
        onSubmitPermission(){
            if(!this.manage_permissions){
                return false;
            }

            let vm = this
            
            axios.post('usuarios/permissoes/create', {
                permissao: vm.permission.label,
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.getPermissions();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.permission.label = ""
                }else{
                    vm.$snotify.error(message, 'Erro')
                    vm.permission.label = ""
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao cadastrar permissão!', 'Erro')
            })
            .finally(function() {
                $('#form_permission').each(function(){
                    this.reset();
                })
            })    
        },
        confirmDeletePermission(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir a permissão ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deletePermission(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deletePermission(id){
            if(!this.manage_permissions){
                return false;
            }

            let vm = this
            axios.delete(`usuarios/permissoes/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getPermissions()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch(function(error){
                    vm.$snotify.error('Falha ao excluir o permissão!', 'Erro')
                })
        },
        closeModal(){
            $('.modal').modal('close')
            $('#form_user').each(function(){
                this.reset();
            })
            this.update_pass = false
            this.newSector()
        },
        newSector(){
            this.update = false
            this.user = {}
        },
        onSubmit(){
            if(this.update == true){
                this.updateUser();
            }else{
                this.insertUser();
            }
        },
        getUsers(){
            if(!this.list_users){
                return false;
            }

            let vm = this
                        
            axios.get("usuarios/all")
            .then(function(response){
                vm.users = response.data.users
            })
        },
        loadForm(user){
            this.update = true
            this.user = user            
        },
        insertUser(){
            if(!this.create_user){
                return false;
            }

            if(this.user.password == this.user.password2){
                if(this.user.password.length >= 8){
                    let vm = this
            
                    axios.post('usuarios/create', {
                        nome: vm.user.nome,
                        email : vm.user.email,
                        telefone : vm.user.telefone,
                        cpf : vm.user.cpf,
                        password : vm.user.password,
                        setor_id : vm.user.setor_id,
                        tipo_usuario : vm.user.tipo_usuario
                    })
                    .then(function(response){
                        let stored = response.data.stored
                        let message = response.data.message
                        
                        vm.getUsers();

                        if(stored == true){
                            vm.$snotify.success(message, 'Sucesso')
                            vm.closeModal();
                        }else{
                            vm.$snotify.error(message, 'Erro')
                        }
                    })
                    .catch(function(error){
                        vm.$snotify.error('Falha ao cadastrar usuário!', 'Erro')
                        vm.closeModal()    
                    })
                }else{
                    this.$snotify.error('A senhas informada deve conter no mínimo 8 caracteres!', 'Erro')
                }
            }else{
                this.$snotify.error('As senha informadas não conferem!', 'Erro')
            }
        },
        updateUser(){
            if(!this.edit_user){
                return false;
            }

            if(this.user.password){
                if(this.user.password == this.user.password2){
                    if(this.user.password.length >= 8){
                        let vm = this
                
                        axios.put('usuarios/update', {
                            id_usuario: vm.user.id_usuario,
                            nome: vm.user.nome,
                            email : vm.user.email,
                            telefone : vm.user.telefone,
                            cpf : vm.user.cpf,
                            password : vm.user.password,
                            setor_id : vm.user.setor_id,
                            tipo_usuario : vm.user.tipo_usuario
                        })
                        .then(function(response){
                            let stored = response.data.stored
                            let message = response.data.message
                            
                            vm.getUsers();
    
                            if(stored == true){
                                vm.$snotify.success(message, 'Sucesso')
                                vm.closeModal();
                            }else{
                                vm.$snotify.error(message, 'Erro')
                            }
                        })
                        .catch(function(error){
                            vm.$snotify.error('Falha ao atualizar usuário!', 'Erro')
                            vm.closeModal()    
                        })
                    }else{
                        this.$snotify.error('A senha informada deve conter no mínimo 8 caracteres!', 'Erro')
                    }
                }else{
                    this.$snotify.error('As senhas informadas não conferem!', 'Erro')
                }
            }else{
                let vm = this
                
                axios.put('usuarios/update', {
                    id_usuario: vm.user.id_usuario,
                    nome: vm.user.nome,
                    email : vm.user.email,
                    telefone : vm.user.telefone,
                    cpf : vm.user.cpf,
                    setor_id : vm.user.setor_id,
                    tipo_usuario : vm.user.tipo_usuario
                })
                .then(function(response){
                    let stored = response.data.stored
                    let message = response.data.message
                    
                    vm.getUsers();

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.closeModal();
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch(function(error){
                    vm.$snotify.error('Falha ao atualizar usuário!', 'Erro')
                    vm.closeModal()    
                })
            }
        },
        confirmStatus(user){
            let vm = this
            let action = user.status == 1 ? 'desabilitar' : 'habilitar'

            vm.$snotify.confirm(`Deseja ${action} o usuario ${user.nome}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.changeStatus(user); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        changeStatus(user){
            if(!this.disable_user){
                return false;
            }

            let vm = this
            axios.put('usuarios/status/',{
                id : user.id_usuario,
                status : user.status == 1 ? 0 : 1  
            })
            .then(function(response){
                let stored = response.data.deleted
                let message = response.data.message

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.getUsers()
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar status do usuario!', 'Erro')))
        }
    },
    mounted() {
        this.getPermissions()
        this.getUsers()
    }
}
</script>

<style scoped>
    .img-user{ width: 2.5em; margin: -12px 0;}
    .close-tag{ padding: 5px 0 0 0;}
</style>