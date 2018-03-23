<template>
    <div class="modal fade" id="login-window" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Авторизация</h4>
                </div>
                <div class="modal-body">

                    <!-- Сообщения -->
                    <div class="alert alert-success" v-if="status == 'success'">Вы успешно выполнили вход в систему! Через {{ seconds }} сек. окно будет автоматически закрыто</div>
                    <div class="alert alert-danger" v-if="status == 'incorrect'">Неверный пароль или пользователь не найден</div>
                    
                    <!-- Форма входа -->
                    <div class="form-group" v-if="this.status != 'success'">
                        <input type="email" class="form-control" placeholder="email" v-model="email">
                        <input type="password" class="form-control" placeholder="пароль" v-model="password">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" @click="login" v-if="this.status != 'success'">Войти</button>
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
                email       : '',
                password    : '',
                status      : '',
                seconds     : 5,
            }
        },

        methods: {
            
            login() {
               
                axios.post(window.baseurl + 'login', { email: this.email, password: this.password }).then(response => {     
                    this.password   = '';
                    this.status = response.data;
                    setTimeout(this.tick, 1000);
                }).catch(error => {
                    this.password   = '';
                    this.status     = 'incorrect';
                });

            },

            cansel() {
                if(this.status == 'success') {
                    location.reload();
                } else {
                    this.email      = '';
                    this.password   = '';
                    this.status     = '';
                    $('#login-window').modal('hide');
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
            }


        }
    }
</script>