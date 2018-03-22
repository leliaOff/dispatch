<template>
    <div class="modal fade" id="register-window" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Регистрация</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" @click="register">Создать аккаунт</button>
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
            
            register() {
               
                // axios.post(window.baseurl + 'login', { email: this.email, password: this.password }).then(response => {     
                //     this.password   = '';
                //     this.status = response.data;
                //     setTimeout(this.tick, 1000);
                // }).catch(error => {
                //     this.password   = '';
                //     this.status     = 'incorrect';
                // });

            },

            cansel() {
                if(this.status == 'success') {
                    location.reload();
                } else {
                    // this.email      = '';
                    // this.password   = '';
                    // this.status     = '';
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
            }


        }
    }
</script>