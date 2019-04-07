<template>
    <form method="POST" :action="route">
        <div class="row">
            <div class="input-field col s12">
                <input id="nome" type="text" name="nome" required class="validate">
                <label for="nome">Nome</label>
            </div>

            <div class="input-field col s12">
                <input id="descricao" type="text" name="descricao">
                <label for="descricao">Descrição</label>
            </div>
        </div>

        <div class="row center-align">   
            <button class="btn waves-effect waves-light green" type="submit">Cadastrar
                <i class="material-icons right">send</i>
            </button>

            <button class="btn waves-effect waves-light red" type="reset">Limpar
                <i class="material-icons right">clear</i>
            </button>
        </div>

    </form>
</template>

<script>
export default {
    props: ['route'],
}
</script>

<style scoped>

</style>