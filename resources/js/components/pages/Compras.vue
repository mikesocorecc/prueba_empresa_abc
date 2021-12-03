<template>
    <div>
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <admin-navbar></admin-navbar>
            <admin-sidebar></admin-sidebar>
            <div class="main-content">
                <!-- {{compras}} -->
                <section class="section">
                    <div class="section-header">
                        <h1>Administracion de compras</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item text-primary">Inicio</div>
                            <div class="breadcrumb-item ">compras</div>
                        </div>
                    </div>
                </section>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-center align-items-end">
                                    <b-button v-b-modal.modal-prevent-closing
                                        class="btn btn-primary btn-xl btn-round show "><i
                                            class="fas fa-plus-circle"></i> <span>Nuevo</span></b-button>
                                </div>
                                <div class="card-body ">
                                    <div class="table-responsive">
                                        <table id="tabla" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">FECHA COMPRA</th>
                                                    <th class="text-center">TOTAL COMPRA</th>
                                                    <th class="text-center">USUARIO REGISTRO</th>
                                                    <th class="text-center">ACCION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="compra in compras" :key="compra.id ">
                                                    <td class="text-center">{{ compra.id }}</td>
                                                    <td class="text-center">{{ compra.fechacompra }}</td>
                                                    <td class="text-center">{{ compra.totalcompra }}</td>
                                                    <td class="text-center">{{ compra.usuario.name }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group mb-3" role="group"
                                                            aria-label="Basic example">
                                                                <!-- <b-button v-b-modal.modal-ver-compra variant="info"><i class="fas fa-eye"></i></b-button>                                                             -->
                                                            <button @click="verInformacion(compra.id)" type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                                            <button @click="borrarRegistro(compra.id )" type="button" class="btn btn-danger"><i class="fas fa-ban"></i></button>
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
        <!-- MODAL -->
        <b-modal id="modal-prevent-closing" header-class="text-center" ok-title="Registrar Compra" size="xl" ref="modal"
            title="Nueva compra" @show="resetModal" @hidden="resetModal" @ok="handleOk">
                <b-row>
                    <b-col cols="12">
                            <div class="invoice-print">
                            <b-row>
                                <b-col cols="3" >
                                    <label for="pr">Proveedor</label>
                                    <select id="pr" v-model="prov" @change="obtenerProductos" class="form-control"  >
                                        <option v-for="prv in proveedores"  v-bind:value="{ id: prv.id, text: prv.proveedor }" :key="prv.id" >{{prv.proveedor}}</option>
                                    </select>
                                </b-col>
                                <b-col cols="3" >
                                    <label for="pod">Producto</label>
                                    <select id="pod" v-model="prod" @change="obtenerPrecios" class="form-control"  >
                                        <option v-for="produc in productos"  v-bind:value="{ id: produc.productoid, text: produc.producto.producto }" :key="produc.productoid" >{{produc.producto.producto}}</option>
                                    </select>
                                </b-col>
                                <b-col cols="2" >
                                    <b-form-group label="Precio producto" label-for="sku" >
                                        <b-form-input id="sku" v-model="prec" required autocomplete="off" type="text" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="2" >
                                    <b-form-group label="Cantidad" label-for="sku" >
                                        <b-form-input id="cantidad" v-model="cant" required autocomplete="off" type="text"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="2" >
                                        <b-button @click="agregarArticulo" variant="success" class="mt-4 ml-4"><i class="fas fa-plus-circle"></i> Agregar</b-button>
                                </b-col>
                            </b-row>
                            <form ref="form" @submit.stop.prevent="handleSubmit">
                                <b-row>
                                    <b-col cols="12">
                                        <b-table-simple hover small caption-top responsive>
                                            <colgroup><col><col></colgroup>
                                            <colgroup><col><col><col></colgroup>
                                            <colgroup><col><col></colgroup>
                                            <b-thead head-variant="dark">
                                            <b-tr>
                                                <b-th>ACCION</b-th>
                                                <b-th>CANTIDAD</b-th>
                                                <b-th>PRODUCTO</b-th>
                                                <b-th>PRECIO</b-th>
                                                <b-th>PROVEEDOR</b-th>
                                                <b-th class="text-center">SUBTOTAL</b-th>
                                            </b-tr>
                                            </b-thead>
                                            <b-tbody>
                                                <b-tr v-for=" detalle  in detallecompra " :key="detalle.index">
                                                    <b-td>  <b-button  variant="danger" @click="quitarFila(detalle.index, detalle.subtotal)"><i class="fas fa-trash"></i></b-button></b-td>
                                                    <b-td>{{ detalle.cantidad}}</b-td>
                                                    <b-td>{{ detalle.productotxt  }}</b-td>
                                                    <b-td>{{ detalle.precio}}</b-td>
                                                    <b-td>{{ detalle.proveedortxt }}</b-td>
                                                    <b-td variant="success" class="text-right" >{{ detalle.subtotal}}</b-td>
                                                </b-tr>
                                            </b-tbody>
                                            <b-tfoot>
                                            <b-tr>
                                                <b-td colspan="6" variant="secondary" class="text-right">
                                                   Total : <b>{{totalFinal}}</b>
                                                </b-td>
                                            </b-tr>
                                            </b-tfoot>
                                        </b-table-simple>
                                    </b-col>
                                </b-row>
                            </form>
                            </div>
                </b-col>
                </b-row>
        </b-modal>
        <!-- MODAL -->
        <!-- MODAL VER COMPRA -->
          <b-modal id="modal-ver-compra" size="xl" title="Informacion  de la compra">
            <div class="invoice mb-0 pb-0">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>DETALLE DE LA COMPRA</h2>
                      <div class="invoice-number">Pedido #000{{correlativoCompra}}</div>
                    </div>
                    <hr> 
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">                  
                    <div class="table-responsive">

                      <table class="table table-striped table-hover table-md">
                        <thead>
                            <tr>
                                <th data-width="40">#</th>
                                <th>PRODUCTO</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">CANTIDAD</th>
                                <th class="text-right">SUB-TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in informacionCompra" :key="list.codigo">
                            <td>{{list.codigo}}</td>
                            <td>{{list.producto}}</td>
                            <td class="text-center">{{list.precio}}</td>
                            <td class="text-center">{{list.cantidad}}</td>
                            <td class="text-right">{{list.subtotal}}</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">

                      </div>
                      <div class="col-lg-4 text-right">
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">Q {{totalCompraView}}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
            </div>
        </b-modal>
    </div>
</template>
<script>
import Factura from './Factura.vue'

export default {
        name: "compras",
    components:{
        Factura
        },
        data() {
            return {
                compras: [],
                productos: [],
                proveedores: [],
                precios: [],
                idRegistro: "",
                compra: {
                    fechacompra: "",
                    totalcompra: "",
                    usuarioid: ""
                },
                totalCompraView:0,
                correlativoCompra:"",
                detallecompra:[],
                informacionCompra:[],
                nombreProducto:"",
                productosArr: [],
                nombreProveedor:"",
                nextId:0,
                 cant:"",
                 prod:"",
                 prec:"",
                 prov:"",
                 totalFinal: 0,
            };
        },
        mounted() {
            this.mostrarRegistros();
        },
        methods: {
           async verInformacion(idcompra){
                await this.axios.get(`/api/compra/${idcompra}`)
                .then(res => {
                    console.log(res.data);
                    this.informacionCompra = res.data;
                    this.totalCompraView = res.data[0].totalcompra
                    this.correlativoCompra = res.data[0].id
                }).catch(e => {
                    console.log(e);
                })
            this.$bvModal.show('modal-ver-compra')
            },
            // BOOTSTRAP
            obtenerProductos(e){
                this.productos = this.precios.filter( precio => precio.proveedorid === this.prov.id );
                this.prec =  "";
                this.cant =  "";
            },
            obtenerPrecios (){
                // alert();
               const productoActual  = this.precios.filter( precio => precio.productoid === this.prod.id  );
                // console.log(productoActual);
                this.prec =  productoActual[0].precio;
            },
            agregarArticulo(){
                // console.log('aqui 2');
                if(this.cant == "" || this.prec == "" || this.prod == "" || this.prov === ""){
                    Swal.fire('Error!', 'No puede dejar campos vacios', 'error');
                    return;
                }
                console.log(this.prov.text);
                this.detallecompra.push({
                    index : ++this.nextId,
                    cantidad : this.cant,
                    precio : this.prec,
                    productoid : this.prod.id,
                    productotxt : this.prod.text,
                    proveedorid : this.prov.id,
                    proveedortxt : this.prov.text,
                    subtotal : this.cant * this.prec
                })
                this.totalFinal += this.cant * this.prec
                this.cant = ''
                this.prec = ''
                this.prod = ''
                this.prov = ''
            },
            datoProducto(idprod){
                // console.log(idprod)
                return idprod;
                // this.productosArr.forEach(obj => {
                //     if(obj.id == idprod){
                        // console.log(obj.producto);
                //         // this.nombreProducto = obj.producto;
                //     }
                // });
                // this.nombreProducto = this.productosArr.find( p => p.id == idprod );
                // console.log(this.productosArr);
                // return this.nombreProducto ;

            },
            datosProveedor(idprov){
                // return idprov;
                // this.nombreProveedor = this.proveedores.find( pv => pv.id == idprov );
                //  return this.nombreProveedor.proveedor;
            },
            checkFormValidity() {
                const validacion = this.$refs.form.checkValidity()
                return validacion
            },
            resetModal() {
                this.compra = []
                this.detallecompra = []
            },
            handleOk(evt) {
                // Evitar que se cierre modal
                evt.preventDefault()
                // Disparador Envío
                this.handleSubmit()
            },
            async handleSubmit() {
                // Validar que el detalle no este vacio
                if(this.detallecompra.length === 0){
                      Swal.fire('Alerta!','No es posible realizar la compra sin articulos','error');
                    return;
                }
                const nuevosDatos = { "detalle":this.detallecompra, "total":this.totalFinal }
                await this.axios.post("/api/compra", nuevosDatos)
                    .then((res) => {
                        Swal.fire('Exito!', ' Registro agregado correctamente!', 'success');
                        this.destruirTabla();
                        this.mostrarRegistros();
                    })
                    .catch((e) => {
                        Swal.fire('Error!', 'Ocurrio un error en el servidor', 'error');
                        // console.log(e);
                    });
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
            },
            // FIN BOOTSTRAP
            destruirTabla() {
                $("#tabla").DataTable().destroy();
            },
            // TABLA
            tabla() {
                this.$nextTick(() => {
                    $('#tabla').DataTable({ language: { "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json" } });
                })
            },
            // LISTAR
            async mostrarRegistros() {
                await this.axios.get("/api/compra")
                    .then((res) => {
                        this.compras = res.data.compras;
                        this.precios = res.data.precios;
                        this.proveedores = res.data.proveedores;
                        this.productosArr = res.data.productos;
                        this.tabla()
                    }).catch((e) => {
                        this.compras = [];
                        this.productosArr = [];
                        this.proveedores = [];
                    });
            },
            // CREAR
            async crear() {
                await this.axios.post("/api/compra", this.compra)
                    .then((res) => {
                        Swal.fire('Exito!', ' Registro agregado correctamente!', 'success');
                        this.destruirTabla();
                        this.mostrarRegistros();
                    })
                    .catch((e) => {
                        Swal.fire('Error!', 'Ocurrio un error en el servidor', 'error');
                        console.log(e);
                    });
            },
            // OBTENER UN REGISTRO
            async obtenerRegistro() {
                await this.axios.get(`/api/compra/${this.idRegistro}`)
                .then(res => {
                    // console.log(res.data);
                    const { fechacompra, totalcompra, usuarioid } = res.data
                    this.compra.fechacompra = fechacompra,
                        this.compra.totalcompra = totalcompra,
                        this.compra.usuarioid = usuarioid
                }).catch(e => {

                    console.log(e);
                })
            },
            // MODAL EDITAR
            editarRegistro(id) {
                this.titulo = "Actualizar registro",
                    this.btnCrear = false,
                    this.btnEditar = true
                this.idRegistro = id
                this.obtenerRegistro();
            },
            // ACTUALIZAR
            async actualizar() {
                await this.axios.put(`/api/compra/${this.idRegistro}`, this.envio)
                    .then((res) => {
                        Swal.fire('Exito!', ' Registro agregado correctamente!', 'success');
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
                            axiosInstancia.delete(`/api/compra/${id}`)
                                .then((res) => {
                                    // console.log(res);
                                    instancia.destruirTabla();
                                    Swal.fire('Exito!', 'Registro eliminado con correctamente!', 'success');
                                    instancia.mostrarRegistros();
                                }).catch((e) => {
                                    Swal.fire('Error!', 'Ocurrio un error en el servidor', 'error');
                                    console.log(e);
                                });
                        } else {
                            Swal.fire('Informacion!', 'No se realizo ninguna accion', 'info');
                        }
                    });
            },
            quitarFila(idfila, subtotal){
                this.detallecompra = this.detallecompra.filter( det => det.index !== idfila );
                // alert(idfila)
                // console.log();
                this.totalFinal -= subtotal
                // this.compra.totalcompra -= subtotal
            }
        }
    };

</script>