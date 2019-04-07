<template>
        <div class="row">
           <h5 class="header grey-text center-align">Categorias de atendimento
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">
                <i class="material-icons left">add_circle</i>Nova</a>
           </h5>
            <!-- Modal Structure -->
                <div id="modal1" class="modal">
                        <div class="modal-content">
                                <h5 class="header grey-text center-align">Cadastro de categoria de atendimento</h5>
                                <form-categorie-component :route="['teste']"></form-categorie-component>
                        </div>
                </div>
        </div>
</template>

<script>

import FormCategorieComponent from './FormCategorieComponent.vue';

export default {
        data() {
                return {
                        
                }
        },
        components:{
                FormCategorieComponent
        }
}
</script>

<style scoped>

</style>
