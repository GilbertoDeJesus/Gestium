<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row justify="center">
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
                            <template v-slot:item.created_at="{ item }">
                               {{item.created_at | formatDateTime | formatUpperCase}}
                            </template>
                            <template v-slot:item.fecha_salida="{ item }">
                               {{item.fecha_salida | formatDateTimeShort | formatUpperCase}}
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
                                    append-icon="search"
                                    label="Buscar"
                                    single-line
                                    hide-details
                                    color="#ff5200"
                                ></v-text-field>
                                <v-spacer></v-spacer>

                                <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff5300" dark class="mb-2" v-on="on">Nueva Salida</v-btn>
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
                                                    md="12"
                                                    sm="6"
                                                    >
                                                    <v-select
                                                        v-model="select_deliverer"

                                                        :items="nombres"
                                                        item-text="nombre"
                                                        item-value="id"
                                                        label="Seleccione al repartidor"
                                                        prepend-icon="local_shipping"
                                                        persistent-hint
                                                        return-object
                                                        ></v-select>
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
                                                    md="12"
                                                    sm="6"
                                                    >
                                                    <v-dialog
                                                        ref="dialog"
                                                        v-model="menu"
                                                        :return-value.sync="date1"
                                                        persistent
                                                        width="290px"
                                                    >
                                                        <template v-slot:activator="{ on }">
                                                        <v-text-field
                                                            v-model="editedItem.fecha_salida"
                                                            label="Fecha de salida"
                                                            prepend-icon="event"
                                                            readonly
                                                            v-on="on"
                                                        ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                        :rules="[required('fecha de salida')]"
                                                        v-model="editedItem.fecha_salida"
                                                        locale="mx"
                                                        format="YYYY-MM-dd"
                                                        required
                                                        color="#fd2d21"
                                                        @input="menu = false"
                                                        ></v-date-picker>
                                                    </v-dialog>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-select
                                                        v-model="select_product"

                                                        :items="productos"
                                                        item-text="nombre"
                                                        item-value="id"
                                                        label="Seleccione un producto"
                                                        prepend-icon="local_mall"
                                                        persistent-hint
                                                        return-object
                                                        ></v-select>
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
                                    <v-btn dark class="ma-2" color="#ff5300"   @click="add">Agregar</v-btn>


                                                </v-row>
                                            </v-container>
                                        </v-form>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn class="ma-2" outlined color="#ff5300" @click="close">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn dark class="ma-2" color="#ff5300" :disabled="!valid"  @click="save">Guardar</v-btn>
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
                                elevation="4">No se ha realizado ninguna saida.</v-alert>
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
                search: '',
                  date: '',
                date1: new Date().toISOString().substr(0, 10),
                menu:false,
                loading: true,
                valid: false,
                edit_mode: false,
                select_deliverer: {
                    id: '',
                    nombre: '',
                },
                 select_product: {
                    id: '',
                    nombre: '',
                },
                select_tipoM: { text: 'Salida', id: '1' },
                tipoMovimiento: [
                    { nombre: 'Salida', id: '1' },
                    { nombre: 'Devolución', id: '0' },
                ],

                headers: [
                    { text: 'Repartidor', value: 'deliverer.nombre' }, /*align: 'start', sortable: false,*/
                    { text: 'Producto', value: 'product_id' },
                    { text: 'Cantidad', value: 'cantidad'},
                    { text: 'Fecha de salida', value: 'fecha_salida'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                salidas: [],
                productosS:[],
                nombres:[],
                productos:[],
                acum:1,
                editedIndex: -1,
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
                required( propertyName ) {
                    return v => v && v.length > 0 || `Debes ingresar un ${propertyName}`
                },
                minimum_length( length ) {
                    return v => v && v.length >= length || `Longitud mínima de ${length} caracteres`
                },
                email_form() {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return v => v && regex.test(v) || `Debes ingresar un email valido`
                },

             }
        },

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Nuevo registro' : 'Editar registro'
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        methods: {
            add(){
                var persona={id:this.select_product.id,cantidad:this.editedItem.cantidad}
                this.productosS.push(persona);
                console.log(this.productosS)
                this.select_product=[0];
                this.select_product.id='';
              this.editedItem.cantidad='';

            },

            editItem (item) {
                this.editedIndex = this.salidas.indexOf(item)
                this.editedItem = Object.assign({}, item) // Clone an object
                this.dialog = true
                this.edit_mode = true
            },
            close () {
                this.$refs.form.reset()
                this.dialog = false
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                })
                if (this.edit_mode == true) {
                    this.edit_mode = false
                }
            },
            async save () {
                    const response = await axios.post('/api/warehouse_movements',{ //llena tabla movimientos
                        'fecha_salida': this.editedItem.fecha_salida,
                        'deliverer_id': this.select_deliverer.id,
                        'product_id': '1',
                        'cantidad': this.editedItem.cantidad,
                        'tipoMovimiento': this.select_tipoM.id,
                    }).catch(error => console.log("Error: " + error));


                   /*if (this.select_tipoM.id=='1') { //comprueba el tipo de movimietno
                       const response=await axios.put(`/api/updateS`,
                        this.productosS).catch(error => console.log("Error: " + error));
                        if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Salida registrado!'
                        })
                        console.log(response.data);
                        this.productosS=[];

                    }
                    }else{
                       const response=await axios.put(`/api/returnProduct`,
                        this.productosS).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Salida registrado!'
                        })
                        console.log(response.data);
                        this.productosS=[];

                     }
                    }*/
                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Salida registrado!'
                        })
                        console.log(response.data);
                        this.productosS=[];

                     }
                this.close();

            },
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

            getResults() {
                axios.get('api/warehouse_movements')
                .then(response => {
                    this.salidas = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
                axios.get('api/deliverers')
                .then(response => {
                    this.nombres = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
                axios.get('api/products')
                .then(response => {
                    this.productos = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },

        },

        created () {
            this.getResults();
        },
    }
</script>
