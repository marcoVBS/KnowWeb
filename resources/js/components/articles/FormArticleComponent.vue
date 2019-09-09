<template>
    <div>
        <h5 v-if="update" class="header grey-text">Editar Artigo</h5>
        <h5 v-else class="header grey-text">Novo Artigo</h5>
        
        <div class="col s12">
            
            <form @submit.prevent="onSubmit" action="#" method="post" id="form_article">
                
                <div class="row">
                    <div class="input-field col s12 m7">
                        <input id="titulo" type="text" name="titulo" v-model="article.titulo" required>
                        <label for="titulo">Título</label>
                    </div>

                    <div class="input-field col s12 m5">
                        <select v-model="article.categoria_artigo_id" name="categoria" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option v-for="(categorie, index) in categories" :key="index" v-bind:value="categorie.id_categoria_artigo"> {{ categorie.nome }} </option>        
                        </select>
                        <label>Categoria</label>
                    </div>

                   <div class="input-field col s12">
                        <textarea id="descricao" v-model="article.descricao" class="materialize-textarea"></textarea>
                        <label for="descricao">Descrição</label>
                    </div>
                    
                    <div class="col s12">
                        <label style="font-size:16px;">Conteúdo: </label>
                        <editor v-model="article.conteudo" name="conteudo" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                            
                            :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                            images_upload_handler: upload_handler}"
                            
                            plugins="autoresize print preview fullpage searchreplace fullscreen image link 
                                codesample table hr insertdatetime advlist lists imagetools textpattern" 
                            
                            toolbar="formatselect | bold italic forecolor backcolor | link image codesample | 
                                alignleft aligncenter alignright alignjustify | numlist bullist outdent indent">
                        </editor>
                    </div>
                    
                    <div class="input-field col s12">
                        <div class="chips chips-autocomplete">
                            <input id="titulo">
                            <label for="titulo" class="active">Tags</label>
                        </div>
                    </div>
                </div>

                <div class="divider"></div><br>

                <div class="row">   
                    <button class="btn waves-effect waves-light green" type="submit">Salvar
                        <i class="material-icons right">send</i>
                    </button>

                    <button class="btn waves-effect waves-light red" type="reset">Limpar
                        <i class="material-icons right">clear</i>
                    </button>

                    <a href="../artigos" class="btn">Cancelar</a>

                </div>
                
            </form>

        </div>
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue';


export default {
    props: ['update', 'categories', 'all_tags'],
    data() {
        return {
            article: {},
            imagens: [],
            tags: [],
            instance: null
        }
    },
    methods: {
        onSubmit(){
            this.instance[0].chipsData.forEach(element => {
                this.tags.push(element.tag);
            });

            this.createArticle()
        },
        upload_handler(blobInfo, success, failure) {
            let formData;
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            let vm = this
            
            axios.post('novo/imagem/upload', formData)
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
        createArticle(){
            let vm = this

            axios.post('novo/create', {
                titulo: vm.article.titulo,
                descricao : vm.article.descricao,
                conteudo: vm.article.conteudo,
                categoria_id: vm.article.categoria_artigo_id,
                imagens: vm.imagens,
                tags: vm.tags
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    setTimeout(function(){
                        window.location.href = "/KnowWeb/public/artigos"
                    }, 2000)                
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao cadastrar artigo!', 'Erro')
            })
        }      
    },
    components: {
        Editor
    },
    mounted() {
        let dados = {}
        this.all_tags.forEach(element => {
            dados[element.nome] = null                      
        }) 

        var elems = document.querySelectorAll('.chips')
        this.instance = M.Chips.init(elems, {
            placeholder: 'Tag...',
            autocompleteOptions: {
                data: dados,
                limit: 5,
                minLength: 1
            }
        });
    }
}
</script>

<style scoped>

</style>