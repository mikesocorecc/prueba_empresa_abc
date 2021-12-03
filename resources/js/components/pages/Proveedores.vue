<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <admin-navbar></admin-navbar>
            <admin-sidebar></admin-sidebar> 
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Administracion de proveedores</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item text-primary">Inicio</div>
                            <div class="breadcrumb-item ">Proveedores</div>
                        </div>
                    </div>
                </section>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-center align-items-end">
                                       <b-button  v-b-modal.modal-prevent-closing  class="btn btn-primary btn-xl btn-round show " ><i class="fas fa-plus-circle"></i> <span>Nuevo</span></b-button>                            
                                </div>
                                <div class="card-body">
                                    {{btnEditar}}
                                    <div class="table-responsive">
                                         <table  id="tabla" class="table table-striped table-bordered">
                                          <thead>
                                                    <tr>
                                                        <th style="min-width: 10px;">ID</th>
                                                        <th style="min-width: 100px;">PROVEEDOR</th>
                                                        <th style="min-width: 100px;">DIRECCION</th>
                                                        <th style="min-width: 100px;">TELEFONO</th>
                                                        <th style="min-width: 100px;">TELEFONO CONTACTO</th>
                                                        <th style="min-width: 100px;">ACCIONES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="proveedor in proveedores" :key="proveedor.id">
                                                        <td>{{ proveedor.id }}</td>
                                                        <td>{{ proveedor.proveedor }}</td>
                                                        <td>{{ proveedor.direccion }}</td>
                                                        <td>{{ proveedor.telefono }}</td>
                                                        <td>{{ proveedor.telefonoContacto }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                                <button  @click="editarRegistro(proveedor.id)"  type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                                                <button @click="borrarRegistro(proveedor.id )"  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
                        <b-form-group label="Proveedor" label-for="prov"   >
                            <b-form-input id="prov" v-model="proveedor.proveedor"  required  type="text"></b-form-input>
                        </b-form-group>
                     </b-col>
                     <b-col cols="6" >
                        <b-form-group label="Direccion" label-for="direccion" >
                            <b-form-input id="direccion" v-model="proveedor.direccion" required autocomplete="off" type="text" ></b-form-input>
                        </b-form-group>
                     </b-col> 
                    <b-col cols="6" >
                    <b-form-group label="Telefono" label-for="tel" >
                        <b-form-input id="tel" v-model="proveedor.telefono" required autocomplete="off"  type="text" ></b-form-input>
                    </b-form-group>
                    </b-col>
                    <b-col cols="6" >
                    <b-form-group label="Telefono contacto" label-for="telc" >
                        <b-form-input id="telc" v-model="proveedor.telefonoContacto" required autocomplete="off"  type="text" ></b-form-input>
                    </b-form-group>
                    </b-col>
            </b-row>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "proveedores",
        data() {
            return {
                proveedores: [],
              proveedor: {
                    proveedor: "",
                    direccion: "",
                    telefono: "",
                    telefonoContacto: "" 
                },
                idRegistro:"", 
                btnEditar:false
            };
        },
        mounted() { 
            this.mostrarRegistros();
        },
        methods: {
             checkFormValidity() {
                const validacion = this.$refs.form.checkValidity()
                console.log(validacion);
                return validacion
            },
            resetModal() {
                  this.proveedor = {
                    proveedor: "",
                    direccion: "",
                    telefono: "",
                    telefonoContacto: "" 
                },
                this.btnEditar = false
            },
            handleOk(evt) { 
                evt.preventDefault() 
                this.handleSubmit()
            },
            handleSubmit() {
                    // Salir cuando el formulario no es válidoes válido
                    if (!this.checkFormValidity()) { 
                          return
                    }  
                    if(this.btnEditar){
                        // alert("vamos a editar")
                         this.actualizar()
                    } else{
                        // alert("vamos a crear")
                        this.crear()
                    }
                     // Ocultar el modal manualmente 
                    this.$nextTick(() => {
                         this.$bvModal.hide('modal-prevent-closing')
                    })
            },
            // FIN BOOTSTRAP
            destruirTabla(){
               $("#tabla").DataTable().destroy();
            },
            // TABLA
            tabla() {
                this.$nextTick(() => {
                    $('#tabla').DataTable({ language:{ "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"}}); 
                })
            },
            // LISTAR
            async mostrarRegistros() {
                await this.axios
                .get("/api/proveedor")
                .then((res) => {
                    this.proveedores = res.data;
                    this.tabla()
                }).catch((e) => {
                    this.proveedores = [];
                });
            },
            // CREAR
            async crear(){
                this.datosForm = {...this.proveedor, ...this.datosForm}
                    await this.axios .post("/api/proveedor", this.datosForm)
                    .then((res) => { 
                        Swal.fire('Exito!',' Registro agregado correctamente!','success');
                        this.destruirTabla();
                        this.mostrarRegistros();
                    })
                    .catch((e) => {
                        Swal.fire('Error!','Ocurrio un error en el servidor','error'); 
                    }); 
            },
            // OBTENER UN REGISTRO
            async obtenerProveedor(){
                await this.axios.get(`/api/proveedor/${this.idRegistro}`)
                .then(res => {
                console.log(res.data);
                    const {proveedor, direccion,telefono,telefonoContacto} = res.data
                    this.proveedor.proveedor = proveedor,
                    this.proveedor.direccion = direccion,
                    this.proveedor.telefono = telefono,
                    this.proveedor.telefonoContacto = telefonoContacto
                }).catch(e => {
                    console.log(e);
                })
            },
            // MODAL EDITAR
          editarRegistro(id) { 
              this.idRegistro = id
              this.obtenerProveedor();  
              this.btnEditar = true
              this.$bvModal.show("modal-prevent-closing")
            },
            // ACTUALIZAR
            async actualizar() {
                await this.axios.put(`/api/proveedor/${this.idRegistro}`, this.proveedor)
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
                        axiosInstancia.delete(`/api/proveedor/${id}`)
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
