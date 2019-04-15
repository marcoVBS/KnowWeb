<template>
    <div>
        <form @submit.prevent="onSubmit" action="#"  method="post" id="form_cat">
            <div class="row">
                <div class="input-field col s12">
                    <input id="nome" type="text" name="nome" v-model="categorie.nome" required v-bind:class="{validate: !update}">
                    <label for="nome" v-bind:class="{active: update}">Nome</label>
                </div>

                <div class="input-field col s12">
                    <input id="descricao" type="text" v-model="categorie.descricao" name="descricao">
                    <label for="descricao" v-bind:class="{active: update}">Descrição</label>
                </div>
            </div>

            <div class="row center-align">   
                <button class="btn waves-effect waves-light green" type="submit">Enviar
                    <i class="material-icons right">send</i>
                </button>

                <button class="btn waves-effect waves-light red" type="reset">Limpar
                    <i class="material-icons right">clear</i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['route', 'categorie', 'update'],
    methods: {
        onSubmit(){
            if(this.update == true){
                this.updateCategorie();
            }else{
                this.insertCategorie();
            }
        },
        insertCategorie(){
            let vm = this
            
            axios.post(this.route, {
                nome: vm.categorie.nome,
                descricao : vm.categorie.descricao
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeForm();
                vm.getCategories();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.$snotify.error('Falha ao cadastrar categoria', 'Erro')
                vm.closeForm()    
            })
            .finally(function() {
                $('#form_cat').each(function(){
                    this.reset();
                })
            })
        },
        updateCategorie(){
            let vm = this
            axios.put(vm.route, vm.categorie)
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeForm();
                vm.getCategories();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar categoria', 'Erro')))
            .finally(function(){
                $('#form_cat').each(function(){
                    this.reset();
                })
            })
        },
        closeForm(){
            this.$emit('closeModal')
        },
        getCategories(){
            this.$emit('getCategories')
        }
    }
}
</script>

<style scoped>

</style>