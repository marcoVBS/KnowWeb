<template>
    <div>
        <div v-if="article.autor_foto">
            <img :src="article.autor_foto" alt="imagem_usuario" class="circle img-user left"><h4 class="header green-text">{{ article.titulo }}</h4><div class="divider"></div>
        </div>
        <div v-else>
            <img src="/KnowWeb/public/img/app/usuario-icon.png" alt="imagem_usuario" class="circle img-user left"><h4 class="header green-text">{{ article.titulo }}</h4><div class="divider"></div>
        </div>
        
        <div class="col s12">
            <p style="font-size: 1.4em;"><b>Descrição: </b> {{ article.descricao }}</p>
            <p>
                <b>Categoria:</b> {{ article.categoria }} <br>
                <b>Autor:</b> {{ article.autor }} - {{ article.created_at }} <br>
                <span class="black-text" v-if="article.atualizador"><b>Última atualização:</b> por {{ article.atualizador }} - {{ article.updated_at }} </span>
            </p>

            <ul class="collapsible">
                <li>
                    <div class="collapsible-header green-text darken-4"><i class="material-icons">link</i>Associações</div>
                    <div class="collapsible-body">

                        <div class="row" v-if="article.atendimentos">
                            <div class="divider"></div>
                            <p><b><i class="material-icons left">help_outline</i> Atendimentos:</b></p>
                            <div class="col s12 m6" v-for="(helpdesk, index) in article.atendimentos" :key="index">
                                <div class="form-register view-assoc">
                                    <p><b>Título: </b>{{helpdesk.titulo}} <br>
                                    {{helpdesk.autor}} - {{helpdesk.created_at}}<br>
                                    <a :href="`../atendimento/${helpdesk.id_atendimento}`">Visualizar</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="article.arquivos">
                            <div class="divider"></div>
                            <p><b><i class="material-icons left">archive</i> Arquivos:</b></p>
                            <div class="col s12 m4" v-for="(file, index) in article.arquivos" :key="index">
                                <div class="form-register view-assoc">
                                    <a v-if="download_files" :href="`../arquivos/download/${file.id_arquivo}`"><img :src="'../'+file.img_ext" class="icon_files"><b><span class="text_files">{{file.nome}}</span></b></a>
                                    <span v-else><img :src="'../'+file.img_ext" class="icon_files">{{file.nome}}</span>
                                    <p><b>Categoria: </b>{{file.categoria}} <br>
                                    <b>Tamanho: </b>{{file.tamanho}}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" v-if="article.senhas">
                            <div class="divider"></div>
                            <p><b><i class="material-icons left">security</i> Senhas:</b></p>
                            <div class="col s12 m6" v-for="(pass, index) in article.senhas" :key="index">
                                <div class="form-register view-assoc">
                                    <p>
                                        <b>Descrição: </b>{{pass.descricao}} <br>
                                        <b>Login: </b>{{pass.login}} <br>
                                        <b>Senha:</b> 
                                            <span v-if="show && view_password">{{ pass.senha }}</span>
                                            <a v-else-if="!show && view_password" href="#" @click.prevent="showPass()">Exibir senha</a>
                                            <span v-else>********</span>
                                    </p>

                                    <p v-if="pass.equipamento"><b>Equipamento: </b>{{pass.equipamento.descricao}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="article.computadores">
                            <div class="divider"></div>
                            <p><b><i class="material-icons left">computer</i> Computadores:</b></p>
                            <div class="col s12 m4" v-for="(pc, index) in article.computadores" :key="index">
                                <div class="form-register view-assoc">
                                    <p><b>Placa-mãe: </b>{{pc.placa_mae}}<br>
                                    <b>Processador: </b>{{pc.processador}}<br>
                                    <b>RAM: </b>{{pc.memoria_ram}}<br>
                                    <b>Setor: </b>{{pc.setor}}<br>
                                    <b>Identificador: </b>{{pc.identificador_computador}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="article.equipamentos">
                            <div class="divider"></div>
                            <p><b><i class="material-icons left">router</i> Equipamentos:</b></p>
                            <div class="col s12 m6" v-for="(equip, index) in article.equipamentos" :key="index">
                                <div class="form-register view-assoc">
                                    <p><b>Descrição: </b>{{equip.descricao}}<br>
                                    <b>Categoria: </b>{{equip.categoria}}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>

            <editor name="descricao" api-key="k9nq1pz5sirugp247sm9bg2tb42ks18ttmcxjxni7iknoisv" 
                :init="{language: 'pt_BR', language_url: '/KnowWeb/public/js/tiny_pt_BR.js', 
                    menubar: false, toolbar: 'fullscreen preview print'}"
                :initial-value="article.conteudo" plugins="autoresize fullscreen preview print">
            </editor><br>
            <b>Tags: </b><div v-for="(tag, index) in article.tags" :key="index" class="chip"> {{ tag }} </div><div class="divider"></div><br>
                    
            <a href="../artigos" class="btn"><i class="material-icons left">keyboard_return</i>Voltar</a>
            <a v-if="edit_article" :href="`../artigos/atualizar${article.id_artigo}`" class="btn green"><i class="material-icons left">edit</i>Editar</a>
            
        </div>
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['article', 'edit_article', 'download_files', 'view_password'],
    data() {
        return {
            show: false
        }
    },
    methods: {
        showPass(){
            this.show = true
        }
    },
    components: {
        Editor
    },
}
</script>

<style scoped>
    .view-assoc{padding-left: 1em;}
    .img-user{ width: 4em; margin-right: 1em;}
</style>