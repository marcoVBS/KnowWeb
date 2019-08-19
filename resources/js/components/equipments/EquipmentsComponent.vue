<template>
    <div>
        <div class="divider"></div>

        <div class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large teal darken-3 modal-trigger" href="#modalequipment" data-position="left" data-tooltip="Novo!" @click="newEquipment()">
                <i class="large material-icons">add</i>
            </a>
        </div>

         <div id="modal_view" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>{{ view.descricao }}</h4>
                <div class="divider"></div>
                <p><b>Categoria:</b> {{ view.categoria }}</p>
                <div class="divider"></div>
                <p><b>Características: </b><br>{{ view.caracteristicas }}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat red-text">fechar</a>
            </div>
        </div>
          

        <div id="modalequipment" class="modal">
            <div class="modal-content">
                <h5 v-if="update"  class="header grey-text center-align">Edição de equipamento</h5>
                <h5 v-else class="header grey-text center-align">Cadastro de equipamento</h5>

                <form @submit.prevent="onSubmit" action="#"  method="post" id="form_equipment">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mode_edit</i>
                            <input id="descricao" type="text" name="descricao" v-model="equipment.descricao" required>
                            <label for="descricao" v-bind:class="{active: update}">Descricao</label>
                        </div>

                        <div class="input-field col s12">
                             <i class="material-icons prefix">settings</i>
                            <textarea id="caracteristicas" class="materialize-textarea" v-model="equipment.caracteristicas" required></textarea>
                            <label for="caracteristicas" v-bind:class="{active: update}">Características do equipamento</label>
                        </div>

                        <div class="input-field col s12">
                            <select v-model="equipment.categoria_equipamento_id" required>
                                    <option value="" disabled>Selecione...</option>
                                    <option v-for="(categorie, index) in categories" :key="index" :value="categorie.id_categoria_equipamento"> {{categorie.nome}} </option>        
                            </select>
                            <label>Categoria</label>
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
        </div>

        <div class="col s12">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody v-if="equipments.length > 0">
                        <tr v-for="(equip, index) in equipments" :key="index">
                        <td> {{equip.descricao}} </td>
                        <td> {{equip.categoria}} </td>
                        <td class="row">
                                <a href="#modalequipment" class="modal-trigger" @click="loadForm(equip)"><i class="material-icons">edit</i></a>
                                <a href="#modal_view" class="modal-trigger green-text" @click="loadView(equip)"><i class="material-icons">remove_red_eye</i></a>
                                <a class="red-text" href="#" @click.prevent="confirmDelete(equip.id_equipamento, equip.descricao)"><i class="material-icons">delete</i></a>
                        </td>
                        </tr>
                </tbody>
                <tbody v-else>
                        <tr><td class="green-text">Nenhum equipamento cadastrado...</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
export default {
    props: ['categories'],
    data() {
        return {
            equipments: [],
            equipment: {},
            view: {},
            update: false
        }
    },
    methods: {
        onSubmit(){
            if(this.update == true){
                this.updateEquipment();
            }else{
                this.insertEquipment();
            }
        },
        newEquipment(){
            this.update = false
            this.equipment = {}
        },
        closeModal(){
            $('#modalequipment').modal('close')
        },
        insertEquipment(){
            let vm = this
            
            axios.post('equipamentos/create', {
                descricao : vm.equipment.descricao,
                caracteristicas : vm.equipment.caracteristicas,
                categoria: vm.equipment.categoria_equipamento_id
            })
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeModal();
                vm.getEquipments();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch(function(error){
                vm.closeModal()
                vm.$snotify.error('Falha ao cadastrar equipamento!', 'Erro')   
            })
            .finally(function() {
                $('#form_equipment').each(function(){
                    this.reset();
                })
                vm.equipment = {}
            })
        },
        getEquipments(){
            let vm = this
                        
            axios.get("equipamentos/all")
            .then(function(response){
                vm.equipments = response.data.equipments
            })
        },
        confirmDelete(id, name){
            let vm = this
            vm.$snotify.confirm(`Deseja realmente excluir o equipamento ${name}?`, 'Exclusão!', {
                timeout: false,
                position: 'centerCenter',
                buttons:[
                    {text: 'Sim', action: (toast) => {vm.deleteEquipment(id); vm.$snotify.remove(toast.id)}},
                    {text: 'Não', action: (toast) => vm.$snotify.remove(toast.id)},
                ]
            })
        },
        deleteEquipment(id){
            let vm = this
            axios.delete(`equipamentos/delete/${id}`)
                .then(function(response){
                    let stored = response.data.deleted
                    let message = response.data.message

                    if(stored == true){
                        vm.$snotify.success(message, 'Sucesso')
                        vm.getEquipments()
                    }else{
                        vm.$snotify.error(message, 'Erro')
                    }
                })
                .catch((error) => (vm.$snotify.error('Falha ao excluir o Equipamento!', 'Erro')))
        },
        loadForm(equip){
            this.update = true
            this.equipment = equip
        },
        loadView(equip){
            this.view = equip
        },
        updateEquipment(){
            let vm = this
            axios.put('equipamentos/update', vm.equipment)
            .then(function(response){
                let stored = response.data.stored
                let message = response.data.message

                vm.closeModal();
                vm.getEquipments();

                if(stored == true){
                    vm.$snotify.success(message, 'Sucesso')
                }else{
                    vm.$snotify.error(message, 'Erro')
                }
            })
            .catch((error) => (vm.$snotify.error('Falha ao atualizar equipamento', 'Erro')))
            .finally(function(){
                $('#form_equipment').each(function(){
                    this.reset();
                })
            })
        }
    },
    mounted() {
        this.getEquipments()   
    }
}
</script>