<template>
    <div>
        <div v-if="manage_permissions" class="row">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">settings</i>Gerenciar permissões do sistema</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <h5>Adicionar nova permissão</h5>
                            <form @submit.prevent="onSubmitPermission" method="post" action="#" id="form_permission">
                                <div class="input-field col s12 m4">
                                    <input id="permissao" type="text" v-model="permission.label" class="validate">
                                    <label for="permissao">Permissão. Ex: create-user</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="permissao" type="text" v-model="permission.description" class="validate">
                                    <label for="permissao">Descrição</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <button class="btn waves-effect waves-light green" type="submit">Enviar
                                        <i class="material-icons right">send</i>
                                    </button>
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

        <div v-if="set_user_permissions" class="row">
            <div v-if="user.foto">
                <img :src="user.foto" alt="imagem_usuario" class="circle img-user left">
            </div>
            <div v-else>
                <img src="/KnowWeb/public/img/app/usuario-icon.png" alt="imagem_usuario" class="circle img-user left">
            </div>

            <h5>Permissões do usuário <b>{{ user.nome }}</b></h5>
            <div class="divider"></div><br>   
            
            <div class="row">           
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Arquivos</span>
                        <div v-for="(perm, index) in grupo_arquivos" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
                       
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Senhas</span>
                        <div v-for="(perm, index) in grupo_senhas" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Equipamentos</span>
                        <div v-for="(perm, index) in grupo_equipamentos" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Computadores</span>
                        <div v-for="(perm, index) in grupo_computadores" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Usuários</span>
                        <div v-for="(perm, index) in grupo_usuarios" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Artigos</span>
                        <div v-for="(perm, index) in grupo_artigos" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Categorias</span>
                        <div v-for="(perm, index) in grupo_categorias" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card grey lighten-5 col s12 m4">
                    <div class="card-content">
                    <span class="card-title">Setores</span>
                        <div v-for="(perm, index) in grupo_setores" :key="index">
                            <div class="switch switch-permission col s12">
                                <label class="right-align">
                                    <input type="checkbox" v-model="perm.check">
                                    <span class="lever"></span>
                                </label>
                                {{ perm.descricao }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="set_user_permissions" class="center-align">
            <div class="divider"></div><br>
            <a href="../../usuarios" class="btn"><i class="material-icons left">keyboard_return</i>Cancelar</a>
            <a href="#" @click.prevent="saveUserPermissions()" class="btn waves-effect waves-light green">Salvar alterações<i class="material-icons right">send</i></a>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user', 'manage_permissions', 'set_user_permissions'],
    data() {
        return {
            permissions: [],
            permission: {
                label: ""
            }
        }
    },
    computed: {
        grupo_usuarios(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Usuários"
            })
            return dataFilter
        },
        grupo_setores(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Setores"
            })
            return dataFilter
        },
        grupo_categorias(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Categorias"
            })
            return dataFilter
        },
        grupo_senhas(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Senhas"
            })
            return dataFilter
        },
        grupo_equipamentos(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Equipamentos"
            })
            return dataFilter
        },
        grupo_arquivos(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Arquivos"
            })
            return dataFilter
        },
        grupo_computadores(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Computadores"
            })
            return dataFilter
        },
        grupo_artigos(){
            var dataFilter = this.permissions
            dataFilter = dataFilter.filter(function(e){
                return e.grupo == "Artigos"
            })
            return dataFilter
        },
    },
    methods: {
        getPermissions(){
            if(!this.set_user_permissions){
                return false;
            }
            
            let vm = this
                        
            axios.get("get/all")
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
            
            axios.post('create', {
                permissao: vm.permission.label,
                descricao: vm.permission.description
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.getPermissions();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.permission.label = ""
                    vm.permission.description = ""
                }else{
                    vm.$snotify.error(message, 'Erro')
                    vm.permission.label = ""
                    vm.permission.description = ""
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
            axios.delete(`delete/${id}`)
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
        saveUserPermissions(){
            if(!this.set_user_permissions){
                return false;
            }
            
            this.user.permissoes = []
            this.permissions.forEach(element => {
                if(element.check){
                    this.user.permissoes.push(element.id_permissao)
                }
            });

            let vm = this
            axios.put('update', {
                id_usuario: vm.user.id_usuario,
                permissoes: vm.user.permissoes
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao atualizar permissões do usuário!', 'Erro')    
            })
        }
    },
    mounted() {
        this.getPermissions()
    },
}
</script>

<style scoped>
    .img-user{ width: 3.5em; margin-right: 1em;}
    .close-tag{ padding: 5px 0 0 0;}
    .switch-permission{padding: 0.4em;}
    .card{padding-bottom: 20px;}
    .card-title{margin-top: -10px; font-size: 1.4em;}
</style>