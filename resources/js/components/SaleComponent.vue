<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row justify="center">
                    <v-container class="align-items-center">
                        <v-col
                        cols="12"
                        md="12"
                        sm="12">
                            <p style="text-align: center; font-size:30px; font-weight:700; margin-bottom: -5px;"><strong>Ventas</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="10" sm="12" md="10">
                        <v-data-table
                            :headers="headers"
                            :items="sales"
                            sort-by="calories"
                            class="elevation-3"
                            :search="search"
                            :loading="loading" loading-text="Estamos cargando tu información"
                            :items-per-page="6"
                            :footer-props="{
                                'items-per-page-options': [7, 10, 20]
                            }">
                            <template v-slot:item.created_at="{ item }">
                               {{item.created_at | formatDateTime | formatUpperCase}}
                            </template>
                            <template v-slot:item.fecha_salida="{ item }">
                               {{item.fecha_salida | formatDateTimeShort | formatUpperCase}}
                            </template>
                            <template v-slot:item.customer.nombre="{ item }">
                               <v-chip class="ma-2">
                                    <v-avatar left >
                                        <v-icon color="teal">mdi-account-circle</v-icon>
                                    </v-avatar>{{item.customer.nombre | formatUpperCase}}
                                </v-chip>
                            </template>
                            <template v-slot:item.monto="{item}">
                                <v-chip color="orange" dark>
                                    <v-avatar left color="green">
                                        <v-icon color="white">monetization_on</v-icon>
                                    </v-avatar>{{item.monto}}
                                </v-chip>

                            </template>
                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Ventas</v-toolbar-title>
                                <v-divider
                                class="mx-4"
                                inset
                                vertical
                                ></v-divider>
                                <v-text-field
                                    v-model="search"
                                    prepend-inner-icon="search"
                                    label="Buscar"
                                    hide-details
                                    filled
                                    rounded
                                    single-line
                                    dense
                                    color="#ff5200"
                                    clearable
                                ></v-text-field>
                                <v-divider
                                class="mx-4"
                                inset
                                vertical
                                ></v-divider>

                                <v-dialog v-model="dialog" scrollable fullscreen hide-overlay transition="dialog-bottom-transition" class="perfect-scrollbar-on">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>person_add</v-icon>Nueva Venta</v-btn>
                                </template>
                                <v-card style="height:100%; margin: 0; display: flex; flex-direction: column; background: #f7f9fa;">


                                <v-card-text style="padding-bottom:0px; height:100%; padding-left:0px; padding-right: 0px">
                                    <v-container style="padding:0px; max-width: 100%; height:100%;">
                                        <v-form v-model="valid" ref="form" style="height:100%; margin-bottom: 0px">
                                            <v-container style="max-width: 100%; height: 100%; padding-bottom: 0px; padding-top: 0px;">
                                                <v-row style="height:100%;">
                                                    <v-col
                                                    cols="12"
                                                    md="3"
                                                    sm="12"
                                                    class="elevation-9"
                                                    style="height:100%; padding: 0px;background: #fff;"
                                                    >
                                                    <v-container class="align-items-center" max-width='100%' style="background: linear-gradient(60deg, #fd2d21, #fc831a); max-width: 100%;">
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12">
                                                            <p style="text-align: center; color:#ffffff; margin-bottom: 5px;">
                                                                <i class="material-icons" style="font-size:85px;">shopping_cart</i>
                                                            </p>
                                                            <p style="text-align: center; color:#ffffff; font-size:20px; margin-bottom: -10px;"><v-icon color="#fff">mdi-calendar</v-icon>&nbsp;{{fecha | formatDateTimeShort | formatUpperCase}}</p>
                                                        </v-col>
                                                    </v-container>
                                                    <v-container style="padding:1.5rem;">
                                                    <v-row justify="center">

                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                        <v-autocomplete
                                                            v-model="select_deliverer"
                                                            v-on:change="getRoutesList"
                                                            :items="nombres"
                                                            hide-details
                                                            clearable
                                                            rounded
                                                            filled
                                                            dense
                                                            item-text="nombre"
                                                            item-value="id"
                                                            label="Repartidor"
                                                            prepend-icon="local_shipping"
                                                            persistent-hint
                                                            return-object
                                                            ></v-autocomplete>
                                                        </v-col>

                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                        <v-autocomplete

                                                            v-model="select_route"
                                                            v-on:change="getClientsNames"
                                                            :disabled="dis"
                                                            :items="routes"
                                                            hide-details
                                                            clearable
                                                            rounded
                                                            filled
                                                            dense
                                                            item-text="municipio"
                                                            item-value="route_id"
                                                            label="Rutas"
                                                            prepend-icon="mdi-map"
                                                            persistent-hint
                                                            return-object
                                                            ></v-autocomplete>
                                                        </v-col>
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                        <v-autocomplete
                                                            v-model="select_customer"

                                                            :items="clientes"
                                                            :disabled="dis"
                                                            hide-details
                                                            clearable
                                                            rounded
                                                            filled
                                                            dense
                                                            item-text="nombre"
                                                            item-value="id"
                                                            label="Cliente"
                                                            prepend-icon="assignment_ind"
                                                            persistent-hint
                                                            return-object
                                                            ></v-autocomplete>
                                                        </v-col>
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="6"
                                                        >
                                                        <v-textarea
                                                        v-model="editedItem.observacion"

                                                            clearable
                                                            rounded
                                                            filled

                                                            label="Descripcion"
                                                            type="text"
                                                            prepend-icon="mdi-comment-text"
                                                            hint="*Opcional"
                                                            persistent-hint
                                                        ></v-textarea>
                                                        </v-col>

                                                        </v-row>
                                                    </v-container>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="12"
                                                    >
                                                    <v-container style="margin: 1px solid #c3c3c3; border-radius: 10px;">
                                                    <v-row style="padding: 1rem; border-radius: 1rem; background: #fff;" class="elevation-2">

                                                        <v-col
                                                        cols="12"
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <v-autocomplete
                                                            v-model="select_product"
                                                            v-on:change="getStock"
                                                            :items="productos"
                                                            hide-details
                                                            rounded
                                                            filled
                                                            dense
                                                            item-text="nombre"
                                                            item-value="id"
                                                            label="Producto"
                                                            prepend-icon="local_mall"
                                                            persistent-hint
                                                            return-object
                                                            ></v-autocomplete>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                              md="6"
                                                               sm="6"
                                                        >
                                                        <strong>Stock disponible:</strong>

                                                        <v-text-field
                                                            v-text="stock"
                                                            clearable
                                                            :disabled= true
                                                            style="display: inline-block;"
                                                        ></v-text-field>

                                                        <br><strong>Precio unitario:</strong>

                                                        <v-text-field
                                                            v-text="precio"
                                                            clearable
                                                            :disabled= true
                                                            style="display: inline-block;"
                                                        ></v-text-field>

                                                         </v-col>

                                                        <v-col
                                                        cols="12"
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <v-text-field

                                                            v-model="editedItem.cantidad"
                                                            label="Cantidad"
                                                            hide-details
                                                            rounded
                                                            filled
                                                            dense
                                                            type="number"
                                                            clearable
                                                            prepend-icon="local_mall"
                                                            required
                                                        ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                        cols="12"
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <v-btn dark class="ma-2" outlined color="#ff5300"   @click="add" :disabled="!valid">Agregar</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                    <v-divider
                                                        class="mx-5"
                                                        ></v-divider>
                                                    <v-row style="padding: 1rem; border-radius: 1rem; background: #fff;" class="elevation-2">
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                            <v-data-table
                                                            :headers="headers_productos"
                                                            :items="productosS"
                                                            dense
                                                            >

                                                             <template v-slot:item.actions="{ item }">
                                                                <v-icon small class="mr-2" @click="editItemProduct(item)"> mdi-pencil </v-icon>
                                                                <v-icon small @click="deleteItemProducts(item)"> mdi-delete </v-icon>

                                                                <v-dialog
                                                                    v-model="dialogEditProduct"
                                                                    max-width="400px"
                                                                    :retain-focus="false"
                                                                >
                                                                    <v-card>
                                                                    <v-card-title>
                                                                        <p>Editar Cantidad</p>
                                                                    </v-card-title>
                                                                    <v-card-text>
                                                                        <v-text-field
                                                                            :retain-focus="false"
                                                                            v-model="editedItem.cantidad"
                                                                            label="Ingrese la nueva Cantidad"
                                                                            type="number"
                                                                            clearable
                                                                            prepend-icon="local_mall"
                                                                            required
                                                                        ></v-text-field>
                                                                    </v-card-text>
                                                                    <v-card-actions>
                                                                        <v-btn
                                                                        color="primary"
                                                                        text
                                                                        @click="cancelarEditar"
                                                                        >
                                                                        Cancelar
                                                                        </v-btn>
                                                                        <v-spacer></v-spacer>
                                                                        <v-btn
                                                                        color="primary"
                                                                        text
                                                                        @click="modifyQuantity(item)"
                                                                        >
                                                                        Aceptar
                                                                        </v-btn>
                                                                    </v-card-actions>
                                                                    </v-card>
                                                                </v-dialog>
                                                            </template>

                                                            <template v-slot:no-data>
                                                            <v-alert
                                                                justify="center"
                                                                type="info"
                                                                color="#ff5400"
                                                                dense
                                                                border="left"
                                                                elevation="4">No se han seleccionado productos.</v-alert>
                                                            </template>
                                                            </v-data-table>
                                                        </v-col>
                                                        </v-row>
                                                        </v-container>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="3"
                                                    sm="12"
                                                    style="height:100%;"
                                                    >
                                                    <v-row style="padding: 2.5rem; border-radius: 1rem; background: #fff;" class="elevation-2">
                                                        <h2>Total a pagar:</h2>
                                                        <h3><v-icon color="green" style="font-size: xx-large;">monetization_on</v-icon> {{totalPrecio}}</h3>
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                            <v-btn class="ma-2" x-large block outlined color="#ff5300" @click="close">Cancelar</v-btn>
                                                        </v-col>
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                            <v-btn dark class="ma-2" x-large block color="#ff5300" :disabled="!valid"  @click="save">Aceptar</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-form>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn class="ma-2" outlined color="#ff5300" @click="close">Cerrar</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                                </v-card>
                                </v-dialog>
                            </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                            <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
                            </template>
                            <template v-slot:no-data>
                            <v-alert
                                justify="center"
                                type="info"
                                color="#ff5400"
                                dense
                                border="left"
                                elevation="4">No se ha realizado ninguna venta.</v-alert>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>

    export default {
        data() {
            return {
                dialog: false,
                dialogEditProduct: false,
                dis:true,
                stock: '',
                precio:'',
                totalPrecio: 0,
                pre: 0,
                search: '',
                  date: '',
                //Con el comando date se obtiene la fecha actual y se crea una nueva fecha
                //aplicando un formato legible para el usuario
                date1: new Date().toISOString().substr(0, 10),
                menu:false,
                loading: true,
                valid: false,
                edit_mode: false,
                 //Declaramos las propiedades del select_deliverer
                select_deliverer: {
                    id: '',
                    nombre: '',
                },
                 //Declaramos las propiedades del select_route
                select_route:{
                    route_id: '',
                    municipio: '',
                },
                //Declaramos las propiedades del select_product
                select_product: {
                    id: '',
                    nombre: '',
                    cantidad:'',
                    precio_venta:'',
                    pw_id:'',
                },
                //Declaramos las propiedades del select_customer
                select_customer:{
                    id: '',
                    nombre: '',
                },
                salidaProducto:{
                    id:'',
                    nombre:'',
                    cantidad:'',
                    precio_venta:'',
                    pw_id:'',
                },
                //Se asignan los títulos de las columnas de la tabla principal,
                //así como su valor correspondiente.
                headers: [
                    { text: '#', value: 'id' }, /*align: 'start', sortable: false,*/
                    { text: 'Cliente', value: 'customer.nombre' },
                    { text: 'Monto', value: 'monto' },
                    { text: 'Fecha de venta', value: 'created_at'},
                    //{ text: 'Acciones', value: 'actions', sortable: false },
                ],
                //Se asignan los títulos de las columnas de la tabla de productos de una venta,
                //así como su valor correspondiente.
                headers_productos: [
                    {text: 'Nombre', value: 'nombre'},
                    {text: 'Cantidad', value: 'cantidad'},
                    {text: 'Precio unitario', value: 'precio_venta'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                sales: [],
                productosS:[],
                nombres:[],
                routes:[],
                productos:[],
                clientes:[],
                movementlist:[],
                saleDetails:[],
                acum:1,
                editedIndex: -1,
                editedItem: {
                //Se crean los objetos a utilizar
                //Se crean  e indican los elementos que contendra el objeto y su valor predeterminado
                    id: '',
                    //cantidad: '',
                    fecha:'',
                    monto: '',
                    observacion: '',
                    created_at: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    //cantidad: '',
                    fecha: '',
                    monto: '',
                    observacion: '',
                    created_at: '',
                    status: ''
                },
                //Verificamos que se ingrese el dato solicitado y no se deje vacío el campo
                required( propertyName ) {
                    return v => v && v.length > 0 || `Debes ingresar un ${propertyName}`
                },
                //Se verifica que la cantidad de caracteres ingresados no sea menor a lo que se especificado
                minimum_length( length ) {
                    return v => v && v.length >= length || `Longitud mínima de ${length} caracteres`
                },
                //Mediante el uso de expresiones regulares verificamos que el dato ingresado sea un Email
                email_form() {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return v => v && regex.test(v) || `Debes ingresar un email valido`
                },

             }
        },

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Nueva Venta' : 'Editar registro'
            },
            fecha () {
                return this.date1
            }
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        methods: {
            add(){
                //Comprobamos que la cantidad ingresada por el usaurio sea menor a la cantidad
                //que hay en la salida de dónde se toma el producto
                 if(this.editedItem.cantidad>this.select_product.cantidad){
                    Swal.fire({
                        title: 'Alerta',
                        text: "No hay suficiente cantidad de producto",
                        type: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Entendido'
                        });
                    this.producto=''
                    this.stock=''
                    this.precio=''
                    }
                    else{

                 //comprobamos que el producto seleccionado no esté ya registrado
                for (let index = 0; index < this.productosS.length; index++) {

                   //obtenemos con index la posición del arreglo y de este su nombre para compararlo con el nombre seleccionado en el select
                   if (this.productosS[index].nombre == this.select_product.nombre) {
                        this.producto = this.productosS[index].nombre
                        break
                    }

                }
                if (this.select_product.nombre == this.producto) {
                    if ( this.select_product.nombre == "" || this.select_product.nombre == undefined || this.select_product.nombre == null && this.editedItem.cantidad >=0)  {
                        Swal.fire({
                        title: 'Alerta',
                        text: "Seleccione un producto e ingrese una cantidad",
                        type: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Entendido'
                        });
                    }else{
                    Swal.fire({
                        title: 'Alerta',
                        text: "Este producto ya esta en la lista!",
                        type: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Entendido'
                        });
                    }
                    this.producto=''
                    this.stock=''
                    this.precio=''
                }

                else{

                    if (this.editedItem.cantidad <= 0 || this.editedItem.cantidad == undefined || this.editedItem.cantidad == null || this.editedItem.cantidad == '' ) {

                        if ( this.select_product.nombre == "" || this.select_product.nombre == undefined || this.select_product.nombre == null )  {
                            Swal.fire({
                            title: 'Alerta',
                            text: "No ha seleccionado ningun producto!",
                            type: 'warning',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Entendido'
                            });
                        }else{
                            Swal.fire({
                            title: 'Cantidad invalida',
                            text: "Ingrese un numero mayor a 0!",
                            type: 'warning',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Entendido'
                            });
                            this.editedItem.cantidad = ''
                        }
                        this.editedItem.cantidad = ''
                    }else{
                        this.salidaProducto={
                        'id':this.select_product.id,
                        'nombre':this.select_product.nombre,
                        'cantidad':this.editedItem.cantidad,
                        'precio_venta':this.select_product.precio_venta,
                        'pw_id':this.select_product.pw_id
                        }
                        //Calculamos el total de la venta según los datos guardados por el usaurio
                        //y alamacenados en "salidaProducto"
                        this.totalPrecio=this.totalPrecio+(this.select_product.precio_venta * this.editedItem.cantidad )

                        this.productosS.push(this.salidaProducto);
                        console.log(this.productosS)
                        this.select_product=[0];
                        this.select_product.id='';
                        this.editedItem.cantidad='';
                        this.producto=''
                        this.stock=''
                        this.precio=''
                    }

                }
                //Limpiamos nuestros elementos del formulario
                this.select_product=[0];
                    this.select_product.id='';
                    this.editedItem.cantidad='';
                    this.producto=''
                    this.stock=''
                    this.precio=''
                    }

            },
            //Método para permitir la modificación de la cantidad de un producto seleccionado
            modifyQuantity(item){
                this.pre= this.editedItem.cantidad - this.productosS[this.editedIndex].cantidad;
                    console.log(this.pre)
                    this.totalPrecio=(this.totalPrecio)+(this.productosS[this.editedIndex].precio_venta *  this.pre );

                this.productosS[this.editedIndex].cantidad=this.editedItem.cantidad
                this.editedIndex = -1
                this.editedItem.cantidad='';
                //this.indexCantidad=null;
                this.dialogEditProduct = false


            },

             //Llamamos al objeto a editar
            editItem (item) {
            //IndexOf nos permite  buscamos la posición de este dentro del arreglo de "sales"
                this.editedIndex = this.sales.indexOf(item)
                //Clonamos el objeto
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                this.edit_mode = true
            },
            editItemProduct (item) {
                this.editedIndex = this.productosS.indexOf(item)
                this.editedItem = Object.assign({}, item) // Clone an object
                this.dialogEditProduct = true


            },
            //Eliminamos de la tabla y de la lista de productos para realizar la venta el producto seleccionado
            deleteItemProducts(item) {
                const index = this.productosS.indexOf(item)
                confirm('¿Estas seguro de eliminar este producto de la lista?') && this.productosS.splice(index, 1)
            },
            //Cerramos el dialogo para cambiar la cantidad de producto a vender
            cancelarEditar(){
                this.editedItem.cantidad='';
                this.dialogEditProduct= false
            },
            close () {
                //this.$refs.form.reset()
                this.dialog = false
                this.productosS=[]
                this.select_deliverer = [0]
                this.select_route = [0]
                this.select_customer = [0]
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                this.totalPrecio= 0
                })
                if (this.edit_mode == true) {
                    this.edit_mode = false
                }
            },
            async save () {
                //Mandamos los datos necesarios al controlador para llenar la tabla ventas
                if (this.productosS.length == 0) {
                    Swal.fire({
                        title: 'Alerta',
                        text: "No ha agregado ningun producto!",
                        type: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Entendido'
                        });
                }else{
                    const response = await axios.post('/api/sales',{
                        'fecha_salida': this.date1,
                        'observacion': this.editedItem.observacion,
                        'products':this.productosS,
                        'deliverer_id':this.select_deliverer.id,
                        'customer_id':this.select_customer.id
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Venta registrada!'
                        })
                        console.log(response.data);
                        this.productosS=[];
                        this.totalPrecio= 0

                     }
                     this.getStock();
                    this.close();
                }

            },
            async deleteItem (item) {
                this.editedIndex = this.sales.indexOf(item)
                this.editedItem = Object.assign({}, item)
                Swal.fire({
                    title: '¿Estás seguro de desactivar esta salida?',
                    text: "Se cambiara el status de activo!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff5300',
                    cancelButtonColor: '#C1BCBB',
                    confirmButtonText: 'Si, desactivalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`api/routes/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Desactivado!',
                            'El registro del movimiento ha sido desactivado.',
                            'success'
                            )

                        }).catch(() => {
                            Swal('Ocurrió un error', 'Algo salió mal con el servidor.', 'warning');
                        });
                    } else {
                        this.editedItem = Object.assign({}, this.defaultItem)
                    }
                });
            },

            //En este método obtenemos la cantidad del producto seleccionado
            getStock(){
                this.stock= this.select_product.cantidad;
                this.precio=this.select_product.precio_venta;
            },

           //Obtenemos todas las ventas realizadas
           getResults() {
                axios.get('api/sales')
                .then(response => {
                    this.sales = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            //Obtenemos todos los repartidores activos
            getDeliverers(){
                axios.get('api/deliverers')
                .then(response => {
                    this.nombres = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            //Obtenemos las rutas que tiene un repartidor (según el id otorgado)
            getRoutesList(){
                this.dis=false
                axios.get(`api/routes/${this.select_deliverer.id}`)
                .then(response => {
                    this.routes = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
                //Obtenemos la ultima salida que ha realizado un repartidor (enviamos el id del repartidor)
                // getmovement(){
                axios.get(`api/getmovementList/${this.select_deliverer.id}`)
                .then(response => {
                    this.movementlist = response.data;
                    console.log(response.data)
                    this.loading = false;
                    this.getProducts();
                 });

            },
            //En este método obtenemos todos los productos que tiene la salida indicada

            //Obtenemos los clientes que pertenecen a la ruta indicada
            getClientsNames(){
                this.dis=false
                axios.get(`api/getCustomer/${this.select_route.route_id}`)
                .then(response => {
                    this.clientes = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },

            //Obtemos los productos que tiene la venta seleccionada(id de la venta)
            getSaleDetail(){
                axios.get(`api/getSaleDetail/3`)
                .then(response => {
                    this.saleDetails = response.data;
                    console.log(response.data)
                    this.loading = false;
                      });
            },
            getProducts(){
                axios.get(`api/warehouse_movements/${this.movementlist[0].id}`)
                .then(response => {
                    this.productos = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },

        },

        created () {
            this.getResults();
            this.getDeliverers();
            //this.getProducts();
            this.getSaleDetail();
            //this.getmovement();
        },
    }
</script>
