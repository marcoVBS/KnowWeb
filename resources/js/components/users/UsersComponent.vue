<template>
    <div>

        <div class="fixed-action-btn">
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

                        <button class="btn waves-effect waves-light red" type="reset">Limpar
                            <i class="material-icons right">clear</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="divider"></div>
        <div class="col s12">

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
                        <td class="row">
                            <a :href="`usuarios/permissoes/${user.id_usuario}`" class="green-text darken-4"><i class="material-icons">lock</i></a>
                            <a href="#modaluser" class="modal-trigger" @click.prevent="loadForm(user)"><i class="material-icons">edit</i></a>
                            <a v-if="user.id_usuario !== user_logged.id_usuario" class="red-text" href="#" @click.prevent="confirmDelete(user.id_usuario, user.nome)"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user_logged', 'sectors'],
    data() {
        return {
            users: [],
            user: {},
            update: false,
            update_pass: false,
            search_query: ''
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
        }
    },
    methods: {
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
        confirmDelete(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o usuario ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteUser(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteUser(id){
            let vm = this
            axios.delete(`usuarios/delete/${id}`)
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
                .catch((error) => (vm.$snotify.error('Falha ao excluir o usuario!', 'Erro')))
        }
    },
    mounted() {
        this.getUsers()
    }
}
</script>

<style scoped>
    .img-user{ width: 2.5em; margin: -12px 0;}
</style>