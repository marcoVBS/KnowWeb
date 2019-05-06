<template>
    <div>
        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <li class="collection-item avatar">
                        
                        <img v-if="helpdesk.autor_foto" :src="helpdesk.autor_foto" class="circle" alt="Foto usuário">
                        <img v-else src="/KnowWeb/public/img/app/usuario-icon.png" class="circle" alt="Foto usuário">
                        
                        <span class="title"><b>{{helpdesk.titulo}}</b></span>
                        
                        <p class="grey-text darken-4">Autor: {{ helpdesk.autor }} - {{ helpdesk.created_at }}<br>
                        Categoria: {{ helpdesk.categoria }}<br></p>
                        
                        <p>Prioridade:
                            <label>
                                <input name="prioridade" type="radio" value="Baixa" v-model="helpdesk.prioridade" @change="changePriority()"/>
                                <span>Baixa</span>
                            </label> - 
                        
                            <label>
                                <input name="prioridade" type="radio" value="Média" v-model="helpdesk.prioridade" @change="changePriority()"/>
                                <span>Média</span>
                            </label> - 
                        
                            <label>
                                <input name="prioridade" type="radio" value="Alta" v-model="helpdesk.prioridade" @change="changePriority()"/>
                                <span>Alta</span>
                            </label>
                        </p>

                        <p v-if="helpdesk.arquivos.length > 0">Arquivos: 
                            <a :href="`download/${arquivo.id_arquivo_atendimento}`" v-for="(arquivo, index) in helpdesk.arquivos" :key="index"> {{ arquivo.nome }} </a>
                        </p>

                        <a v-if="helpdesk.status == 'Aberto'" @click="changeStatus('Em andamento')" class="waves-effect waves-light green btn secondary-content">
                            <i class="material-icons left">open_in_new</i>Atender</a>
                        <a v-if="helpdesk.status == 'Em andamento'" @click="changeStatus('Finalizado')" class="waves-effect waves-light green btn secondary-content">
                            <i class="material-icons left">check_box</i>Finalizar</a>
                        
                        <label class="black-text" style="font-size:16px;">Descrição: </label>
                        <editor name="descricao" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                                skin_url: skin, menubar: false, toolbar: false}"
                            :initial-value="helpdesk.descricao" :disabled="true" plugins="autoresize">
                        </editor>
                    </li>

                    <li v-for="(resp, index) in respostas" :key="index" class="collection-item avatar">
                        
                        <img v-if="helpdesk.autor_foto" :src="resp.autor_foto" class="circle" alt="Foto usuário">
                        <img v-else src="/KnowWeb/public/img/app/usuario-icon.png" class="circle" alt="Foto usuário">
                        
                        <p class="grey-text darken-4">{{ resp.autor }} - {{ resp.created_at }}</p>

                        <!-- <p v-if="resp.arquivos.length > 0">Arquivos: 
                            <a :href="`download/${resp.id_arquivo_atendimento}`" v-for="(arquivo, index) in resp.arquivos" :key="index"> {{ arquivo.nome }} </a>
                        </p> -->
                        
                        <label class="black-text" style="font-size:16px;">Resposta: </label>
                        <editor name="res" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                                skin_url: skin, menubar: false, toolbar: false}"
                            :initial-value="resp.resposta" :disabled="true" plugins="autoresize">
                        </editor>
                    </li>

                    <a class="modal-trigger btn" href="#modal-response">Responder</a>
                    
                    <div id="modal-response" class="modal">
                        <form @submit.prevent="onSubmit" action="#" method="post" id="form_response">
                            <div class="modal-content">
                                <h5>Nova resposta</h5>
                                    <div class="col s12">
                                        <label style="font-size:16px;">Resposta: </label>
                                        <editor v-model="resposta" name="resposta" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js',
                                                images_upload_handler: upload_handler, skin_url: skin}" 
                                            
                                            plugins="autoresize print preview fullpage searchreplace fullscreen image link 
                                                hr insertdatetime advlist lists imagetools textpattern  " 
                                            
                                            toolbar="formatselect | bold italic forecolor backcolor | link image | 
                                                alignleft aligncenter alignright alignjustify | numlist bullist outdent indent">
                                        </editor>
                                    </div>

                                    <div class="col s12 file-field input-field">
                                        <div class="btn">
                                            <span>Enviar arquivos...</span>
                                            <input type="file" name="arquivo" id="arquivos" ref="files" multiple @change="changeFiles()">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text">
                                            <span class="helper-text grey-text">Máximo de upload por arquivo é 8mb.</span>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="waves-effect waves-green btn green"><i class="material-icons left">send</i>Enviar</button>
                                <a href="#!" class="modal-close waves-effect waves-green btn red"><i class="material-icons left">clear</i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </ul>
            </div>
        </div>        
    </div>
