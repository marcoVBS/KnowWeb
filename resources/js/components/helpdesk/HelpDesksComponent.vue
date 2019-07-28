<template>
    <div class="row">
        <h5 class="header grey-text center-align">Solicitações de Atendimento</h5><div class="divider"></div>

        <ul class="collection with-header col s12 m3">
            <li class="collection-header center-align"><a class="waves-effect waves-light btn btn-large green darken-3" href="atendimento/novo"><i class="material-icons left">add_circle_outline</i>Solicitar</a></li><br>
            <li><a href="#" @click.prevent="changeType('Aberto')" class="collection-item" v-bind:class="{active: aberto}">Abertas<i class="material-icons secondary-content">open_in_new</i></a></li>
            <li><a href="#" @click.prevent="changeType('Em andamento')" class="collection-item" v-bind:class="{active: andamento}">Em andamento<i class="material-icons secondary-content">access_time</i></a></li>
            <li><a href="#" @click.prevent="changeType('Finalizado')" class="collection-item" v-bind:class="{active: finalizado}">Finalizadas<i class="material-icons secondary-content">check</i></a></li>
            <br>
        </ul>

        <div class="col s12 m9">
            <div v-for="(helpdesk, index) in helpdesks" :key="index">
                <div v-if="helpdesk.status == status" class="col s12 m6">
                    <a :href="`atendimento/${helpdesk.id_atendimento}`">
                        <div class="card black-text grey lighten-5">
                            <div class="card-content waves-effect waves-block">
                                <span class="card-title card-helpdesk-title green-text"><b>{{ helpdesk.titulo }}</b></span><div class="divider"></div>
                                <p><b>Autor:</b> {{ helpdesk.autor }} - {{ helpdesk.created_at }}</p>
                                <p><b>Categoria:</b> {{ helpdesk.categoria }} </p>
                                <p><b>Status:</b> {{ helpdesk.status }} - <b>Prioridade:</b> {{ helpdesk.prioridade }}</p>
                                <p v-if="helpdesk.responsavel"><b>Atendente Responsável:</b> {{ helpdesk.responsavel }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    props: ['helpdesks'],
    data() {
        return {
            status: "Aberto",
            aberto: true,
            andamento: false,
            finalizado: false
        }
    },
    methods: {
        changeType(status){
            this.status = status
            this.aberto = this.status == "Aberto"
            this.andamento = this.status == "Em andamento"
            this.finalizado = this.status == "Finalizado"
        }
    }
}
</script>

<style scoped>
.card-helpdesk-title{
    font-size: 1.4em;
}
</style>
