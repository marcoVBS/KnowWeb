<template>
    <div>
        <h5 v-if="update" class="header grey-text">Editar Artigo</h5>
        <h5 v-else class="header grey-text">Novo Artigo</h5>
    
        <div class="col s12 m8">
            
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
                        <div class="chips chips-autocomplete"></div>
                    </div>
                </div>

                <div class="divider"></div><br>

                <div class="row center-align">   
                    <button class="btn waves-effect waves-light green" type="submit">Salvar
                        <i class="material-icons right">send</i>
                    </button>

                    <button class="btn waves-effect waves-light red" type="reset">Limpar
                        <i class="material-icons right">clear</i>
                    </button>

                    <a href="../artigos" class="btn">Voltar</a>

                </div>
                
            </form>

        </div>

        <div class="col s12 m4 form-register">
            <h5 class="header grey-text center-align">Associações</h5><div class="divider"></div>
            <div>
                <p><b>Ações:</b>
                    <a href="#modal_files" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="Associar Arquivo">
                        <i class="material-icons left">archive</i>
                    </a>
                    <a href="#modal_passwords" class="btn-floating yellow darken-1 tooltipped modal-trigger" data-position="top" data-tooltip="Associar Senha">
                        <i class="material-icons">security</i>
                    </a>
                    <a href="#modal_computers" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="Associar Computador">
                        <i class="material-icons">computer</i>
                    </a>
                    <a href="#modal_equipments" class="btn-floating blue tooltipped modal-trigger" data-position="top" data-tooltip="Associar Equipamento">
                        <i class="material-icons">router</i>
                    </a>
                </p>
            </div>

            <ul class="collapsible">
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">archive</i>Arquivos associados</div>
                    <div class="collapsible-body">
                        <div v-for="(file, index) in files" :key="index">
                            <div v-if="file.check">
                                <div><img :src="'../'+file.img_ext" class="icon_files"><b><span class="text_files">{{file.nome}}</span></b></div>
                                <p><b>Categoria: </b>{{file.categoria}}<br>
                                <b>Tamanho: </b>{{file.tamanho}}</p>
                                <div class="divider"></div><br>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">security</i>Senhas associadas</div>
                    <div class="collapsible-body">
                        <div v-for="(pass, index) in passwords" :key="index">
                            <div v-if="pass.check">
                                <p><b>Descrição: </b>{{pass.descricao}}<br>
                                <b>Login: </b>{{pass.login}}</p>
                                <p v-if="pass.equipamento"><b>Equipamento: </b>{{pass.equipamento.descricao}}</p>
                                <div class="divider"></div><br>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">computer</i>Computadores associados</div>
                    <div class="collapsible-body">
                        <div v-for="(pc, index) in computers" :key="index">
                            <div v-if="pc.check">
                                <p><b>Placa-mãe: </b>{{pc.placa_mae}}<br>
                                <b>Processador: </b>{{pc.processador}}<br>
                                <b>RAM: </b>{{pc.memoria_ram}}<br>
                                <b>Setor: </b>{{pc.setor}}<br>
                                <b>Identificador: </b>{{pc.identificador_computador}}<br>
                                <b>Ocorrências: </b>{{pc.count}}</p>
                                <div class="divider"></div><br>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">router</i>Equipamentos associados</div>
                    <div class="collapsible-body">
                        <div v-for="(equip, index) in equipments" :key="index">
                            <div v-if="equip.check">
                                <p><b>Descrição: </b>{{equip.descricao}}<br>
                                <b>Categoria: </b>{{equip.categoria}}</p>
                                <div class="divider"></div><br>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

        </div>

        <div id="modal_files" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Associar arquivos</h5>
                <div class="input-field col s12 m6 campo-busca">
                    <i class="material-icons prefix">search</i>
                    <input id="busca_arquivo" type="text" v-model="search_query_file" class="validate">
                    <label for="busca_arquivo">Buscar arquivos...</label>
                </div>
                <table class="highlight">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome do Arquivo</th>
                        <th>Categoria</th>
                        <th>Tamanho</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(file, index) in filesData" :key="index">
                        <td>
                             <p>
                                <label>
                                    <input type="checkbox" class="filled-in" v-model="file.check"/>
                                    <span></span>
                                </label>
                            </p>
                        </td>
                        <td>
                            <img :src="'../'+file.img_ext" class="icon_files"><span class="text_files"><b>{{file.nome}}</b></span>
                        </td>
                        <td>{{file.categoria}}</td>
                        <td>{{file.tamanho}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-close waves-effect waves-green btn-flat">Concluir</a>
            </div>
        </div>

        <div id="modal_passwords" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Associar senhas</h5>
                <div class="input-field col s12 m6 campo-busca">
                    <i class="material-icons prefix">search</i>
                    <input id="busca_senha" type="text" v-model="search_query_passwords" class="validate">
                    <label for="busca_senha">Buscar senhas...</label>
                </div>
                <table class="highlight">
                <thead>
                    <tr>
                        <th></th>
                        <th>Descrição</th>
                        <th>Login</th>
                        <th>Equipamento</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(pass, index) in passwordsData" :key="index">
                        <td>
                             <p>
                                <label>
                                    <input type="checkbox" class="filled-in" v-model="pass.check"/>
                                    <span></span>
                                </label>
                            </p>
                        </td>
                        <td>{{pass.descricao}}</td>
                        <td>{{pass.login}}</td>
                        <td v-if="pass.equipamento"> {{pass.equipamento.descricao}} </td>
                        <td v-else></td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-close waves-effect waves-green btn-flat">Concluir</a>
            </div>
        </div>

        <div id="modal_computers" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Associar computadores</h5>
                <div class="input-field col s12 m6 campo-busca">
                    <i class="material-icons prefix">search</i>
                    <input id="busca_pc" type="text" v-model="search_query_computers" class="validate">
                    <label for="busca_pc">Buscar computadores...</label>
                </div>
                <table class="highlight">
                <thead>
                    <tr>
                        <th></th>
                        <th>Placa-mãe</th>
                        <th>Processador</th>
                        <th>RAM</th>
                        <th>Identificador</th>
                        <th>Setor</th>
                        <th>Ocorrências</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(pc, index) in computersData" :key="index">
                        <td>
                             <p>
                                <label>
                                    <input type="checkbox" class="filled-in" v-model="pc.check"/>
                                    <span></span>
                                </label>
                            </p>
                        </td>
                        <td> {{pc.placa_mae}} </td>
                        <td> {{pc.processador}} </td>
                        <td> {{pc.memoria_ram}} </td>
                        <td> {{pc.identificador_computador}} </td>
                        <td> {{pc.setor}} </td>
                        <td v-if="pc.check"><input style="width: 2.5em;" type="number" v-model="pc.count"></td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-close waves-effect waves-green btn-flat">Concluir</a>
            </div>
        </div>

        <div id="modal_equipments" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Associar equipamentos</h5>
                <div class="input-field col s12 m6 campo-busca">
                    <i class="material-icons prefix">search</i>
                    <input id="busca_equipamento" type="text" v-model="search_query_equipments" class="validate">
                    <label for="busca_equipamento">Buscar equipamentos...</label>
                </div>
                <table class="highlight">
                <thead>
                    <tr>
                        <th></th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(equip, index) in equipmentsData" :key="index">
                        <td>
                             <p>
                                <label>
                                    <input type="checkbox" class="filled-in" v-model="equip.check"/>
                                    <span></span>
                                </label>
                            </p>
                        </td>
                        <td>{{equip.descricao}}</td>
                        <td>{{equip.categoria}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-close waves-effect waves-green btn-flat">Concluir</a>
            </div>
        </div>

    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['update', 'categories', 'all_tags', 'articleupdate'],
    data() {
        return {
            article: {
                files: [],
                passwords: [],
                computers: [],
                equipments: []
            },
            imagens: [],
            tags: [],
            instance: null,
            files: [],
            passwords: [],
            computers: [],
            equipments: [],
            search_query_file: '',
            search_query_passwords: '',
            search_query_computers: '',
            search_query_equipments: '',

        }
    },
    computed: {
        filesData: function(){
            var filterKey = this.search_query_file && this.search_query_file.toLowerCase()
            var dataFilter = this.files
            if (filterKey) {
                dataFilter = dataFilter.filter(function (row) {
                return Object.keys(row).some(function (key) {
                    return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                })
                })
            }
            return dataFilter
        },
        passwordsData: function(){
            var filterKey = this.search_query_passwords && this.search_query_passwords.toLowerCase()
            var dataFilter = this.passwords
            if (filterKey) {
                dataFilter = dataFilter.filter(function (row) {
                return Object.keys(row).some(function (key) {
                    return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                })
                })
            }
            return dataFilter
        },
        equipmentsData: function(){
            var filterKey = this.search_query_equipments && this.search_query_equipments.toLowerCase()
            var dataFilter = this.equipments
            if (filterKey) {
                dataFilter = dataFilter.filter(function (row) {
                return Object.keys(row).some(function (key) {
                    return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                })
                })
            }
            return dataFilter
        },
        computersData: function(){
            var filterKey = this.search_query_computers && this.search_query_computers.toLowerCase()
            var dataFilter = this.computers
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
        load_files(){
            let vm = this
           
            axios.get('../arquivos/all')
            .then(function(response){
                vm.files = response.data.files
                if(vm.update){
                    if(vm.article.files_id){
                        vm.files.map(function(e){
                            if(vm.article.files_id.indexOf(e.id_arquivo) > -1){
                                e.check = true
                            }
                        })
                    }
                }
            })
        },
        load_passwords(){
            let vm = this
       
            axios.get("../senhas/all")
            .then(function(response){
                vm.passwords = response.data.passwords
                if(vm.update){
                    if(vm.article.passwords_id){
                        vm.passwords.map(function(e){
                           if(vm.article.passwords_id.indexOf(e.id_senha) > -1){
                               e.check = true
                           }
                       })
                    }
                }
            })
        },
        load_computers(){
            let vm = this

            axios.get('../computadores/all')
            .then(function(response){
                vm.computers = response.data.computers
                if(vm.update){
                    if(vm.article.computers_id){
                        let ids = vm.article.computers_id.map(function(e){
                            return e.id
                        })

                        vm.computers.map(function(e){
                            let index = ids.indexOf(e.id_computador)

                            if(index > -1){
                                e.check = true
                                e.count = vm.article.computers_id[index].count
                            }
                       })
                    }
                }
            })
        },
        load_equipments(){
            let vm = this
       
            axios.get("../equipamentos/all")
            .then(function(response){
                vm.equipments = response.data.equipments
                if(vm.update){
                    if(vm.article.equipments_id){
                        vm.equipments.map(function(e){
                            if(vm.article.equipments_id.indexOf(e.id_equipamento) > -1){
                                e.check = true
                            }
                        })
                    }
                }
            })
        },
        onSubmit(){
            this.change_assocs()
            if(this.update){
                this.updateArticle()
            }else{
                this.createArticle()
            }
        },
        change_assocs(){
            this.instance[0].chipsData.forEach(element => {
                this.tags.push(element.tag);
            });
            
            this.files.forEach(element => {
                if(element.check){
                    this.article.files.push(element.id_arquivo)
                }
            });

            this.passwords.forEach(element => {
                if(element.check){
                    this.article.passwords.push(element.id_senha)
                }
            });

            this.computers.forEach(element => {
                if(element.check){
                    if(element.count){
                        this.article.computers.push({'id' : element.id_computador, 'count': element.count})
                    }else{
                        this.article.computers.push({'id' : element.id_computador, 'count': 1})
                    }
                }
            });

            this.equipments.forEach(element => {
                if(element.check){
                    this.article.equipments.push(element.id_equipamento)
                }
            });
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
                tags: vm.tags,
                archives: vm.article.files,
                passwords: vm.article.passwords,
                computers: vm.article.computers,
                equipments: vm.article.equipments
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
        },
        updateArticle(){
            let vm = this

            axios.put('update', {
                id_artigo: vm.article.id_artigo,
                titulo: vm.article.titulo,
                descricao : vm.article.descricao,
                conteudo: vm.article.conteudo,
                categoria_id: vm.article.categoria_artigo_id,
                imagens: vm.imagens,
                tags: vm.tags,
                archives: vm.article.files,
                passwords: vm.article.passwords,
                computers: vm.article.computers,
                equipments: vm.article.equipments
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                    vm.tags = []
                    vm.article.files = []
                    vm.article.passwords = []
                    vm.article.computers = []
                    vm.article.equipments = []
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar artigo', 'Erro')))
        }   
    },
    components: {
        Editor
    },
    mounted() {
        
        let init = []
        if(this.update){
            this.article = this.articleupdate
            this.article.files = []
            this.article.passwords = []
            this.article.computers = []
            this.article.equipments = []

            if(this.article.tags){
                this.article.tags.forEach(element => {
                    init.push({
                        tag: element
                    })
                })
                this.tags = []
            }
        }

        let dados = {}
        this.all_tags.forEach(element => {
            dados[element.nome] = null                      
        })

        var elems = document.querySelectorAll('.chips')
        this.instance = M.Chips.init(elems, {
            placeholder: 'Tag...',
            data: init,
            autocompleteOptions: {
                data: dados,
                limit: 5,
                minLength: 1
            }
        });
        
        this.load_files()
        this.load_passwords()
        this.load_equipments()
        this.load_computers()
    }
}
</script>

<style>
.icon_files{
    width: 20px;
}
.text_files{
    padding-left: 10px;
}
</style>