<template>
    <div>

        <div class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="artigos/novo" data-position="left" data-tooltip="Novo!">
                <i class="large material-icons">add</i>
            </a>
        </div>

         <ul class="collection col s12">
            <li v-for="article in articles" :key="article.id_artigo" class="collection-item avatar waves-effect waves-block">
                <img v-if="article.autor_foto" :src="article.autor_foto" alt="imagem_usuario" class="circle">
                <img v-else src="img/app/usuario-icon.png" alt="imagem_usuario" class="circle">
                <span class="title"><p class="green-text card-article-title"><b>{{ article.titulo }}</b></p></span>
                <p><b>Autor:</b> {{ article.autor }} - {{ article.created_at }}</p>
                <p><b>Categoria:</b> {{ article.categoria }} </p>
        
                <div v-for="(tag, index) in article.tags" :key="index" class="chip"> {{ tag }} </div>
                
                <p v-if="article.atualizador"><b>Última atualização:</b> {{ article.updated_at }} - {{ article.atualizador }} </p>
                <div class="secondary-content">
                    <a href="#"><i class="material-icons green-text">edit</i></a>
                    <a href="#"><i class="material-icons red-text">delete</i></a>
                </div>
            </li>
        </ul>


    </div>
</template>

<script>
export default {
    props: ['articles']
}
</script>

<style scoped>
    .card-article-title{
        font-size: 1.4em;
    }
</style>