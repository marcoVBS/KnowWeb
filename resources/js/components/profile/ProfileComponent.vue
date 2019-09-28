<template>
    <div>
        <br>
        <div class="col s12 m8">

            <form @submit.prevent="onSubmitImage" action="#" method="post" id="form_update_image">
                <div class="row center-align">

                    <div class="col s12 m6 file-field input-field">
                        <div class="btn">
                            <span>nova foto</span>
                            <input type="file" name="foto" id="foto" ref="foto" @change="changeImage()">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>

                    <div class="col s12 m3">
                        <img v-if="user_logged.foto" id="image_upload_preview" :src="user_logged.foto" alt="Imagem de perfil" width="100px" height="100px" style="border-radius: 50%;"/>
                        <img v-else id="image_upload_preview" src="/KnowWeb/public/img/begin/100x100.png" alt="Imagem de perfil" width="100px" height="100px" style="border-radius: 50%;"/>
                    </div>

                    <div class="col s12 m3">
                        <br>
                        <button class="btn waves-effect waves-light green valign-wrapper" type="submit">alterar</button>
                    </div>

                </div>
            </form>

            <form @submit.prevent="onSubmitProfile" action="#" method="post" id="form_update_profile">
                
                <div class="row">
                            
                    <div class="divider"></div>
                    <h5 class="header grey-text">Editar Perfil</h5>

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="nome" type="text" name="nome" v-model="user_logged.nome" required>
                            <label for="nome">Nome</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="email" type="email" name="email" v-model="user_logged.email" required>
                            <label for="email">Email</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                            <vue-mask id="telefone" type="text" mask="(00) 00000-0000" :raw="false" v-model="user_logged.telefone" class="validate" required></vue-mask>
                            <label for="telefone">Telefone</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <vue-mask id="cpf" type="text" mask="000.000.000-00" :raw="false" v-model="user_logged.cpf" class="validate" disabled></vue-mask>
                            <label for="cpf">CPF</label>
                        </div>
                   
                        <div class="input-field col s12 m6">
                            <select v-model="user_logged.setor_id" required>
                                    <option value="" disabled>Selecione...</option>
                                    <option v-for="(sector, index) in sectors" :key="index" :value="sector.id_setor"> {{sector.nome}} </option>        
                            </select>
                            <label>Setor</label>
                        </div>
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

        <div class="col s12 m4 form-register">

            <h5 class="header grey-text">Alterar senha</h5>

            <form @submit.prevent="onSubmitPassword" action="#"  method="post" id="form_update_password">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="senha_atual" type="password" name="senha_atual" v-model="current_pass" required>
                        <label for="senha_atual">Senha atual</label>
                    </div>

                    <div class="input-field col s12">
                        <input id="nova_senha" type="password" v-model="new_pass" name="nova_senha" required>
                        <label for="nova_senha">Nova senha</label>
                    </div>

                    <div class="input-field col s12">
                        <input id="confirmacao_senha" type="password" v-model="new_pass2" name="confirmacao_senha" required>
                        <label for="confirmacao_senha">Confirmar nova senha</label>
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
</template>

<script>
export default {
    props: ['sectors', 'user_logged'],
    data() {
        return {
            new_image: '',
            current_pass: '',
            new_pass: '',
            new_pass2: '',
        }
    },
    methods: {
        changeImage(){
            let uploadedFile = this.$refs.foto.files[0]
            this.new_image = uploadedFile;
        },
        onSubmitImage(){
            let vm = this

            let formData = new FormData();
            formData.append('file', this.new_image);

            axios.post('perfil/updateImage', formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
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
            .catch((error) => (vm.$snotify.error('Falha ao atualizar foto', 'Erro')))
        },
        onSubmitProfile(){
            let vm = this
            axios.put('perfil/updateProfile', vm.user_logged)
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar perfil', 'Erro')))
        },
        onSubmitPassword(){
            let vm = this
            if(this.new_pass == this.new_pass2){
                if(this.new_pass.length >= 8){
                    axios.put('perfil/updatePassword', 
                    {   
                        senha_atual : vm.current_pass,
                        nova_senha : vm.new_pass
                    })
                    .then(function(response){
                        let stored = response.data.stored
                        let message = response.data.message

                        if(stored == true){
                            vm.current_pass = ''
                            vm.new_pass = ''
                            vm.new_pass2 = ''
                            vm.$snotify.success(message, 'Sucesso')
                        }else{
                            vm.$snotify.error(message, 'Erro')
                        }
                    })
                    .catch((error) => (vm.$snotify.error('Falha ao atualizar senha', 'Erro')))
                    .finally(function() {
                        $('#form_update_password').each(function(){
                            this.reset();
                        })
                    })
                }else{
                    vm.$snotify.error('A nova senha deve conter no mínimo 8 caracteres', 'Erro')
                }
            }else{
                vm.$snotify.error('As senhas informadas não conferem', 'Erro')
            }
        }
    },
    mounted() {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('#image_upload_preview').attr('src', e.target.result);
                }
    
                reader.readAsDataURL(input.files[0]);
            }
        }
    
        $("#foto").change(function () {
            readURL(this);
        });
    },
}
</script>

<style scoped>

</style>