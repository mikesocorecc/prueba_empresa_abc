<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <admin-navbar></admin-navbar>
            <admin-sidebar></admin-sidebar>
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Administracion de envios</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item text-primary">Inicio</div>
                            <div class="breadcrumb-item ">Envios</div>
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
                                            <table  id="tabla" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width: 10px">ID</th>
                                                        <th style="min-width: 150px">FECHA ENTREGA</th>
                                                        <th style="min-width: 100px">PAIS DESTINO</th>
                                                        <th style="min-width: 100px">NUMERO CONTENEDOR</th>
                                                        <th style="min-width: 100px">ACCIONES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="envio in envios" :key="envio.id" >
                                                <td>{{ envio.id }}</td>
                                                <td>{{ envio.fechaEntrega }}</td>
                                                <td>{{ envio.paisDestino }}</td>
                                                <td>{{ envio.contenedor.identificacion }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <button  @click="editarRegistro(envio.id)"  type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                                        <button @click="borrarRegistro(envio.id )"  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
                <!-- <section class="section" v-if="route == 'user'"> </section> -->
            </div>
        </div>
         <b-modal id="modal-prevent-closing"  size="lg" ref="modal" title="Nuevo registro"  @hidden="resetModal" @ok="handleOk" >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-row>
                     <b-col cols="6" >
                        <b-form-group label="Fecha entrega" label-for="fentrega"   >
                          <b-form-datepicker id="f_arri" v-model="envio.fechaEntrega" class="mb-2"></b-form-datepicker>
                        </b-form-group>
                     </b-col>
                     <b-col cols="6" >
                        <b-form-group label="Pais destino" label-for="sku" >
                            <b-form-input id="sku" v-model="envio.paisDestino" required autocomplete="off" type="text" ></b-form-input>
                        </b-form-group>
                     </b-col>
                    <b-col cols="6" >
                    <b-form-group label="Contenedores" label-for="con">
                          <b-form-select v-model="envio.contenedorid" :options="contenedores"  value-field="id" text-field="identificacion"></b-form-select>
                    </b-form-group>
                    </b-col>
            </b-row>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "envios",
        data() {
            return {
                envios: [],
                contenedores: [],
                 envio: {
                    fechaEntrega: "",
                    paisDestino: "",
                    contenedorid: ""
                },
            //
            //
            idenvio:"",
            idRegistro:"",
            btnEditar:false,
            };
        },
        mounted() {
            this.mostrarRegistros();
        },
        methods: {
            // BOOTSTRAP
            checkFormValidity() {
                const validacion = this.$refs.form.checkValidity()
                console.log(validacion);
                return validacion
            },
            resetModal() {
                this.envio =  {
                    fechaEntrega: "",
                    paisDestino: "",
                    contenedorid: ""
                }
                this.btnEditar = false
            },
            handleOk(evt) {
                // Evitar que se cierre modal
                evt.preventDefault()
                // Disparador Envío
                this.handleSubmit()
            },
           async handleSubmit() {
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
                await this.axios.get("/api/envio")
                .then((res) => {
                    this.envios = res.data.envios;
                    this.contenedores = res.data.contenedores;
                    this.tabla()
                }).catch((e) => {
                    this.envios = [];
                });
            },
            // CREAR
            async crear(){
                    this.datosForm = {...this.envio, ...this.datosForm}
                    await this.axios .post("/api/envio", this.datosForm)
                    .then((res) => {
                        Swal.fire('Exito!',' Registro agregado correctamente!','success');
                        this.destruirTabla();
                        this.mostrarRegistros();
                    })
                    .catch((e) => {
                        Swal.fire('Error!','Ocurrio un error en el servidor','error');
                        // console.log(e);
                    }); 
            },
            // OBTENER UN REGISTRO
            async obtenerRegistro(){
                await this.axios.get(`/api/envio/${this.idRegistro}`)
                .then(res => { 
                    const {fechaEntrega, paisDestino,contenedorid} = res.data
                    this.envio.fechaEntrega = fechaEntrega,
                    this.envio.paisDestino = paisDestino,
                    this.envio.contenedorid = contenedorid
                    // console.log(  this.envio);
                    
                }).catch(e => {
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
                await this.axios.put(`/api/envio/${this.idRegistro}`, this.envio)
                .then((res) => {
                    Swal.fire('Exito!',' Registro agregado correctamente!','success');
                    this.destruirTabla();
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
                        axiosInstancia.delete(`/api/envio/${id}`)
                        .then((res) => {
                             console.log(res);
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
