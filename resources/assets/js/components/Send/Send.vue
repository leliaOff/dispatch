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

                <!-- Текста шаблона -->
                <div class="col-sm-4 clearfix" v-if="template.text != undefined"><label class="input-title">Текст шаблона:</label></div>
                <div class="col-sm-8 clearfix" v-if="template.text != undefined">
                    <div class="form-group">
                        <textarea readonly class="form-control" v-model="template.text">{{ template.text }}</textarea>
                    </div>
                </div>

                <!-- Ввод данных, которые встречаются в шаблоне -->
                <div v-for="(value, key) in templatesData" :key="key">
                    <div class="col-sm-4 clearfix"><label class="input-title">{{ key }}:</label></div>
                    <div class="col-sm-8 clearfix form-group">
                        <input type="text" class="form-control" v-model="templatesData[key]" :placeholder="'введите: ' + key" v-on:keyup="getResultText"/>
                    </div>
                </div>

                <!-- Результат подставления данных -->
                <div class="col-sm-4 clearfix" v-if="template.text != undefined"><label class="input-title">Текст шаблона:</label></div>
                <div class="col-sm-8 clearfix" v-if="template.text != undefined">
                    <div class="form-group">
                        <textarea readonly class="form-control" v-model="resultText">{{ resultText }}</textarea>
                    </div>
                </div>

                <div class="col-sm-12 clearfix" v-if="template.text != undefined"><hr/></div>

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

                <!-- Ввод контактов - куда отправлять -->
                <div class="row" v-for="contactsType in contactsTypesList" :key="contactsType.name">
                    <div class="col-sm-4 clearfix"><label class="input-title">Список {{ contactsType.title }}</label></div>
                    <div class="col-sm-8 clearfix form-group">
                        <textarea class="form-control" v-model="contacts[contactsType.name]" placeholder="введите данные через запятую или пробел"></textarea>
                    </div>
                </div>

                <!-- Кнопка -->
                <div class="col-sm-12 clearfix" v-if="template.alias != undefined">
                    <button class="btn btn-success" @click="send">Отправить</button>    
                </div>

            </div>

        </div>
    </div>
</template>

<script>

    export default {
       
        data() {            
            return {
                template            : {},
                channels            : [],
                contacts            : {},

                /* Данные справочников */
                templatesList       : [],   //Список шаблонов
                channelsList        : {},   //Список каналов передачи данных

                /* Текст результата, после подставления занчений */
                resultText          : ''

            }
        },

        computed: {

            /* Список необходимых типов контактных данных */
            contactsTypesList() {
                let list = {};
                for(let name in this.channels) {
                    list[this.channels[name]] = this.channelsList[name].contacts_type;
                }
                return list;
            },

            /* Список необходимых данных для шаблона */
            templatesData() {

                if(this.template.text == undefined) return {};

                let text = this.template.text;
                let reg = /\{([\w]*)\}/gi;
                let result = {};
                let match;
                while((match = reg.exec(text)) !== null) {
                    result[match[1]] = '';
                }

                return result;

            },

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

                let channels = this.channels;

                if(state === true) {
                    if(channels[name] == undefined) {
                        channels[name] = this.channelsList[name].contacts_type.name;
                    }
                } else {
                    delete channels[name];
                }

                this.channels = Object.assign({}, channels);
            },

            /* Какой текст получится */
            getResultText() {
                
                let text = this.template.text;
                let reg = /\{([\w]*)\}/gi;
                text = text.replace(reg, (str, key) => {
                    return this.templatesData[key];
                });

                this.resultText = text;

            },

            /* Сформировать и отправить запросы */
            send() {

                let data = {
                    template    : this.template.alias,
                    channels    : this.channels,
                    contacts    : this.contacts,
                    data        : this.templatesData
                };

                axios.post(window.baseurl + 'sends/create', data).then(response => {     
                    console.log(response.data);
                }).catch(error => {
                    console.log(error);
                });

            }

        },

        mounted() {

            /* Загружаем данные српавочников */
            this.getTemplates();
            this.getChannels();
            
        }
    }
</script>