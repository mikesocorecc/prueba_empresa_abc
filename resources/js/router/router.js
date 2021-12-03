import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

// router pages login
import auth_login from '../components/auth/login.vue';
import auth_register from '../components/auth/register.vue';
//Mis rutas
import Inicio from '../components/pages/Inicio.vue'
import Usuarios from '../components/pages/Usuarios.vue'
import Productos from '../components/pages/Productos.vue'
import Proveedores from '../components/pages/Proveedores.vue'
import Precios from '../components/pages/Precios.vue'
import Compras from '../components/pages/Compras.vue'
import Contenedores from '../components/pages/Contenedores.vue'
import Envios from '../components/pages/Envios.vue'

//Esta es la ruta
const routes = [
{
    name: 'inicio',
    path: '/',
    component: Inicio,
    // meta le dice que necesitas un inicio de sesión
    meta: { requiresAuth: true }
},
{
    name: 'listadoUsuarios',
    path: '/usuarios',
    component: Usuarios,
    meta: { requiresAuth: true }
},
{
    name: 'listadoProductos',
    path: '/productos',
    component: Productos,
    meta: { requiresAuth: true }
},
{
    name: 'listadoProveedores',
    path: '/proveedores',
    component: Proveedores,
    meta: { requiresAuth: true }
},
{
    name: 'listadoPrecios',
    path: '/precios',
    component: Precios,
    meta: { requiresAuth: true }
},
{
    name: 'listadoCompras',
    path: '/compras',
    component: Compras,
    meta: { requiresAuth: true }
},
{
    name: 'listadoContenedores',
    path: '/contenedores',
    component: Contenedores,
    meta: { requiresAuth: true }
},
{
    name: 'listadoEnvios',
    path: '/envios',
    component: Envios,
    meta: { requiresAuth: true }
},
{
    name: 'login',
    path: '/login',
    component: auth_login,
    meta: { requiresAuth: false }
},
{
    // pagina registro
    name: 'register',
    path: '/register',
    component: auth_register,
}
]

// configuracion
const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

router.beforeEach((to, from, next) => {
    // console.log(to.matched.some(i => i.meta.requiresAuth)+" = Falso"); // console.log(to.matched[0].meta);
    if (to.matched.some(index => index.meta.requiresAuth)) {
        let token = localStorage.token != null;
        if (!token) {
            next('/login')
        } else {
            next();
        }
    } else {
        let token = localStorage.token != null;
        if(token){
            next('/')
        }else{
            console.log('La pagina no requiere autenticacion, Continua . . .');
            next();
        }
    }

});

// Invertir o exportar el valor predeterminado de su ruta.
export default router
