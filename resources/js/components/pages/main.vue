<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
                <admin-navbar></admin-navbar>
                <admin-sidebar></admin-sidebar>

            <div class="main-content">
                <section class="section">
                <div class="section-header">
                    <h1> Home</h1>
                </div> 
                </section>
                <section class="section" v-if="route == 'user'">
                    <!--  Nombre TOMAR DE LOCALSTORAGE -->
                    ini dashboard | {{ user.name }}
                </section>
                <section class="section" v-else>
                    <router-view></router-view>
                </section>
            </div>
        </div>  
    </div>
</template>

<script>
export default {
    data() {
        // console.log(JSON.parse(localStorage.user));
      
        return {
            data : 'Main',
            user : JSON.parse(localStorage.user), // mengubah string menjadi json
            route : this.$route.name
        }
    },
}
</script>
