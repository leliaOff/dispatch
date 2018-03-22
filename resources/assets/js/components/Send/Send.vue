<template>
    <div>
        <div class="panel-heading"><h1>Отправка сообщения</h1></div><hr/>
        <div class="panel-body">

            <!-- Сообщения для пользователя -->
            <div class="alert alert-warning" v-if="templatesList.length == 0">Для начала отправчки сообщений необходимо создать хотя бы один <router-link to="/">шаблон</router-link></div>

            <!-- Поля для отправки -->
            <div class="row" v-if="templatesList.length > 0">
                
                <!-- Шаблон -->
                <div class="col-sm-4 clearfix"><label class="input-title">Шаблон:</label></div>
                <div class="col-sm-8 clearfix">
                    <div class="form-group">
                        <select v-model="template" class="form-control">
                            <option v-for="template in templatesList" :key="template.id" :value="template">{{ template.title }}</option>
                        </select>
                    </div>
                </div>

                <!-- Пример текста шаблона -->
                <div class="col-sm-4 clearfix" v-if="template.text != undefined"><label class="input-title">Текст шаблона:</label></div>
                <div class="col-sm-8 clearfix" v-if="template.text != undefined">
                    <div class="form-group">
                        <textarea readonly class="form-control" v-model="template.text">{{ template.text }}</textarea>
                    </div>
                </div>

                <!-- Выбор каналов передачи -->
                <div class="col-sm-4 clearfix" v-if="template.text != undefined"><label class="input-title">Каналы передачи:</label></div>
                <div class="col-sm-8 clearfix" v-if="template.text != undefined">
                    <div class="form-group">
                        <easy-checkbox v-for="channel in channelsList"
                            v-on:change="channelChange"
                            :key="channel.id" 
                            :index="channel.name"
                            :label="channel.title">
                        </easy-checkbox>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<script>

    export default {

        components: {
            //singleTemplate: SingleTemplate,
        },
       
        data() {            
            return {
                template        : {},
                channels        : [],
                contact         : '',
                data            : {},

                /* Данный справочников */
                templatesList   : [],
                channelsList    : {},

            }
        },

        methods: {

            /* Получаем список всех шаблонов для пользователя */
            getTemplates() {

                axios.get(window.baseurl + 'templates').then(response => {     
                    this.templatesList = response.data;
                }).catch(error => {
                    console.log(error);
                });

            },

            /* Получаем список всех каналов */
            getChannels() {

                axios.get(window.baseurl + 'channels').then(response => {     
                    this.channelsList = response.data;
                }).catch(error => {
                    console.log(error);
                });

            },

            /* Изменили список каналов */
            channelChange(name, state) {
                if(state === true) {
                    if(!this.channels.includes(name)) {
                        this.channels.push(name);
                    }
                } else {
                    let i = this.channels.indexOf(name);
                    this.channels.splice(i, 1);
                }
            },


        },

        mounted() {
            this.getTemplates();
            this.getChannels();
        }
    }
</script>