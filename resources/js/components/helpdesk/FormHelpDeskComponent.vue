<template>
        <div class="row">
            <h5 class="header grey-text center-align">Solicitar atendimento</h5>
            <div class="col s12">
                <form @submit.prevent="onSubmit" action="#" method="post" id="form_help">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="titulo" type="text" name="titulo" v-model="titulo" required>
                            <label for="titulo">Título</label>
                        </div>

                        <div class="input-field col s12">
                                <select v-model="categoria_id" name="categoria" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option v-for="(categorie, index) in categories" :key="index" v-bind:value="categorie.id_categoria_atendimento"> {{ categorie.nome }} </option>        
                                </select>
                                <label>Categoria</label>
                        </div>

                        <div class="col s12">
                            <label style="font-size:16px;">Descrição: </label>
                            <editor v-model="descricao" name="descricao" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                                :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                                    images_upload_url: '/KnowWeb/public/atendimento/imagem/upload', 
                                    images_upload_handler: upload_handler, height : '600px', skin_url: skin}" 
                                
                                plugins="print preview fullpage searchreplace fullscreen image link 
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

        </div>
</template>

<script>
import tinymce from 'tinymce/tinymce';
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['categories'],
    data() {
        return {
            skin: 'skin/ui/oxide',
            titulo: '',
            categoria_id: '',
            descricao: '',
            imagens: [],
            arquivos: []
        }
    },
    methods: {
        onSubmit(){
            this.createHelpDesk()
        },
        upload_handler(blobInfo, success, failure) {
            let formData;
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            let vm = this
            
            axios.post('atendimento/imagem/upload', formData)
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

            for(var i = 0; i < uploadedFiles.length; i++){
                this.arquivos.push(uploadedFiles[i]);
            }
        },
        uploadFiles(id_atendimento){
            let success = true
            for(var i = 0; i < this.arquivos.length; i++){
                let formData = new FormData();
                formData.append('file', this.arquivos[i]);
                formData.append('id', id_atendimento);

                axios.post('atendimento/upload', formData,
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
        createHelpDesk(){
            let vm = this

            axios.post('atendimento/create', {
                titulo: vm.titulo,
                descricao: vm.descricao,
                categoria_id: vm.categoria_id,
                imagens: vm.imagens
            })
            .then(function(response){
                let stored = response.data.stored

                if(stored == true){

                    let upload = vm.uploadFiles(response.data.id)
                    if(upload){
                        vm.$snotify.success('Sua solicitação foi enviada com sucesso!', 'Sucesso')
                    }
                
                }else{
                    vm.$snotify.error('Falha ao enviar solicitação de atendimento', 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao enviar solicitação de atendimento', 'Erro')
            })
            .finally(function() {
                $('#form_help').each(function(){
                    this.reset();
                })
            })

        }              
    },
    components: {
        Editor
    }
}
</script>

<style scoped>

</style>
