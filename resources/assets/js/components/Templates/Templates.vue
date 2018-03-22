<template>
    <div>
        <div class="panel-heading"><h1>Справочник шаблонов</h1></div><hr/>
        <div class="panel-body">
            
            <!-- Список всех шаблонов -->
            <div class="row" v-for="template in templates" :key="template.id">
                <div class="col-sm-3 clearfix">{{ template.alias }}</div>
                <div class="col-sm-5 clearfix">{{ template.title }}</div>
                <div class="col-sm-2 clearfix"><button class="btn btn-link" data-toggle="modal" data-target="#single-template-window" @click="getTemplate(template.id)">Изменить</button></div>
                <div class="col-sm-2 clearfix"><button class="btn btn-link" @click="confirm(template.id)">Удалить</button></div>
            </div>

            <!-- Создать новый шаблон -->
            <div class="row">
                <div class="col-sm-7 clearfix"></div>
                <div class="col-sm-5 clearfix align-right"><button class="btn btn-success" data-toggle="modal" data-target="#single-template-window" @click="cleanSingleTemplate()">Создать новый шаблон</button></div>
            </div>

        </div>

        <!-- Редактирование шаблона -->
        <single-template v-model="singleTemplateData" v-on:change="getTemplates"></single-template>

        <!-- Окно-подтверждение удаления -->
        <confirm-modals title="Удаление шаблона" text="Уверены, что хотите удалить этот шаблон?" v-on:change="deleteTemplate" ></confirm-modals>

    </div>
</template>

<script>

    import SingleTemplate from './SingleTemplate.vue';

    export default {

        components: {
            singleTemplate: SingleTemplate,
        },
       
        data() {
            
            return {
                templates:          [],
                singleTemplateData: {},
                currentTemplateId:  0
            }

        },

        methods: {

            /* Получаем список всех шаблонов для пользователя */
            getTemplates() {

                axios.get(window.baseurl + 'templates').then(response => {     
                    this.templates = response.data;
                }).catch(error => {
                    console.log(error);
                });

            },

            /* Актуальные данные по шаблону */
            getTemplate(id) {

                axios.get(window.baseurl + 'template/' + id).then(response => {     
                    this.singleTemplateData = response.data;
                }).catch(error => {
                    console.log(error);
                });

            },

            /* Очистить данные для создания нового шаблона */
            cleanSingleTemplate() {
                this.singleTemplateData = {
                    id      : 0,
                    alias   : '',
                    title   : '',
                    text    : ''
                };
            },

            /* Подтверждение удаления шаблона */
            confirm(id) {
                this.currentTemplateId = id;
                $('#confirm-window').modal('show');
            },

            /* Удаление шаблона */
            deleteTemplate(state) {

                if(state === false) return;

                axios.get(window.baseurl + 'template/delete/' + this.currentTemplateId).then(response => {     
                    this.getTemplates();
                }).catch(error => {
                    console.log(error);
                });

            }

        },

        mounted() {
            this.getTemplates();
        }
    }
</script>