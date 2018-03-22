import VueRouter from 'vue-router';

let routes = [
    { path: '/', component: require('./components/Templates/Templates.vue') },
];

const router = new VueRouter({
    routes
});

/**
 * @brief Настройки для маршрутизатора
 */
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (sessionApiId === '') {
            window.location = baseurl;
        } else {
            next();
        }
    } else {
        if(to.fullPath.indexOf("manager") != -1 && to.fullPath != '/manager') {
            localStorage['manager_mode'] = to.fullPath;
        }
        next();
    }
});

export default router;