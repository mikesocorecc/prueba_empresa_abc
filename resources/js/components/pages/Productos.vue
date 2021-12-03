<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <admin-navbar></admin-navbar>
            <admin-sidebar></admin-sidebar> 
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Administracion de productos</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item text-primary">Inicio</div> 
                            <div class="breadcrumb-item ">Productos</div>
                        </div>
                    </div>
                </section>
                <div class="section-body"> 
                       {{btnEditar}}
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
                                                        <th style="min-width: 150px">PRODUCTO</th>
                                                        <th style="min-width: 100px">SKU</th>
                                                        <th style="min-width: 100px">PRESENTACION</th>
                                                        <th style="min-width: 100px">VOLUMEN</th>
                                                        <th style="min-width: 100px">UNIDADES</th>
                                                        <th style="min-width: 100px">ACCIONES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="producto in productos" :key="producto.id" >
                                                <td>{{ producto.id }}</td>
                                                <td>{{ producto.producto }}</td>
                                                <td>{{ producto.sku }}</td>
                                                <td>{{ producto.presentacion }}</td>
                                                <td>{{ producto.volumen }}</td>
                                                <td>{{ producto.unidades }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <button  @click="editarRegistro(producto.id)"  type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                                        <button @click="borrarRegistro(producto.id )"  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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

         <b-modal id="modal-prevent-closing"  size="lg" ref="modal" title="Nuevo registro"   @hidden="resetModal" @ok="handleOk" >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-row>
                     <b-col cols="6" >
                        <b-form-group label="Producto" label-for="prod"   >
                            <b-form-input id="prod" v-model="producto.producto"  required  type="text"></b-form-input>                            
                        </b-form-group>
                     </b-col>
                     <b-col cols="6" >
                        <b-form-group label="SKU" label-for="sku" >
                            <b-form-input id="sku" v-model="producto.sku" required autocomplete="off" type="text" ></b-form-input>
                        </b-form-group>
                     </b-col> 
                    <b-col cols="6" >
                    <b-form-group label="Presentacion" label-for="pres" >
                        <b-form-input id="pres" v-model="producto.presentacion" required autocomplete="off"  type="text" ></b-form-input>
                    </b-form-group>
                    </b-col>
                    <b-col cols="6" >
                    <b-form-group label="Volumen" label-for="vol" >
                        <b-form-input id="vol" v-model="producto.volumen" required autocomplete="off"  type="text" ></b-form-input>
                    </b-form-group>
                    </b-col>
                    <b-col cols="6" >
                    <b-form-group label="Unidades" label-for="unit">
                        <b-form-input id="unit" v-model="producto.unidades" required autocomplete="off"  type="number" ></b-form-input>
                    </b-form-group>
                    </b-col>
            </b-row>
            </form>
        </b-modal>

    </div>
</template>
<script>
    export default {
        name: "productos",
        data() {
            return {
                productos: [], 
                 producto: {
                    producto: "",
                    sku: "",
                    presentacion: "",
                    volumen: "",
                    unidades: ""
                },
            //
            // 
            idProducto:"",
            titulo:"Insertar nuevo registro",
            btnEditar:false,
            verRegistro: false
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
                  this.producto = {
                    producto: "",
                    sku: "",
                    presentacion: "",
                    volumen: "",
                    unidades: ""
                   }
                    this.btnEditar = false
            },
            handleOk(evt) {
                // Evitar que se cierre modal
                evt.preventDefault()
                // Disparador Envío
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
                await this.axios.get("/api/producto")
                .then((res) => {
                    this.productos = res.data;
                    this.tabla()
                }).catch((e) => {
                    this.productos = [];
                });
            },
            // CREAR
            async crear(){
                 this.datosForm = {...this.producto, ...this.datosForm}
                    await this.axios .post("/api/producto", this.datosForm)
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
                await this.axios.get(`/api/producto/${this.idRegistro}`)
                .then(res => {
                    const {producto, sku,presentacion,volumen, unidades} = res.data
                    this.producto.producto = producto,
                    this.producto.sku = sku,
                    this.producto.presentacion = presentacion,
                    this.producto.volumen = volumen,
                    this.producto.unidades = unidades
                    // console.log(this.producto);
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
                await this.axios.put(`/api/producto/${this.idRegistro}`, this.producto)
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
                        axiosInstancia.delete(`/api/producto/${id}`)
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
        },
    computed: {
    // ONU Getter computado
            reversedMessage: function () {
            // `this` apunta a la instancia vm
            return this.message.split('').reverse().join('')
            }
     }
    };
</script>
