<template>
        <div class="row">
            <h5 class="header grey-text center-align">Solicitar atendimento</h5>
            <div class="col s12">
                <form @submit.prevent="onSubmit" action="#"  method="post" id="form_cat">
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
                            <label style="font-size:16px;">Assunto: </label>
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
                                <input type="file" name="arquivos" multiple>
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
    props: ['categories','token'],
    data() {
        return {
            skin: 'skin/ui/oxide',
            titulo: '',
            categoria_id: '',
            descricao: ''
        }
    },
    methods: {
        onSubmit(){
            
        },
        upload_handler: function (blobInfo, success, failure,folderName) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            
            xhr.open('POST', 'atendimento/imagem/upload');
            xhr.setRequestHeader("X-CSRF-Token", this.token);
            
            xhr.onload = function() {
                var json;
                
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.path != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.path);
                
            };
            
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
        
            xhr.send(formData);
               
        }                
    },
    components: {
        Editor
    }
}
</script>

<style scoped>

</style>
