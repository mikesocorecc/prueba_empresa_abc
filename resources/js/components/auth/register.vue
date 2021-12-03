<template>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="/images/favicon.svg" height="48" class='mb-4'>
                                <h3>Inscribirse</h3>
                                <p>Por favor llene el formulario para registrarse.</p>
                            </div>
                            <form @submit.prevent="registerSubmit()" action="/api/register" method="POST">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="username-column">Nombre</label>
                                            <input type="text" v-model="form.name" class="form-control"
                                                name="username-column" v-bind:class="{ 'is-invalid' : erorr.name, '': false }">                                                                      
                                            <div v-if="erorr.name" class="invalid-feedback">
                                                {{ erorr.name[0] }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Correo electronico</label>
                                            <input type="email" v-model="form.email" class="form-control"
                                                name="email-id-column" v-bind:class="{ 'is-invalid' : erorr.email }">
                                            <div v-if="erorr.email" class="invalid-feedback">
                                                {{ erorr.email[0] }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Contraseña</label>
                                            <input type="password" v-model="form.password" class="form-control"
                                                name="email-id-column" v-bind:class="{ 'is-invalid' : erorr.password }">
                                            <div v-if="erorr.password" class="invalid-feedback">
                                                {{ erorr.password[0] }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Confrimar Contraseña</label>
                                            <input type="password" v-model="form.confrim_password" class="form-control"
                                                name="email-id-column"
                                                v-bind:class="{ 'is-invalid' : erorr.confrim_password }">
                                            <div v-if="erorr.confrim_password" class="invalid-feedback">
                                                {{ erorr.confrim_password[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </diV>

                                <router-link :to="{ name: 'login' }">Tener una cuenta? Inicia Sesion</router-link>
                                <div class="clearfix mt-4">
                                    <button class="btn btn-primary float-end">Registrarse</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    confrim_password: ''
                },
                erorr: []
            }
        },
        methods: {
            registerSubmit() {
                // Envíe el formulario de objeto a la API del Registro a través del Método Post
                axios.post('/api/register', this.form).then((response) => {
                    this.$router.push('/login');
                }).catch((erorr) => {
                    console.log(erorr.response.data);
                    // erorr.response Datos para tomar de respuesta.
                    console.log(erorr.response.data.errors);
                    // Respuesta en el error
                    this.erorr = erorr.response.data.errors;
                });
            }
        },
    }

</script>
