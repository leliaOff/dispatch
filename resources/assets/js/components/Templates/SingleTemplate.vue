<template>
    <div class="modal fade" id="single-template-window" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Шаблон</h4>
                </div>
                <div class="modal-body">

                    <!-- Сообщения -->
                    <div class="alert alert-success" v-if="status == 'success'">Шаблон успешно сохранен</div>
                    <div class="alert alert-danger" v-if="status == 'fail'">Ошибка при сохранении шаблона</div>
                    
                    <!-- Поля шаблона -->
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="alias" v-model="alias">
                        <input type="text" class="form-control" placeholder="наименование шаблона" v-model="title">
                        <textarea class="form-control" placeholder="текст шаблона" v-model="text"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" @click="save">Сохранить</button>
                    <button class="btn btn-default" @click="cansel">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['value'],
        
        data() {
            return {
                status      : '',
                id          : this.value.id,
                alias       : this.value.alias,
                title       : this.value.title,
                text        : this.value.text,
            }
        },

        watch: {
            value: function(value) {
                this.id     = value.id;
                this.alias  = value.alias;
                this.title  = value.title;
                this.text   = value.text;
                this.status = '';
            }
        },

        methods: {
            
            save() {
                
                if(this.id == 0) {
                    
                    /* Создаем новый шаблон */
                    axios.post(window.baseurl + 'template/create', { alias: this.alias, title: this.title, text: this.text }).then(response => {     
                        this.id     = response.data.id;
                        this.status = 'success';
                        this.$emit('change');
                    }).catch(error => {
                        this.status = 'fail';
                    });

                } else {

                    /* Обновляем шаблон */
                    axios.post(window.baseurl + 'template/update/' + this.id, { alias: this.alias, title: this.title, text: this.text }).then(response => {     
                        this.status = 'success';
                        this.$emit('change');
                    }).catch(error => {
                        this.status = 'fail';
                    });

                }
            },

            cansel() {
                $('#single-template-window').modal('hide');                
            },

        }
    }
</script>