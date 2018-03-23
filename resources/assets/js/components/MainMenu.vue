<template>
    <div>
        <div class="top-right links" id="main-menu">
            <ul class="menu">
                <li v-if="user"><router-link to="/" tag="button" class="btn btn-link">Шаблоны</router-link></li>
                <li v-if="user"><router-link to="/send" tag="button" class="btn btn-link">Рассылка</router-link></li>
                <li v-if="!user"><button class="btn btn-link" data-toggle="modal" data-target="#register-window">Регистрация</button></li>
                <li v-if="!user"><button class="btn btn-link" data-toggle="modal" data-target="#login-window">Авторизация</button></li>
                <li v-if="user"><label>{{ user }}</label><button class="btn btn-link" @click="logout">Выход</button></li>
            </ul>
        </div>
        <login-form></login-form>
        <register-form></register-form>
    </div>
</template>

<script>

    import Login    from './Auth/Login.vue';
    import Register from './Auth/Register.vue';

    export default {

        components: {
            loginForm       : Login,
            registerForm    : Register,
        },

        computed: {
            user() {
                return user;
            }
        },

        methods: {
            
            /* Выход */
            logout() {

                axios.post(window.baseurl + 'logout', { }).then(response => {
                    location.reload();
                }).catch(function (error) {
                    console.log(error);
                });

            },
            
        },

    }
</script>