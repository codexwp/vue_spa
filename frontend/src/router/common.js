import { store } from '../store/index'

const ifNotAuthenticated = (to, from, next) => {
    if (store.state.auth === '') {
      next()
      return
    }
    next('/')
  }
  
  const ifAuthenticated = (to, from, next) => {
    if (store.state.auth) {
      next()
      return
    }
    next('/login')
  }


const common_routes = [
    {
        path : '/register',
        name : 'register',
        component : () => import('../components/auth/Register.vue'),
        beforeEnter: ifNotAuthenticated,
    },
    {
        path : '/login',
        name : 'login',
        component : () => import('../components/auth/Login.vue'),
        beforeEnter: ifNotAuthenticated,
    },
    {
      path : '/logout',
      name : 'logout',
      component : () => import('../components/auth/Logout.vue'),
      beforeEnter: ifAuthenticated,
   },
   {
        path : '/redirect',
        name : 'Redirect',
        component : () => import('../components/Redirect.vue'),
        beforeEnter: ifAuthenticated,
    },
];


export default common_routes;