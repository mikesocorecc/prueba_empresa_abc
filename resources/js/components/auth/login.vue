<template>
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="/images/mk.png" height="48" class='mb-4'>
                                <h3>Iniciar sesión</h3>
                                <p>Inicie sesión para ingresar la página.</p>
                            </div>
                            <form @submit.prevent="SubmitLogin()" action="/api/login" method="POST">
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Correo electrónico</label>
                                    <div class="position-relative">
                                        <input type="text" v-model="form.email" name="email" class="form-control"
                                            v-bind:class="{ 'is-invalid': errors.email }">
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                    <div v-if="errors.email" class="invalid-feedback">
                                        {{ errors.email[0] }}
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Contraseña</label>
                                        <!-- <a href="auth-forgot-password.html" class='float-end'>
                                            <small>Se te olvidó tu contraseña contraseña?</small>
                                        </a> -->
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" v-model="form.password" name="password"
                                            class="form-control" v-bind:class="{ 'is-invalid': errors.password }">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                    <div v-if="errors.password" class="invalid-feedback">
                                        {{ errors.password[0] }}
                                    </div>
                                </div>

                                <div class='form-check clearfix my-4'>
                                    <div class="checkbox float-start">
                                        <input type="checkbox" id="checkbox1" class='form-check-input'>
                                        <label for="checkbox1">Recuérdame</label>
                                    </div>
                                    <div class="float-end">
                                        <router-link :to="{ name: 'register' }">No tengo una cuenta?</router-link>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary float-end">Iniciar Sesion</button>
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
                    email: '', // Variables en blanco ordinarias
                    password: '',
                },
                errors: [],
            }
        },
        methods: {
            SubmitLogin() {
                axios.post('/api/login', this.form)
                .then((response) => {
                    // console.log(JSON.stringify(response.data.response.user));
                    // localStorage.setItem('user', JSON.stringify(response.data.response.user))
                    localStorage.setItem('user', JSON.stringify(response.data.response.user))
                    localStorage.setItem('token', response.data.response.token);
                    // this.$router.push('/usuarios');
                    this.$router.push("/inicio")
                    // console.log();
                }).catch((erorr) => {
                    console.log(erorr);
                    // Esto hace un error
                    this.errors = erorr.response.data.errors; 
                });
            }
        },
    }

</script>
<style>
    .invalid-feedback {
        display: block;
    }

</style>
