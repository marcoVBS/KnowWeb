<template>
    <div class="row">
        <h5 class="header grey-text center-align">Atendimentos | 
            <a class="waves-effect waves-light btn" href="atendimento/novo">
            <i class="material-icons left">add_circle</i>Solicitar</a>
        </h5><div class="divider"></div>

        <div v-for="(helpdesk, index) in helpdesks" :key="index" class="col s12 m6 l4">
            <a :href="`atendimento/${helpdesk.id_atendimento}`">
                <div class="card black-text">
                    <div class="card-content waves-effect waves-block">
                        <span class="card-title"><b>{{ helpdesk.titulo }}</b></span><div class="divider"></div>
                        <p><b>Autor:</b> {{ helpdesk.autor }} - {{ helpdesk.created_at }}</p>
                        <p><b>Categoria:</b> {{ helpdesk.categoria }} </p>
                        <p><b>Status:</b> {{ helpdesk.status }} - <b>Prioridade:</b> {{ helpdesk.prioridade }}</p>
                        <p v-if="helpdesk.responsavel"><b>Atendente Responsável:</b> {{ helpdesk.responsavel }}</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</template>

<script>
export default {
    props: ['helpdesks']
}
</script>