<template>
    <div>
        <div id="modal_articles" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Associar artigos</h5>
                <div class="input-field col s12 m6 campo-busca">
                    <i class="material-icons prefix">search</i>
                    <input id="busca_pc" type="text" v-model="serach_query_article" class="validate">
                    <label for="busca_pc">Buscar artigos...</label>
                </div>
                <table class="highlight">
                <thead>
                    <tr>
                        <th></th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Autor</th>
                        <th>Data</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(article, index) in articlesData" :key="index">
                        <td>
                             <p>
                                <label>
                                    <input type="checkbox" class="filled-in" v-model="article.check"/>
                                    <span></span>
                                </label>
                            </p>
                        </td>
                        <td> {{article.titulo}} </td>
                        <td> {{article.categoria}} </td>
                        <td> {{article.autor}} </td>
                        <td> {{article.created_at}} </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <a href="#" @click.prevent="saveAssocs()" class="modal-close waves-effect waves-green btn-flat">Concluir</a>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <li class="collection-item avatar">
                        
                        <img v-if="helpdesk.autor_foto" :src="helpdesk.autor_foto" class="circle" alt="Foto usuário">
                        <img v-else src="/KnowWeb/public/img/app/usuario-icon.png" class="circle" alt="Foto usuário">
                        
                        <span style="font-size: 1.5em;" class="title"><b>{{helpdesk.titulo}}</b></span>
                        
                        <p class="grey-text darken-4">Autor: {{ helpdesk.autor }} - {{ helpdesk.created_at }}<br>
                        Categoria: {{ helpdesk.categoria }}<br></p>
                        
                        <div v-if="helpdesk.usuario_solicitante_id != user_id && user_type !== 'Usuario' && (helpdesk.status == 'Aberto' || helpdesk.status == 'Em andamento')">
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
                        </div>
                        <div v-else>
                            <p>Prioridade: {{ helpdesk.prioridade }}</p>
                        </div>

                        <p v-if="helpdesk.arquivos.length > 0">Arquivos: 
                            <a :href="`download/${arquivo.id_arquivo_atendimento}`" v-for="(arquivo, index) in helpdesk.arquivos" :key="index"> {{ arquivo.nome }} </a>
                        </p>
                        
                        <a v-if="helpdesk.status == 'Aberto' && helpdesk.usuario_solicitante_id != user_id && user_type !== 'Usuario'" @click="changeStatus('Em andamento')" class="waves-effect waves-light green btn secondary-content">
                            <i class="material-icons left">open_in_new</i>Atender</a>
                       
                        <div v-if="helpdesk.usuario_solicitante_id == user_id || helpdesk.atendente_responsavel_id == user_id || user_type == 'Administrador'">
                            <a href="#" v-if="helpdesk.status == 'Em andamento'" @click.prevent="confirmAssoc"
                                class="waves-effect waves-light green btn secondary-content">
                                <i class="material-icons left">check_box</i>Finalizar</a>
                        </div>
                        
                        <label class="black-text" style="font-size:16px;">Descrição: </label>
                        <editor name="descricao" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                                menubar: false, toolbar: false}"
                            :initial-value="helpdesk.descricao" :disabled="true" plugins="autoresize">
                        </editor>
                    </li>

                    <li v-if="respostas.length > 0" class="collection-item"><p style="font-size: 1.5em;">Respostas:</p></li>

                    <li v-for="(resp, index) in respostas" :key="index" class="collection-item avatar">
                        
                        <img v-if="resp.autor_foto" :src="resp.autor_foto" class="circle" alt="Foto usuário">
                        <img v-else src="/KnowWeb/public/img/app/usuario-icon.png" class="circle" alt="Foto usuário">
                        
                        <p class="grey-text darken-4">{{ resp.autor }} - {{ resp.created_at }}</p>

                        <p v-if="resp.archives.length > 0">Arquivos: 
                            <a :href="`download/${arquivo.id_arquivo_atendimento}`" v-for="(arquivo, index) in resp.archives" :key="index"> {{ arquivo.nome }} </a>
                        </p>
                        
                        <label class="black-text" style="font-size:16px;">Resposta: </label>
                        <editor name="res" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                                menubar: false, toolbar: false}"
                            :initial-value="resp.resposta" :disabled="true" plugins="autoresize">
                        </editor>
                    </li>

                    <a v-if="helpdesk.status == 'Aberto' || helpdesk.status == 'Em andamento'" class="modal-trigger btn green" href="#modal-response"><i class="material-icons left">create</i>Responder</a>
                    <a class="btn" href="../atendimento"><i class="material-icons left">arrow_back</i>Retornar</a>
                    
                    <div id="modal-response" class="modal">
                        <form @submit.prevent="onSubmit" action="#" method="post" id="form_response">
                            <div class="modal-content">
                                <h5>Nova resposta</h5>
                                    <div class="col s12">
                                        <label style="font-size:16px;">Resposta: </label>
                                        <editor v-model="resposta" name="resposta" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js',images_upload_handler: upload_handler}" 
                                            
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
                                    <div class="row center-align">
                                        <button type="submit" class="waves-effect waves-green btn green"><i class="material-icons left">send</i>Enviar</button>
                                        <a href="#!" class="modal-close waves-effect waves-green btn red"><i class="material-icons left">clear</i>Cancelar</a>
                                    </div>
                            </div>
                        </form>
                    </div>
                </ul>
            </div>
        </div>        
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['user_id', 'user_type', 'helpdesk'],
    data() {
        return {
            respostas: [],
            resposta: '',
            imagens: [],
            arquivos: [],
            artigos: [],
            serach_query_article: ''
        }
    },
    computed: {
        articlesData: function(){
            var filterKey = this.serach_query_article && this.serach_query_article.toLowerCase()
            var dataFilter = this.artigos
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
         onSubmit(){
            this.createResponse()
        },
        changePriority(){
            if(this.user_type == 'Usuario'){
                return false;
            }

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
        confirmAssoc(){
            if(this.user_type == 'Usuario'){
                this.changeStatus('Finalizado')
                return true
            }

            let vm = this
            vm.$snotify.confirm('Deseja associar algum artigo a este atendimento?', 'Associar!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.$snotify.remove(toast.id); $('#modal_articles').modal('open')}},
                    {text: 'Não', action: (toast) => {vm.changeStatus('Finalizado'); vm.$snotify.remove(toast.id)}},
                    {text: 'Cancelar', action: (toast) => vm.$snotify.remove(toast.id)}
                ]
            })
        },
        saveAssocs(){
            let assocs = []
            let vm = this
            this.artigos.forEach(element => {
                if(element.check){
                    assocs.push(element.id_artigo)
                }
            });

            axios.post('artigos', {
                id_atendimento: vm.helpdesk.id_atendimento,
                artigos: assocs
            })
            .then(function(response){
                let stored = response.data.success

                if(stored == true){
                    vm.changeStatus('Finalizado')
                }else{
                    vm.$snotify.error('Falha ao associar artigos!', 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao associar artigos!', 'Erro')
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
                    vm.helpdesk.atendente_responsavel_id = vm.user_id
                    if(status == 'Finalizado'){
                        vm.$snotify.info('A solicitação foi finalizada!', 'Finalizada')
                    }
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
            }).
            finally(function(){
                vm.getResponses();
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
                        vm.getResponses()
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
        },
        getArticles(){
            let vm = this
            axios.get('../artigos/all')
            .then(function(response){
                let articles = response.data.articles

                if(articles){
                    vm.artigos = articles
                }
            })
        }      
    },
    mounted(){
        this.getResponses();
        this.getArticles();
    },
    components: {
        Editor
    }
}
</script>