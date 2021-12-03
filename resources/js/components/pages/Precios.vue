<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <admin-navbar></admin-navbar>
            <admin-sidebar></admin-sidebar>
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Administracion de precios</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item text-primary">Inicio</div>
                            <div class="breadcrumb-item ">Precios</div>
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
                                    <div class="table-responsive">
                                        <table id="tabla" class="table table-striped table-bordered">
                                               <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">PRECIO</th>
                                                        <th class="text-center">PRODUCTO</th>
                                                        <th class="text-center">PROVEEDOR</th>
                                                        <th class="text-center">ACCIONES</th>
                                                    </tr>
                                               </thead>
                                                <tbody> 
                                                    <tr v-for="precio in precios" :key="precio.id " > 
                                                        <td class="text-center">{{ precio.id  }}</td>
                                                        <td class="text-center">{{ precio.precio  }}</td>
                                                        <td class="text-center">{{ precio.producto.producto }}</td>
                                                        <td class="text-center">{{ precio.proveedor[0].proveedor  }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                                <button  @click="editarRegistro(precio.id)"  type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                                                <button @click="borrarRegistro(precio.id )"  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
                        <b-form-group label="Precio" label-for="preci"   >
                            <b-form-input id="preci" v-model="precio.precio"  required  type="number"></b-form-input>
                        </b-form-group>
                        </b-col>
                        <b-col cols="6" >
                        <b-form-group label="Producto" label-for="prod" >
                              <b-form-select v-model="precio.productoid" :options="productos"  value-field="id" text-field="producto"></b-form-select>                          
                        </b-form-group>
                        </b-col>
                        <b-col cols="6" >
                        <b-form-group label="Proveedor" label-for="prov" >
                              <b-form-select v-model="precio.proveedorid" :options="proveedores"  value-field="id" text-field="proveedor"></b-form-select>                          
                        </b-form-group>
                        </b-col>
            </b-row>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "precios",
        data() {
            return {
                precios: [],
                productos: [],
                proveedores: [],
                precio: {
                    precio: "",
                    productoid: "",
                    proveedorid: ""
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
             checkFormValidity() {
                const validacion = this.$refs.form.checkValidity()
                return validacion
                // console.log(validacion);
            },
            resetModal() {
                this.precio = {
                    precio: "",
                    productoid: "",
                    proveedorid: ""
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
                    // Ocultar el modal manualmente
                    this.$nextTick(() => {
                         this.$bvModal.hide('modal-prevent-closing')
                    })
            },
            // FIN BOOTSTRAP
            // TABLA
            tabla() {
                this.$nextTick(() => {
                    $('#tabla').DataTable({
                          language:{
                            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                        }
                    });
                    // $('#table-1').DataTable();
                })
            },
            // LISTAR
            async mostrarRegistros() {
                await this.axios
                    .get("/api/precio")
                    .then((res) => {
                        // console.log(res.data);
                        this.precios = res.data.precios;
                        this.productos = res.data.productos; 
                        this.proveedores = res.data.proveedores;
                        this.tabla();
                    })
                    .catch((e) => {
                        this.precios = [];
                        this.productos = [];
                        this.proveedores = [];
                    });
            },
            // CREAR
            async crear(){
                    // Empuje el nombre a los nombres enviados
                    this.datosForm = {...this.precio, ...this.datosForm}
                    await this.axios .post("/api/precio", this.datosForm)
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
                await this.axios.get(`/api/precio/${this.idRegistro}`)
                .then(res => {
                console.log(res.data);
                    const {precio, productoid,proveedorid} = res.data
                    this.precio.precio = precio,
                    this.precio.productoid = productoid,
                    this.precio.proveedorid = proveedorid
                }).catch(e => {
                    Swal.fire('Error!','Ocurrio un error en el servidor','error');
                    console.log(e);
                })
            },
            // MODAL EDITAR
            editarRegistro(id) { 
                this.idRegistro = id
                this.obtenerRegistro();
                this.btnEditar = true
                this.$bvModal.show("modal-prevent-closing")
            },
            // ACTUALIZAR
            async actualizar() {
                await this.axios.put(`/api/precio/${this.idRegistro}`, this.precio)
                .then((res) => {
                    // console.log(res.data);
                    this.destruirTabla()
                   Swal.fire('Exito!',' Registro agregado correctamente!','success');
                    this.mostrarRegistros();
                })
                .catch((e) => {
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
                        axiosInstancia.delete(`/api/precio/${id}`)
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
