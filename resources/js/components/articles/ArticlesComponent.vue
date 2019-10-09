<template>
    <div>
        <div v-if="create_article" class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="artigos/novo" data-position="left" data-tooltip="Novo!">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">search</i>
            <input id="icon_prefix" type="text" v-model="search_query" class="validate">
            <label for="icon_prefix">Buscar artigos...</label>
        </div>

        <div class="col s12 m6">
            Ordenar por: 
            <p>
                <label>
                    <input name="group1" type="radio" value="titulo" v-model="sortKey"/>
                    <span>Título</span>
                </label>
                <label>
                    <input name="group1" type="radio" value="categoria" v-model="sortKey"/>
                    <span>Categoria</span>
                </label>
                <label>
                    <input name="group1" type="radio" value="autor" v-model="sortKey"/>
                    <span>Autor</span>
                </label>
                <label>
                    <input name="group1" type="radio" value="updated_at" v-model="sortKey"/>
                    <span>Última atualização</span>
                </label>
            </p>
        </div>

         <ul class="collection col s12">
            <li v-for="article in filteredData" :key="article.id_artigo" class="collection-item avatar waves-effect waves-block">
                <a :href="`artigos/${article.id_artigo}`">
                    <img v-if="article.autor_foto" :src="article.autor_foto" alt="imagem_usuario" class="circle">
                    <img v-else src="img/app/usuario-icon.png" alt="imagem_usuario" class="circle">
                    <span class="title"><p class="green-text card-article-title"><b>{{ article.titulo }}</b></p></span>
                    <p class="black-text"><b>Autor:</b> {{ article.autor }} - {{ article.created_at }}</p>
                    <p class="black-text"><b>Categoria:</b> {{ article.categoria }} </p>
                    <p class="black-text" v-if="article.atualizador"><b>Última atualização:</b> por {{ article.atualizador }} - {{ article.updated_at }} </p>
            
                    <div v-for="(tag, index) in article.tags" :key="index" class="chip"> {{ tag }} </div>
                    
                    <div class="secondary-content">
                        <a v-if="edit_article" :href="`artigos/atualizar${article.id_artigo}`"><i class="material-icons green-text">edit</i></a>
                        <a v-if="user_id == article.usuario_autor_id || delete_article" @click.prevent="confirmDelete(article.id_artigo, article.titulo)" href="#"><i class="material-icons red-text">delete</i></a>
                    </div>
                </a>
            </li>
        </ul>


    </div>
</template>

<script>
export default {
    props: ['user_id', 'create_article', 'edit_article', 'delete_article'],
    data() {
        return {
            articles: [],
            search_query: '',
            sortKey: 'updated_at'
        }
    },
    watch: {
        sortKey: function(val){
            if(val == 'titulo'){
                this.articles.sort(function(a,b){
                    return a.titulo.toLowerCase() < b.titulo.toLowerCase() ? -1 : a.titulo.toLowerCase() > b.titulo.toLowerCase() ? 1 : 0
                })
            }else if(val == 'categoria'){
                this.articles.sort(function(a,b){
                    return a.categoria < b.categoria ? -1 : a.categoria > b.categoria ? 1 : 0
                })
            }else if(val == 'autor'){
                this.articles.sort(function(a,b){
                    return a.autor < b.autor ? -1 : a.autor > b.autor ? 1 : 0
                })
            }else if(val == 'updated_at'){
                this.articles.sort(function(a,b){
                    let dateA = a.updated_at.split(' ')
                    let hourA = dateA[1]
                    dateA = new Date(dateA[0].split('/').reverse().join('/'))
                    
                    let dateB = b.updated_at.split(' ')
                    let hourB = dateB[1]
                    dateB = new Date(dateB[0].split('/').reverse().join('/'))

                    if(dateA > dateB){
                        return 1
                    }else if(dateA < dateB){
                        return -1
                    }else{
                        return hourA > hourB ? 1 : hourA < hourB ? -1 : 0
                    }
                }).reverse()
            }
        }
    },
    computed: {
        filteredData: function(){
            var filterKey = this.search_query && this.search_query.toLowerCase()
            var dataFilter = this.articles
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
        getArticles(){
            let vm = this
                        
            axios.get("artigos/all")
            .then(function(response){
                vm.articles = response.data.articles
            })
        },
        confirmDelete(id, titulo){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o artigo ${titulo}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteArticle(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteArticle(id){
            
            let vm = this
            axios.delete(`artigos/delete/${id}`)
            .then(function(response){
                let stored = response.data.deleted
                let message = response.data.message

                if(stored == true){
                    vm.getArticles()
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao excluir o artigo!', 'Erro')))
        }
    },
    mounted() {
        this.getArticles()   
    }
}
</script>

<style scoped>
    .card-article-title{
        font-size: 1.4em;
    }
</style>