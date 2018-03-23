<template>
    <div class="modal fade" id="register-window" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Регистрация</h4>
                </div>
                <div class="modal-body">

                    <!-- Сообщения -->
                    <div class="alert alert-success" v-if="status == 'success'">Вы успешно зарегесрированы! Через {{ seconds }} сек. окно будет автоматически закрыто</div>
                    <div class="alert alert-danger" v-if="status == 'incorrect'">Ошибка при регистрации</div>

                    <!-- Форма регистрации -->
                    <div class="form-group" v-if="this.status != 'success'">
                        <input type="email" class="form-control" placeholder="email" v-model="email">
                        <input type="text" class="form-control" placeholder="имя пользователя" v-model="name">
                        <input type="password" class="form-control" placeholder="пароль" v-model="password">
                        <input type="password" class="form-control" placeholder="повторите пароль" v-model="password_confirmation">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" @click="register" v-if="this.status != 'success'">Создать аккаунт</button>
                    <button class="btn btn-default" @click="cansel">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                email                   : '',
                password                : '',
                password_confirmation   : '',
                name                    : '',
                status                  : '',
                seconds                 : 5,
            }
        },

        methods: {
            
            register() {

                let data = {
                    email                   : this.email,
                    name                    : this.name,
                    password                : this.password,
                    password_confirmation  : this.password_confirmation
                };
               
                axios.post(window.baseurl + 'registration', data).then(response => {     
                    this.clean();
                    this.status = 'success';
                    setTimeout(this.tick, 1000);
                }).catch(error => {
                    this.status     = 'incorrect';
                });

            },

            cansel() {
                if(this.status == 'success') {
                    location.reload();
                } else {
                    this.clean();
                    $('#register-window').modal('hide');
                }                
            },

            /* Тикаем секунды */
            tick() {
                if(this.seconds == 1) {
                    location.reload();
                } else {
                    this.seconds--;
                    setTimeout(this.tick, 1000);
                }
            },

            /* Очищаем поля */
            clean() {
                this.email                  = '';
                this.name                   = '';
                this.password               = '';
                this.password_confirmation  = '';
                this.status                 = '';
            },


        }
    }
</script>