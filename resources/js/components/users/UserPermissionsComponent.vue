<template>
    <div>
        <div v-if="manage_permissions" class="row">
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
                                <b>{{ perm.nome }}</b>
                                <a href="#" @click.prevent="deletePermission(perm.id_permissao)"><i class="close material-icons">close</i></a>
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

            <h5>Permissões de <b>{{ user.nome }}</b></h5>
            <h6 class="header grey-text"><b>Tipo do usuário: </b>{{user.tipo_usuario}}</h6>
            <div class="divider"></div><br>

             <div v-for="(perm, index) in permissions" :key="index" class="switch col s12 m4 form-register">
                <b>{{ perm.nome }}: </b>
                <label>
                    Off
                    <input type="checkbox" v-model="perm.check">
                    <span class="lever"></span>
                    On
                </label><br><br>
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
            },
        }
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
</style>