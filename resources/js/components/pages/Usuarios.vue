<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <admin-navbar></admin-navbar>
            <admin-sidebar></admin-sidebar>
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Administracion de usuarios</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item text-primary">Inicio</div>
                            <div class="breadcrumb-item ">Usuarios</div>
                        </div>
                    </div>
                </section>
                <div class="section-body">
                    <!-- {{usuario}} -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                               <div class="card-header d-flex justify-content-center align-items-end">
                                       <b-button  v-b-modal.modal-prevent-closing  class="btn btn-primary btn-xl btn-round show " ><i class="fas fa-plus-circle"></i> <span>Nuevo</span></b-button>
                                </div>
                                <div class="card-body ">
                                    <div class="table-responsive">
                                        <table id="tabla" class="table table-striped table-bordered">
                                               <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">NOMBRE</th>
                                                        <th class="text-center">CORREO ELECTRONICO</th>
                                                        <th class="text-center">ACCION</th>
                                                    </tr>
                                               </thead>
                                                <tbody>
                                                        <tr v-for="usuario in usuarios" :key="usuario.id " >
                                                            <td class="text-center">{{ usuario.id  }}</td>
                                                            <td class="text-center">{{ usuario.name  }}</td>
                                                            <td class="text-center">{{ usuario.email  }}</td>
                                                            <td class="text-center">
                                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                                    <button  @click="editarRegistro(usuario.id)"  type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                                                    <button @click="borrarRegistro(usuario.id )"  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <section class="section" v-if="route == 'user'"></section> -->
            </div>
        </div>
   <b-modal id="modal-prevent-closing"  size="lg" ref="modal" title="Nuevo registro"   @hidden="resetModal" @ok="handleOk" >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-row>
                        <b-col cols="6" >
                        <b-form-group label="Nombre Completo" label-for="nom"   >
                            <b-form-input id="nom" v-model="usuario.name"  required  type="text"></b-form-input>
                        </b-form-group>
                        </b-col>
                        <b-col cols="6" >
                        <b-form-group label="Correo electronico" label-for="correo">
                            <b-form-input id="correo" v-model="usuario.email"  required  type="email"></b-form-input>
                        </b-form-group>
                        </b-col>
                        <b-col cols="6" >
                        <b-form-group label="Contraseña" label-for="pass">
                            <b-form-input id="pass" v-model="usuario.password"   type="password"></b-form-input>
                        </b-form-group>
                        </b-col>
            </b-row>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "usuarios",
        data() {
            return {
                usuarios: [],
                usuario: {
                    name: "",
                    email: "",
                    password: ""
                },
                idRegistro:"",
                btnEditar:false
            };
        },
        mounted() {
             this.mostrarRegistros();
        },
        methods: {
            destruirTabla(){
               $("#tabla").DataTable().destroy();
            },
            // TABLA
           tabla() {
                this.$nextTick(() => {
                    $('#tabla').DataTable({ language:{ "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"}});
                })
            },
              checkFormValidity() {
                const validacion = this.$refs.form.checkValidity()
                return validacion
                // console.log(validacion);
            },
            resetModal() {
                this.usuario={
                    name: "",
                    email: "",
                    password: ""
                }
                this.btnEditar=false
            },
            handleOk(evt) {
                evt.preventDefault()
                this.handleSubmit()
            },
             handleSubmit() {
                    if (!this.checkFormValidity()) {
                          return
                    }
                  if(this.btnEditar){ 
                         this.actualizar()
                    } else{ 
                        this.crear()
                    }
                    this.$nextTick(() => {
                         this.$bvModal.hide('modal-prevent-closing')
                    })
            },
            // LISTAR
            async mostrarRegistros() {
                await this.axios
                    .get("/api/usuario")
                    .then((res) => {
                        this.usuarios = res.data;
                        this.tabla()
                    })
                    .catch((e) => {
                        this.usuarios = [];
                    });
            },
            // CREAR
            async crear(){
                await this.axios
                .post("/api/usuario", this.usuario)
                .then((res) => {
                     Swal.fire('Exito!',' Registro agregado correctamente!','success');
                    this.destruirTabla();
                    this.mostrarRegistros();
                })
                .catch((e) => {
                      Swal.fire('Error!','Ocurrio un error en el servidor','error');
                    console.log(e);
                });
            },
            // OBTENER UN REGISTRO
            async obtenerRegistro(){
                await this.axios.get(`/api/usuario/${this.idRegistro}`)
                .then(res => {
                console.log(res.data);
                    const {name, email,password} = res.data
                    this.usuario.name = name
                    this.usuario.email = email
                    this.usuario.password = password
                    // console.log(this.u|);
                }).catch(e => {
                    Swal.fire('Error!','Ocurrio un error en el servidor','error');
                    console.log(e);
                })
            },
            // MODAL EDITAR
            editarRegistro(id) {
                this.btnEditar = true
                this.idRegistro = id
                this.obtenerRegistro();
                this.$bvModal.show("modal-prevent-closing")
            },
            // ACTUALIZAR
            async actualizar() {
                await this.axios.put(`/api/usuario/${this.idRegistro}`, this.usuario)
                .then((res) => {
                    this.destruirTabla();
                    Swal.fire('Exito!',' Registro agregado correctamente!','success');
                    this.mostrarRegistros();
                })
                .catch((e) => {
                    Swal.fire('Error!','Ocurrio un error en el servidor','error');
                     console.log(e);
                });
            },
            // ELIMINAR UN REGISTRO
            borrarRegistro(id) {
                let axiosInstancia = this.axios;
                let instancia = this;
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: " Un registro eliminado no se puede recuperar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'sí, Eliminarlo'
                })
                .then(function (result) {
                    if (result.isConfirmed) {
                        axiosInstancia.delete(`/api/usuario/${id}`)
                        .then((res) => {
                            //  console.log(res);
                            instancia.destruirTabla();
                            Swal.fire('Exito!','Registro eliminado con correctamente!','success');
                            instancia.mostrarRegistros();
                        }).catch((e) => {
                            Swal.fire('Error!','Ocurrio un error en el servidor','error');
                            console.log(e);
                        });
                    } else {
                      Swal.fire('Informacion!','No se realizo ninguna accion','info');
                    }
                });
            }
        }
    };
</script>
