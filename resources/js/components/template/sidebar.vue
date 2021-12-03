
<template>
      <div class="main-sidebar">
                <!-- <b-sidebar body-class="" id="sidebar-1" title="Sidebar" shadow> -->
                <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                        <router-link to="/" class="h5 text-info font-weight-bold" >CODIGOS MK</router-link >              
                </div> 
                <div class="sidebar-brand sidebar-brand-sm">
                        <router-link to="/" class="text-info" > MK</router-link >
                </div> 
                <ul class="sidebar-menu">
                        <li class="menu-header">PROCESOS</li>
                <!-- <li class="active"><a class="nav-link" href="blank.html"><i class="fas fa-users"></i><span>Blank Page</span></a></li> -->
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/usuarios" class='sidebar-link' ><i class="fas fa-users"></i><span>USUARIOS</span></router-link >
                        </li > 
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/productos" class='sidebar-link' ><i class="fas fa-boxes"></i><span>PRODUCTOS</span></router-link >
                        </li >
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/proveedores" class='sidebar-link' ><i class="fas fa-people-carry"></i><span>PROVEEDORES</span></router-link >
                        </li >
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/precios" class='sidebar-link' ><i class="fas fa-money-bill-alt"></i><span>PRECIOS</span></router-link >
                        </li >
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/compras" class='sidebar-link' ><i class="fas fa-shopping-bag"></i><span>COMPRAS</span></router-link >
                        </li >
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/contenedores" class='sidebar-link' ><i class="fas fa-truck-moving"></i><span>CONTENEDORES</span></router-link >
                        </li >
                        <li class="sidebar-item"  >
                                <router-link exact-active-class="active" to="/envios" class='sidebar-link' ><i class="fas fa-dolly-flatbed"></i><span>ENVIOS</span></router-link >
                        </li >
                </ul> 
                </aside>
                <!-- </b-sidebar> -->
      </div>
</template>

<script>
export default {
    data() {
        return {

        }
    },
}
</script>
