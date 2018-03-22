<template>
    <div>
        <!-- Модальное окно - подтверждение действия -->
        <div class="modal fade" id="confirm-window" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{ title }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ text }}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" @click="confirm" type="button" >Да</button>
                        <button class="btn btn-info" @click="cansel" type="button" >Нет</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of modal-->
    </div>
</template>

<script>
    export default {

        props: ['title', 'text'],
        
        methods: {
            
            confirm() {
                $('#confirm-window').modal('hide');
                this.$emit('change', true);
            },

            cansel() {
                $('#confirm-window').modal('hide');
                this.$emit('change', false);
            }

        }
    }
</script>