<template>
    <nav class="navbar navbar-expand-lg main-navbar">
        <span class="form-inline mr-auto">  
        <ul class="navbar-nav mr-3">
                <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
        </span>
        <ul class="navbar-nav navbar-right"> 
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hola, {{ user.name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- <div class="dropdown-title">Logged in 5 min ago</div> -->
              <!-- <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Perfil
              </a>  -->
              <!-- <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a> -->
              <!-- <div class="dropdown-divider"></div> -->
              <a type="button" @click.prevent="logout()" class="dropdown-item has-icon text-danger"><i class="fas fa-sign-out-alt"></i> Cerrar Sesion</a>               
            </div>
          </li>
        </ul>
    </nav>
</template>
<script>
    export default {
        data() {
            return {
                //La variable está vacía para que se pueda llenar.
                user: '',
                token: ''
            }
        },
        mounted() {
            //Determine el usuario y el token que ha iniciado sesión desde LocalStorage
            this.user = JSON.parse(localStorage.getItem('user')); // Este cambia de la cadena a JSON nuevamente (cuando se cambia en la cadena está iniciando sesión .VUR)
            this.token = localStorage.getItem('token'); //Este es un token EMG UDH S2TRING
        },
        methods: {
            logout() {
                axios.post('/logout', this.user).then((response) => {
                    localStorage.removeItem('user');
                    localStorage.removeItem('token');
                    this.$router.push('/login');
                }).catch((erorr) => {
                    console.log('erorr');
                });
            }
        },
    }

</script>