</template>

<script>
import tinymce from 'tinymce/tinymce';
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['helpdesk'],
    data() {
        return {
            skin: '/KnowWeb/public/skin/ui/oxide',
            respostas: [],
            resposta: '',
            imagens: [],
            arquivos: []
        }
    },
    methods: {
         onSubmit(){
            this.createResponse()
        },
        changePriority(){
            let vm = this
            axios.post('prioridade', {
                id_atendimento: vm.helpdesk.id_atendimento,
                prioridade: vm.helpdesk.prioridade
            })
            .then(function(response){
                let stored = response.data.success

                if(stored == true){
                    vm.$snotify.success('Prioridade alterada com sucesso!', 'Sucesso')
                }else{
                    vm.$snotify.error('Falha ao alterar prioridade!', 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao alterar prioridade!', 'Erro')
            })
        },
        changeStatus(status){
            let vm = this
            axios.post('status', {
                id_atendimento: vm.helpdesk.id_atendimento,
                status: status
            })
            .then(function(response){
                let stored = response.data.success

                if(stored == true){
                    vm.helpdesk.status = status
                }else{
                    vm.$snotify.error('Falha ao alterar prioridade!', 'Erro')
                }
            })
            .catch(function(error){
                if(status == 'Em andamento'){
                    vm.$snotify.error('Falha ao atender solicitação!', 'Erro')
                }else if(status = 'Finalizado'){
                    vm.$snotify.error('Falha ao finalizar solicitação!', 'Erro')
                }
            })
        },
        upload_handler(blobInfo, success, failure){
            let formData;
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            let vm = this
            
            axios.post('resposta/imagem/upload', formData)
            .then(function(response){
                let path = response.data.path
                let name = response.data.name
                success(path);
                vm.imagens.push({caminho: path, nome: name})
            })
            .catch(function(error){
                failure('HTTP Error: ' + error);  
            })    
        },
        changeFiles(){
            let uploadedFiles = this.$refs.files.files;
            let max = false

            if(uploadedFiles.length <= 10){
                for(let i = 0; i < uploadedFiles.length; i++){
                    if(uploadedFiles[i].size < 8388608){
                        this.arquivos.push(uploadedFiles[i]);
                    }else{
                        max = true
                    }
                }
            }else{
                $("#arquivos").val('');
                this.$snotify.error('Aquantidade máxima de arquivos para upload é de 10!', 'Erro')
            }

            if(max){
                $("#arquivos").val('');
                this.arquivos = []
                this.$snotify.error('O tamanho máximo de um arquivo para upload é 8MB!', 'Erro')
            }

        },
        uploadFiles(id_atendimento, id_resposta){
            let success = true
            for(var i = 0; i < this.arquivos.length; i++){
                let formData = new FormData();
                formData.append('file', this.arquivos[i]);
                formData.append('id_atendimento', id_atendimento);
                formData.append('id_resposta', id_resposta);

                axios.post('resposta/upload', formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function(response){
                    if(!response.data.upload){
                        return false;
                    }
                }).catch(function(error){
                    return false;
                })
            }

            return true;

        },
        createResponse(){
            let vm = this
            axios.post('resposta/create', {
                atendimento_id: vm.helpdesk.id_atendimento,
                resposta: vm.resposta,
                imagens: vm.imagens
            })
            .then(function(response){
                let stored = response.data.stored

                if(stored == true){

                    let upload = vm.uploadFiles(response.data.id_atendimento, response.data.id_resposta)
                    if(upload){
                        $('.modal').modal('close')
                        vm.$snotify.success('Sua resposta foi enviada com sucesso!', 'Sucesso')
                    }
                
                }else{
                    vm.$snotify.error('Falha ao enviar resposta!', 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao enviar resposta!', 'Erro')
                $('.modal').modal('close')
            })
            .finally(function() {
                $('#form_response').each(function(){
                    this.reset();
                })
            })
        },
        getResponses(){
            let vm = this
            axios.get(`respostas/${vm.helpdesk.id_atendimento}`)
            .then(function(response){
                let responses = response.data.responses

                if(responses){
                    vm.respostas = responses
                }
            })
        }      
    },
    mounted(){
        this.getResponses();
    },
    components: {
        Editor
    }
}
</script>