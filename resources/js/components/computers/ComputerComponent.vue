<template>
    <div>
        <h5 class="header grey-text"><i class="medium material-icons left">settings</i>Informações do Computador</h5><div class="divider"></div><br>
        
        <div class="row">
            <div class="col s12 m6 form-register">
                <p><b>Placa-mãe: </b>{{ computer.placa_mae }}<br>
                <b>Processador: </b>{{ computer.processador }}<br>
                <b>Memória RAM: </b>{{ computer.memoria_ram }}<br>
                <b>Armazenamento: </b>{{ computer.unidade_armazenamento }}<br>
                <b>Sistema Operacional: </b>{{ computer.so.nome}} {{computer.so.versao}} - {{computer.so.arquitetura }}<br>
                <b>Senha administrador: </b>{{ computer.senha_usuario_adm  }}</p>
            </div>

            <div class="col s12 m6 form-register">
                <p><b>MAC Ethernet: </b>{{ computer.mac_ethernet }}<br>
                <b>MAC Wireless: </b>{{ computer.mac_wireless }}<br>
                <b>Setor: </b>{{ computer.setor }}<br>
                <b>Nome do computador: </b>{{ computer.nome_computador  }}<br>
                <b>Identificador do computador: </b>{{ computer.identificador_computador }}</p>
            </div>

            <div class="col s12 form-register">
                <p><b>Programas específicos: </b>{{ computer.programas_especificos }}</p>
            </div>
        </div>

        <div v-if="articles.length > 0" class="row">
            <div class="divider"></div>
            <h5 class="header grey-text">Histórico do computador</h5>

            <ul class="col s12 collapsible">
                <li v-for="(article, index) in articles" :key="index">
                     <div class="collapsible-header"><i class="material-icons">library_books</i> <b>{{ article.titulo }}</b></div>
                     <div class="collapsible-body">
                            <p><b>Descrição: </b>{{ article.descricao }}<br>
                            <b>Autor: </b>{{ article.autor }} - {{ article.created_at }}<br>
                            <b>Nrº de Ocorrências: </b>{{ article.contador }}</p>
                            <a class="btn green" :href="`../artigos/${article.id_artigo}`" target="_blank"><i class="material-icons right">remove_red_eye</i> Vizualizar artigo</a>
                     </div>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
export default {
    props: ['computer' , 'articles']
}
</script>