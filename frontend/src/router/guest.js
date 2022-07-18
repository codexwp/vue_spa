const guest_routes = [
    {
        path : '/',
        name : 'home',
        component : () => import('../components/Home.vue'),
    },
    {
        path : '/contact',
        name : 'contact',
        component : () => import('../components/Contact.vue'),
    },
];


export default guest_routes;