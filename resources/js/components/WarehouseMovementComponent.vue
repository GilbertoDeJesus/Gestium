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
                            <p style="text-align: center; font-size:28px; font-weight:700; margin-bottom: -10px;"><strong>Listado de salidas de productos registradas</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="10" sm="12" md="10">
                        <v-data-table
                            :headers="headers"
                            :items="salidas"
                            sort-by="calories"
                            class="elevation-3"
                            :search="search"
                            :loading="loading" loading-text="Estamos cargando tu información"
                            :items-per-page="6"
                            :footer-props="{
                                'items-per-page-options': [7, 10, 20]
                            }">
                            <template v-slot:item.nombre="{ item }">
                               <v-chip class="ma-2">
                                    <v-avatar left >
                                        <v-icon color="green">mdi-account-circle</v-icon>
                                    </v-avatar>{{item.nombre | formatUpperCase}}
                                </v-chip>
                            </template>
                            <template v-slot:item.created_at="{ item }">
                               {{item.created_at | formatDateTime | formatUpperCase}}
                            </template>
                            <template v-slot:item.fecha_salida="{ item }">
                               {{item.fecha_salida | formatDateTimeShort | formatUpperCase}}
                            </template>
                            <template v-slot:item.sum="{ item }">
                                <v-chip class="ma-1" color="orange" dark>
                                    {{item.sum}}
                                </v-chip>
                            </template>
                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Salidas</v-toolbar-title>
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
                                <v-dialog v-model="dialog" scrollable max-width="900px" persistent>
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>playlist_add</v-icon>Nueva Salida</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">assignment_turned_in</i>
                                            </p>
                                            <p style="text-align: center; color:#ffffff; font-size:24px; margin-bottom: -10px;"><strong>{{ formTitle }}</strong></p>
                                        </v-col>
                                    </v-container>

                                <v-card-text style="padding-bottom:0px;">
                                    <v-container style="padding-bottom:0px;">
                                        <v-form v-model="valid" ref="form">
                                            <v-container>
                                                <v-row>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="12"
                                                    >
                                                    <v-row justify="center">
                                                        <v-col
                                                        cols="12"
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <v-autocomplete

                                                            v-model="select_deliverer"
                                                            :items="nombres"
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
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <h4 style="line-height: 3.5em; font-size: 1.025rem;"><v-icon>mdi-calendar</v-icon>&nbsp;<b>Fecha:</b>&nbsp;&nbsp;{{fecha}}</h4>
                                                        </v-col>
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="6"
                                                        >
                                                        <v-select
                                                            v-model="select_tipoM"
                                                            :items="tipoMovimiento"
                                                            item-text="nombre"
                                                            item-value="id"
                                                            label="Seleccione el tipo de movimiento"
                                                            prepend-icon="local_shipping"
                                                            persistent-hint
                                                            return-object
                                                            ></v-select>
                                                        </v-col>

                                                        <v-col
                                                        cols="12"
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <v-autocomplete
                                                            v-model="select_product"
                                                            :items="productos"
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
                                                        <v-text-field
                                                            :rules="[required('cantidad')]"
                                                            v-model="editedItem.cantidad"
                                                            label="Cantidad"
                                                            type="number"
                                                            clearable
                                                            prepend-icon="local_mall"
                                                            required
                                                        ></v-text-field>
                                                        </v-col>
                                                        <v-spacer></v-spacer>
                                                        <v-btn
                                                        :disabled="!valid"
                                                        dark class="ma-2"
                                                        color="#ff5300"
                                                        style="padding-right:4rem; padding-left:4rem;"
                                                        @click="add"
                                                        >Agregar</v-btn>
                                                    </v-row>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="12"
                                                    >
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >

                                                            <v-data-table
                                                            :headers="headers_productos"
                                                            :items="productosS"
                                                            sort-by="calories"
                                                            :loading="loading" loading-text="Estamos cargando tu información"
                                                            :items-per-page="6"
                                                            :footer-props="{
                                                                'items-per-page-options': [7, 10, 20]
                                                            }"
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
                                                                        Guardar
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
                                                                elevation="4">No se ha seleccionado ningun producto.</v-alert>
                                                            </template>
                                                            </v-data-table>
                                                        </v-col>
                                                    </v-col>

                                                </v-row>
                                            </v-container>
                                        </v-form>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn class="ma-2" outlined color="#ff5300" @click="close">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn dark class="ma-2" color="#ff5300" @click="save">Guardar</v-btn>
                                </v-card-actions>
                                </v-card>
                                </v-dialog>
                            </v-toolbar>
                            </template>

                            <template v-slot:item.actions="{item}">
                                <v-chip class="ma-1" color="primary" dark @click=" showdetails(item)" v-bind:key = " item.id ">
                                    <v-avatar left>
                                        <v-icon small>local_shipping</v-icon>
                                    </v-avatar>Ver
                                </v-chip>



                             <v-dialog
                             :retain-focus="false"
                             v-model="dialogProductList"
                             scrollable
                             fullscreen
                             persistent
                             class="perfect-scrollbar-on"
                             >
                                <v-card style="background:#f5f5f5; height:100%; margin: 0; display: flex; flex-direction: column;">


                                <v-card-text style="padding-bottom:0px;">
                                    <v-row style="height:100%; margin-left: -24px;">
                                        <v-col
                                        cols="12"
                                        md="4"
                                        sm="12"
                                        style="background: linear-gradient(60deg, #fd2d21, #fc831a); max-width: 100%;">
                                        <v-container class="align-items-center" max-width='100%'>
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">

                                            <v-list style="background: white; padding: 0px" two-line>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title style="font-size:1.5rem; color:#ff5300; text-align:center;">Lista de productos</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-list>

                                            <v-list style="background: transparent;" dark two-line>
                                                <v-divider></v-divider>
                                                <v-list-item>
                                                    <v-list-item-icon>
                                                        <v-icon style="font-size:2rem;">mdi-briefcase</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-content>
                                                        <v-list-item-title style="font-size:1.5rem;">{{formNombre | formatUpperCase}}</v-list-item-title>
                                                        <v-list-item-subtitle style="font-size:1rem;">Repartidor</v-list-item-subtitle>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                <v-divider></v-divider>
                                                <v-list-item>
                                                    <v-list-item-icon>
                                                        <v-icon style="font-size:2rem;">mdi-calendar</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-content>
                                                        <v-list-item-title style="font-size:1.5rem;">{{formFecha | formatDateTime | formatUpperCase}}</v-list-item-title>
                                                        <v-list-item-subtitle style="font-size:1rem;">Fecha de salida</v-list-item-subtitle>
                                                    </v-list-item-content>
                                                </v-list-item>

                                                <v-divider></v-divider>
                                                <v-list-item>
                                                    <v-list-item-content style="font-size:1.5rem; text-align:center;">
                                                            <v-btn color="#ff5300" dark @click="closeProductList"><v-icon left>mdi-close</v-icon>Cerrar</v-btn>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-list>
                                        </v-col>
                                    </v-container>
                                        </v-col>
                                        <v-col
                                        cols="12"
                                        md="8"
                                        sm="12">
                                    <v-container style="margin-top:1.5rem; max-width: 600px;" >

                                        <v-spacer></v-spacer>
                                        <v-spacer></v-spacer>
                                            <v-text-field
                                                v-model="searchP"
                                                prepend-inner-icon="search"
                                                label="Buscar productos"
                                                hide-details
                                                filled
                                                rounded
                                                single-line
                                                dense
                                                color="#ff5200"
                                                clearable
                                            ></v-text-field>
                                        <v-spacer></v-spacer>
                                        <v-spacer></v-spacer>
                                    </v-container>
                                    <v-container style="margin-top:1.5rem;">
                                         <v-data-table
                                        :headers="hedaers_productList"
                                        :items="productList"
                                        :items-per-page="7"
                                        class="elevation-3"
                                        :search="searchP"
                                        >
                                            <template v-slot:item.created_at="{ item }">
                                            {{item.created_at | formatDateTime | formatUpperCase}}
                                            </template>
                                            <template v-slot:item.nombre="{ item }">
                                                <v-chip>
                                                    <v-avatar left>
                                                        <v-icon color="teal">mdi-archive</v-icon>
                                                        </v-avatar>{{item.nombre | formatUpperCase}}
                                                </v-chip>
                                            </template>
                                            <template v-slot:item.cantidad="{ item }">
                                                <v-chip color="orange" dark>
                                                    <v-avatar left>
                                                        <v-icon>mdi-package-variant</v-icon>
                                                        </v-avatar>{{item.cantidad}}
                                                </v-chip>
                                            </template>
                                            <template v-slot:item.fecha_salida="{ item }">
                                            {{item.fecha_salida | formatDateTimeShort | formatUpperCase}}
                                            </template>

                                     </v-data-table>
                                    </v-container>
                                        </v-col>
                                    </v-row>
                                </v-card-text>


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
                                elevation="4">No se ha realizado ninguna salida.</v-alert>
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
                id_movement:0,
                dialog: false,
                dialogEditProduct: false,
                dialogProductList: false,
                search: '',
                searchP: '',
                  date: '',
                producto: '',
                nDeliverer: '',
                nFecha: '',
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
                //Declaramos las propiedades del select_product
                 select_product: {
                    id: '',
                    nombre: '',
                },
                //Declaramos las propiedades del salidaProducto
                salidaProducto:{
                    id:'',
                    nombre:'',
                    cantidad:'',
                },
                 //Declaramos las propiedades del select_tipoM
                select_tipoM: { text: 'Salida', id: '1' },
                tipoMovimiento: [
                    { nombre: 'Salida', id: '1' },
                    { nombre: 'Devolución', id: '0' },
                ],
                //Se asignan los títulos de las columnas de la tabla principal,
                 //así como su valor correspondiente.
                headers: [
                    { text: 'Clave', value: 'id' }, /*align: 'start', sortable: false,*/
                    { text: 'Repartidor', value: 'nombre' },
                    { text: 'Fecha de salida', value: 'created_at'},
                    { text: 'Cantidad de productos', value: 'sum'},
                    { text: 'Lista de productos', value: 'actions', sortable: false },
                ],
                //Se asignan los títulos de las columnas de la tabla que se muestra en el dialogo
                 //para agregar productos en una salida (productos seleccionados)
                 //así como su valor correspondiente.
                hedaers_productList: [ /*align: 'start', sortable: false,*/
                    { text: 'Producto', value: 'nombre' },
                    { text: 'Cantidad', value: 'cantidad'},
                    { text: 'Fecha de salida', value: 'fecha_salida'},
                ],
                //Se asignan los títulos de las columnas de la tabla que se muestra en el dialogo
                //de los productos que tiene la salida seleccionada
                headers_productos: [
                    {text: 'Nombre', value: 'nombre'},
                    {text: 'Cantidad', value: 'cantidad'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                salidas: [],
                productosS:[],
                productList: [],
                nombres: [],
                productos: [],
                acum:1,
                editedIndex: -1,
                //Se crean los objetos a utilizar
                //Se crean  e indican los elementos que contendra el objeto y su valor predeterminado
                editedItem: {
                    id: '',
                    cantidad: '',
                    fecha_salida:'',
                    created_at: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    cantidad: '',
                    created_at: '',
                    fecha_salida:'',
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
                reuqiredSelect(propertyName){
                    return v=> v && v.value == '' || `Debes seleccionar un ${propertyName}`
                },


             }
        },

        computed: {
            //Verificamos si el formulario es de creación o actualización y dependiendo de esto se le asigna un título
            formTitle () {
                return this.editedIndex === -1 ? 'Nueva salida' : 'Editar registro'
            },
            formNombre (){
                return this.nDeliverer
            },
            formFecha(){
                return this.nFecha
            },
            fecha(){
                return this.date1
            },

        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        methods: {
            add(){

                //comprobamos que el producto seleccionado no esté ya registrado
                for (let index = 0; index < this.productosS.length; index++) {
                    //obtenemos con index la posición del arreglo y de este su nombre para compararlo con el nombre seleccionado en el select
                    if (this.productosS[index].nombre == this.select_product.nombre) {
                        this.producto = this.productosS[index].nombre
                        break
                    }

                }
                if (this.select_deliverer.nombre == '') {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'No se ha seleccionado un repartidor',

                        });
                }else{

                    if (this.select_product.nombre == this.producto) {
                        if (this.select_deliverer.nombre == '') {
                            Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'No se ha seleccionado un repartidor',

                            });
                        }else{
                            Swal.fire({
                            title: 'Alerta',
                            text: "Este producto ya esta en la lista!",
                            type: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Entendido'
                            });
                            this.producto=''
                        }

                    }else{
                        //guardamos en "salidaProducto" todos los productos seleccionados junto con la cantidad de cada uno
                        this.salidaProducto={
                        'id':this.select_product.id,
                        'nombre':this.select_product.nombre,
                        'cantidad':this.editedItem.cantidad
                        }

                        //Enviamos a nuestro controlador los productos seleccionados y su cantidad
                        this.productosS.push(this.salidaProducto);
                        console.log(this.productosS)
                        //Limpiamos nuestros elementos del formulario
                        this.select_product=[0];
                        this.select_product.id='';
                        this.editedItem.cantidad='';
                        this.producto=''

                    }
                }

            },

            modifyQuantity(item){
                //this.editedIndex = this.productosS.indexOf(item)

                if (this.editedItem.cantidad != "") {
                    this.productosS[this.editedIndex].cantidad=this.editedItem.cantidad
                    this.editedIndex = -1
                    this.editedItem.cantidad='';
                    //this.indexCantidad=null;
                    this.dialogEditProduct = false
                }else{
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'No has ingresado una cantidad',

                        })
                }



            },

            //Llamamos al objeto a editar
            editItem (item) {
                 //IndexOf nos permite  buscamos la posición de este dentro del arreglo de "salidas"
                this.editedIndex = this.salidas.indexOf(item)
                 // Clonamos el objeto
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                this.edit_mode = true
            },
            editItemProduct (item) {

                this.editedIndex = this.productosS.indexOf(item)
                this.salidaProducto = Object.assign({}, item) // Clone an object
                this.dialogEditProduct = true
                this.getProductsList()


            },
            //Eliminamos de la tabla y de la lista de productos para realizar la salida al producto seleccionado
            deleteItemProducts(item) {
                const index = this.productosS.indexOf(item)
                //confirm('¿Esta seguro de eliminar este producto de la lista?') && this.productosS.splice(index, 1)
                Swal.fire({
                    title: '¿Esta seguro de eliminar este producto de la lista?',
                    text: "Esta acción no es reversible!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        this.productosS.splice(index, 1)
                            Swal.fire(
                            'Eliminado!',
                            'El producto ha sido eliminado de la lista.',
                            'success'
                            )
                            console.log(this.productosS)
                    } else {
                        this.productosS = Object.assign({}, this.defaultItem)
                    }
                });
            },
            //Cancelamos lae¿ edición de cancelar la cantidad elegida de un producto
            cancelarEditar(){
                this.editedItem.cantidad='';
                this.dialogEditProduct= false
            },
            //Cerramos el dialogo para crear una nuevo movimiento
            close () {
                this.productosS=[]
                //this.$refs.form.reset()
                this.dialog = false
                this.select_product = [0]
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                this.select_deliverer=[0]
                this.editedItem.cantidad=null;

                })
                if (this.edit_mode == true) {
                    this.edit_mode = false
                }
            },
            //Cerramos el dialogo que muestra los productos de una salida
            closeProductList(){
                this.dialogProductList=false
                this.productList=[]
            },
            async save () {
                if (this.productosS.length == 0) {
                    Swal.fire({
                        title: 'Alerta',
                        text: "No ha seleccionado ningun producto",
                        type: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Entendido'
                        });
                }else{
                //Mandamos los datos necesarios a nuestro controlador para llenar la tabla de movimientos y movimientos_producto
                    const response = await axios.post('/api/warehouse_movements',{
                        'fecha_salida': this.date1,
                        'deliverer_id': this.select_deliverer.id,
                        'products':this.productosS,
                        'tipoMovimiento': this.select_tipoM.id
                    }).catch(error => console.log("Error: " + error));


                   //De acuerdo al tipo de movimiento se llama la función para agrear (devolución) o realizar salida (salida) de un producto
                   if (this.select_tipoM.id=='1') { //comprueba el tipo de movimietno
                       const response=await axios.put(`/api/updateS`,
                        this.productosS).catch(error => console.log("Error: " + error));
                        if (response) {
                        this.getResults();
                        console.log(response.data);
                        this.productosS=[];

                    }
                    }else{
                       const response=await axios.put(`/api/returnProduct`,
                        this.productosS).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        console.log(response.data);
                        this.productosS=[];

                     }
                    }
                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Salida registrado!'
                        })
                        console.log(response.data);

                     }
                this.close();
                }

            },
            //Eliminamos de la tabla el movimiento seleccionado y cambiamos su "status"
            async deleteItem (item) {
                this.editedIndex = this.salidas.indexOf(item)
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
            //Abrimos un dialogo que muestra todos los productos de una salida
            async showdetails(item){
                this.editedIndex = this.salidas.indexOf(item)
                this.editedItem = Object.assign({}, item) // Clone an object
                this.id_movement= this.editedItem.id
                this.nDeliverer = this.editedItem.nombre
                this.nFecha= this.editedItem.created_at
                this.getProductsList()
                this.dialogProductList=true


            },

            //Obtenemos en "salidas" todas los movimientos realizados
            getResults() {
                axios.get('api/warehouse_movements')
                .then(response => {
                    this.salidas = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            //En este método obtenemos los repartidores con estado activo
            getDeliverers(){
                axios.get('api/deliverers')
                .then(response => {
                    this.nombres = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
             //En este método obtenemos los repartidores con estado activo
            getProducts(){
                axios.get('api/products')
                .then(response => {
                    this.productos = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
             //En este método obtenemos todos los productos que tiene la salida elegida (id_movement)
            getProductsList(){
                axios.get(`api/warehouse_movements/${this.id_movement}`)
                .then(response => {
                    this.productList = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },

        },

        created () {
            this.getResults();
            this.getDeliverers();
            this.getProducts();
            this.getProductsList();
        },
    }
</script>
