<template>
    <div>

        <div class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="artigos/novo" data-position="left" data-tooltip="Novo!">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div class="col s12 m5">
            <h4 class="header grey-text center-align"><i class="material-icons">library_books</i> Artigos</h4>
        </div>

        <div class="input-field col s12 m7">
            <i class="material-icons prefix">search</i>
            <input id="icon_prefix" type="text" v-model="search_query" class="validate">
            <label for="icon_prefix">Buscar artigos...</label>
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
                        <a :href="`artigos/atualizar${article.id_artigo}`"><i class="material-icons green-text">edit</i></a>
                        <a v-if="(user_id == article.usuario_autor_id)" @click.prevent="confirmDelete(article.id_artigo, article.titulo)" href="#"><i class="material-icons red-text">delete</i></a>
                    </div>
                </a>
            </li>
        </ul>


    </div>
</template>

<script>
export default {
    props: ['user_id'],
    data() {
        return {
            articles: [],
            search_query: ''
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