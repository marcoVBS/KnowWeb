<template>
    <div class="container container2">

        <div v-if="manage_file_extensions" class="row">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">settings</i>Extensões de arquivo permitidas</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <form @submit.prevent="onSubmitExtension" method="post" action="#" id="form_extension">
                                <div class="input-field">
                                    <i class="material-icons prefix">add_circle</i>
                                    <input id="extensao" type="text" v-model="extension.name" class="validate">
                                    <label for="extensao">Nova extensão. Ex: jpg</label>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <span class="text-center">Tipos de arquivos permitidos para upload:</span>
                            <div class="divider"></div><br>

                            <div v-for="(ext, index) in extensions" :key="index" class="chip">
                                <a href="#" @click.prevent="confirmDeleteExtension(ext.id_extensao_arquivo, ext.extensao)"><i class="material-icons right close-tag red-text">close</i></a><b>{{ ext.extensao }}</b>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>
        </div>

        <div v-if="upload_files" class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger pulse"  href="#modalfiles" data-position="left" data-tooltip="Enviar arquivos!">
                <i class="large material-icons">attach_file</i>
            </a>
        </div>

        <div v-if="list_files" class="row">
            <div class="input-field col s12 m6 campo-busca">
                <i class="material-icons prefix">search</i>
                <input id="icon_prefix" type="text" v-model="search_query" class="validate">
                <label for="icon_prefix">Buscar arquivos...</label>
            </div>

            <table class="highlight">
                <thead>
                    <tr>
                        <th>Nome do Arquivo</th>
                        <th>Categoria</th>
                        <th>Tamanho</th>
                        <th>Usuário</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(file, index) in filteredData" :key="index">
                        <td>
                            <img :src="file.img_ext" class="icon_files"><span class="text_files"><b>{{file.nome}}</b></span>
                        </td>
                        <td>{{file.categoria}}</td>
                        <td>{{file.tamanho}}</td>
                        <td>{{file.usuario}}</td>
                        <td>{{file.created_at}}</td>
                        <td>
                            <a v-if="download_files" :href="`arquivos/download/${file.id_arquivo}`" class="green-text"><i class="material-icons">cloud_download</i></a>
                            <a v-if="delete_file" href="#!" class="red-text darken-4" @click.prevent="confirmDelete(file.id_arquivo, file.nome)"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

         <div id="modalfiles" class="modal">
            <div class="modal-content">
                <h5 v-if="update"  class="header grey-text center-align">Edição de arquivo</h5>
                <h5 v-else class="header grey-text center-align">Novos arquivos</h5>

                <form @submit.prevent="onSubmitFile" action="#"  method="post" id="form_files">
                    <div class="row">
                        <div class="input-field col s10">
                            <select v-model="categoria_id" name="categoria" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option v-for="(categorie, index) in categories" :key="index" v-bind:value="categorie.id_categoria_arquivo"> {{ categorie.nome }} </option>        
                            </select>
                            <label>Categoria</label>
                        </div>

                        <div class="input-field col s2">
                            <a class="btn tooltipped waves-effect waves-light teal darken-3" href="categorias" data-position="left" data-tooltip="Gerenciar">
                                <i class="material-icons">settings</i>
                            </a>
                        </div>

                        <div class="col s12 file-field input-field">
                            <div class="btn">
                                <span>Selecionar arquivos...</span>
                                <input type="file" name="arquivo" id="arquivos" ref="files" multiple @change="changeFiles()">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row center-align">   
                        <div v-if="progress" class="progress">
                            <div class="indeterminate"></div>
                        </div>

                        <button class="btn waves-effect waves-light green" type="submit">Enviar
                            <i class="material-icons right">send</i>
                        </button>

                        <button class="modal-close btn waves-effect waves-light red" type="reset">cancelar
                            <i class="material-icons right">clear</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['categories','manage_file_extensions', 'list_files', 'upload_files', 'download_files', 'delete_file'],
    data() {
        return {
            extension: {
                name: ""
            },
            extensions: [],
            update: false,
            categoria_id: '',
            arquivos_up: [],
            files: [],
            progress: false,
            search_query: ''
        }
    },
    computed: {
        filteredData: function(){
            var filterKey = this.search_query && this.search_query.toLowerCase()
            var dataFilter = this.files
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
            $('#form_files').each(function(){
                this.reset();
            })
            $('.modal').modal('close')
            this.arquivos_up = []
            this.progress = false
        },
        onSubmitExtension(){
            this.insertExtension()
        }, 
        onSubmitFile(){
            this.uploadFiles()
        },
        changeFiles(){
            let uploadedFiles = this.$refs.files.files;

            if(uploadedFiles.length <= 10){
                for(let i = 0; i < uploadedFiles.length; i++){
                    this.arquivos_up.push(uploadedFiles[i]);
                }
            }else{
                this.closeModal()
                this.$snotify.error('Aquantidade máxima de arquivos para upload é de 10!', 'Erro')
            }

        },
        uploadFiles(){
            if(!this.upload_files){
                return false;
            }

            let vm = this
            this.progress = true

            for(var i = 0; i < this.arquivos_up.length; i++){
                let formData = new FormData();
                formData.append('file', this.arquivos_up[i]);
                formData.append('categorie', this.categoria_id);

                axios.post('arquivos/novo', formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function(response){
                    let stored = response.data.stored

                    vm.closeModal() 

                    if(stored == true){
                        vm.$snotify.success(response.data.message, 'Sucesso')
                        vm.getFiles()
                    }else{
                        if(response.data.message){
                            vm.$snotify.error(response.data.message, 'Erro de Tipo')
                        }else{
                            vm.$snotify.error('Falha ao enviar arquivo!', 'Erro')
                        }
                    }

                }).catch(function(error){
                    vm.closeModal() 
                    vm.$snotify.error('Falha ao enviar arquivo!', 'Erro')
                })
            }

            return true;

        },
        confirmDelete(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o arquivo ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteFile(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteFile(id){
            if(!this.delete_file){
                return false;
            }

            let vm = this
            axios.delete(`arquivos/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getFiles()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch((error) => (vm.$snotify.error('Falha ao excluir o arquivo!', 'Erro')))
        },
        insertExtension(){
            if(!this.manage_file_extensions){
                return false;
            }

            let vm = this
            
            axios.post('arquivos/extensao/create', {
                extensao: vm.extension.name,
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.getExtensions();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.extension.name = ""
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao cadastrar extensão!', 'Erro')
            })
            .finally(function() {
                $('#form_extension').each(function(){
                    this.reset();
                })
            })    
        },
        getFiles(){
            if(!this.list_files){
                return false;
            }

            let vm = this
                        
            axios.get("arquivos/all")
            .then(function(response){
                vm.files = response.data.files
            })
        },
        getExtensions(){
            if(!this.manage_file_extensions){
                return false;
            }

            let vm = this
                        
            axios.get("arquivos/extensao/all")
            .then(function(response){
                vm.extensions = response.data.extensions
            })
        },
        confirmDeleteExtension(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir a extensao ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteExtension(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteExtension(id){
            
            if(!this.manage_file_extensions){
                return false;
            }

            let vm = this
            axios.delete(`arquivos/extensao/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getExtensions()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch((error) => (vm.$snotify.error('Falha ao excluir o extensão!', 'Erro')))
        }
    },
    mounted() {
        this.getExtensions()  
        this.getFiles() 
    }
}
</script>

<style scoped>
.icon_files{
    width: 20px;
}
.text_files{
    padding-left: 10px;
}
.campo-busca{
    margin-top: -15px;
}
.close-tag{
    padding: 5px 0 0 0;
}
</style>
