import { createRouter, createWebHistory } from 'vue-router';

import common_routes from '../router/common';
import guest_routes from '../router/guest';
import admin_routes from '../router/admin';

var routes = [];

routes = routes.concat(common_routes);
routes = routes.concat(guest_routes);
routes = routes.concat(admin_routes);


const router = createRouter({
    history : createWebHistory(),
    routes : routes
})

export default router;