<template>
    <div>
        <div class="divider"></div>

        <div class="row">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">settings</i>Extensões de arquivo permitidas</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <form @submit.prevent="onSubmit" method="post" action="#" id="form_extension">
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
                                <b>{{ ext.extensao }}</b>
                                <a href="#" @click.prevent="deleteExtension(ext.id_extensao_arquivo)"><i class="close material-icons">close</i></a>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>
        </div>

        <div class="row">
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><i class="material-icons left">folder</i>Pasta</span>
                </li>

                <li class="collection-item">
                    <span class="title"><i class="material-icons left">insert_chart</i>Arquivo</span>
                    <div class="secondary-content">
                        <a href="#!"><i class="material-icons">cloud_download</i></a>
                        <a href="#!"><i class="material-icons">edit</i></a>
                        <a href="#!"><i class="material-icons">delete</i></a>
                    </div>
                </li>

                <li class="collection-item">
                    <span class="title"><i class="material-icons left">play_arrow</i>Arquivo</span>
                    <div class="secondary-content">
                        <a href="#!"><i class="material-icons">cloud_download</i></a>
                        <a href="#!"><i class="material-icons">edit</i></a>
                        <a href="#!"><i class="material-icons">delete</i></a>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            extension: {
                name: ""
            },
            extensions: {}
        }
    },
    methods: {
        onSubmit(){
            this.insertExtension()
        }, 
        insertExtension(){
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
        getExtensions(){
            let vm = this
                        
            axios.get("arquivos/extensao/all")
            .then(function(response){
                vm.extensions = response.data.extensions
            })
        },
        deleteExtension(id){
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
    }
}
</script>
