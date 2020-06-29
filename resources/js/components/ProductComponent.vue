<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" sm="12" md="12">
                        <v-data-table
                            :headers="headers"
                            :items="desserts"
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
                            <template v-slot:item.nombre="{ item }">
                                {{item.nombre | formatUpperCase}}
                            </template>
                            <template v-slot:item.descripcion="{ item }">
                                {{item.descripcion | formatUpperCase}}
                            </template>
                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Productos</v-toolbar-title>
                                <v-divider
                                class="mx-5"
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
                                <v-divider
                                class="mx-5"
                                inset
                                vertical
                                ></v-divider>
                                <v-btn color="#ff3f00" dark class="mb-2">Añadir unidad &nbsp;<i class="material-icons">queue</i></v-btn>
                                &nbsp;&nbsp;
                                <v-dialog v-model="dialog" scrollable max-width="810px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" dark class="mb-2" v-on="on" >Nuevo Producto &nbsp;<i class="material-icons">queue</i></v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">local_mall</i>
                                            </p>
                                            <p style="text-align: center; color:#ffffff; font-size:24px; margin-bottom: -10px;">
                                                <strong>{{ formTitle }}</strong>
                                            </p>
                                            </v-col>
                                    </v-container>
                                <v-card-text style="padding-bottom:0px;">
                                    <v-container style="padding-bottom:0px;">
                                        <v-form v-model="valid" ref="form" style="margin-bottom:0px;">
                                            <v-container>
                                                <v-row>
                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.nombre"
                                                        :counter="45"
                                                        label="Nombre"
                                                        type="text"
                                                        prepend-icon="turned_in_not"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    v-if="edit_mode"
                                                    >
                                                    <v-text-field

                                                        v-model="editedItem.stock"
                                                        label="Stock"
                                                        type="number"
                                                        prepend-icon="domain"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('stock')]"
                                                        v-model="editedItem.stock"
                                                        label="Stock"
                                                        type="number"
                                                        prepend-icon="domain"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('stock mínimo')]"
                                                        v-model="editedItem.stock_minimo"
                                                        label="Stock minimo"
                                                        type="number"
                                                        prepend-icon="insert_chart_outlined"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    >

                                                    <v-autocomplete
                                                        v-model="selectProvider"

                                                        :items="providers"
                                                        item-text="nombre"
                                                        item-value="id"
                                                        label="Proveedor"
                                                        prepend-icon="storefront"
                                                        persistent-hint
                                                        return-object
                                                    ></v-autocomplete>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    v-if="edit_mode"
                                                    >
                                                    <v-text-field

                                                        v-model="editedItem.precio_compra"
                                                        :counter=true
                                                        type="text"
                                                        clearable
                                                        prepend-icon="attach_money"
                                                        label="Precio de compra"
                                                        hint="*Solo si está seguro"
                                                        persistent-hint
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                        v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('precio de compra')]"
                                                        v-model="editedItem.precio_compra"
                                                        :counter="5"
                                                        type="text"
                                                        clearable
                                                        prepend-icon="attach_money"
                                                        label="Precio de compra"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                    v-if="edit_mode"
                                                    >
                                                    <v-text-field
                                                        v-model="editedItem.precio_venta"
                                                        :counter=true
                                                        type="text"
                                                        clearable
                                                        label="Precio de venta"
                                                        prepend-icon="local_atm"
                                                        hint="*Solo si está seguro"
                                                        persistent-hint
                                                    ></v-text-field>                                                                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="6"
                                                        v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('precio de venta')]"
                                                        v-model="editedItem.precio_venta"
                                                        :counter="5"
                                                        type="text"
                                                        clearable
                                                        label="Precio de venta"
                                                        prepend-icon="local_atm"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="12"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('descripcion'), minimum_length(8)]"
                                                        v-model="editedItem.descripcion"
                                                        :counter="45"
                                                        label="Descripción"
                                                        type="text"
                                                        prepend-icon="format_align_justify"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="4"
                                                    >

                                                    <v-autocomplete
                                                        v-model="selectUnit"

                                                        :items="units"
                                                        item-text="tipo"
                                                        item-value="id"
                                                        label="Unidad de medida"
                                                        prepend-icon="category"
                                                        persistent-hint
                                                        return-object
                                                    ></v-autocomplete>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="2"
                                                    sm="4"
                                                    >
                                                    <v-checkbox
                                                        v-model="editedItem.meta"
                                                        label="Meta"
                                                        clearable
                                                        required
                                                    ></v-checkbox>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-form>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn class="ma-2" outlined color="#ff5300" @click="close">Cancelar</v-btn>

                                    <v-btn dark class="ma-2" color="#ff5300" :disabled="!valid" @click="save"><i class="material-icons">save</i>Guardar</v-btn>
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
                                elevation="4">No hay productos registrados.</v-alert>
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
                loading: true,
                valid: false,
                edit_mode: false,
                selectProvider:{
                    id: '',
                    nombre: '',
                },
                selectUnit:{
                    id: '',
                    tipo: '',
                },
                headers: [
                    { text: 'Nombre', value: 'nombre' }, /*align: 'start', sortable: false,*/
                    { text: 'Meta', value: 'meta' },
                    { text: 'Unidad de medidad', value: 'unit.tipo' },
                    { text: 'Precio de Venta', value: 'precio_venta' },
                    { text: 'Stock', value: 'stock' },
                    { text: 'Descripción', value: 'descripcion' },
                    { text: 'Registrado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                desserts: [],
                providers:[],
                units:[],
                editedIndex: -1,
                editedItem: {
                    id: '',
                    nombre: '',
                    meta: '',
                    unidadM: '',
                    provider_id:'',
                    precio_compra:'',
                    precio_venta: '',
                    stock:'',
                    stock_minimo:'',
                    descripcion: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    meta: false,
                    unidadM: '',
                    provider_id:'',
                    precio_compra:'',
                    precio_venta: '',
                    stock: '',
                    stock_minimo:'',
                    descripcion: '',
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
                }
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
            editItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
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
                if (this.editedIndex > -1) {
                    const response = await axios.put(`api/products/${this.editedItem.id}`, this.editedItem)
                    .catch(error => console.log(error));
                    if (response.data.validation_errors) {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Ocurrió un error, vuelve a intentarlo!'
                        });
                        console.log(response.data);
                    } else {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Datos del Producto actualizados!'
                        })
                    }
                } else {
                    const response = await axios.post('/api/products',{
                        'nombre': this.editedItem.nombre,
                        'meta': this.editedItem.meta,
                        'descripcion' : this.editedItem.descripcion,
                        'precio_compra' : this.editedItem.precio_compra,
                        'precio_venta' : this.editedItem.precio_venta,
                        'stock' : this.editedItem.stock,
                        'stock_minimo':this.editedItem.stock_minimo,
                        'unit_id':this.selectUnit.id,
                        'provider_id':this.selectProvider.id,
                        'status': this.editedItem.status
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: 'Producto registrado!'
                        })
                        console.log(response.data);
                    }
                }

                this.close();
            },
            async deleteItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                Swal.fire({
                    title: '¿Estás seguro de desactivar este prodcuto?',
                    text: "Se cambiara el status de activo!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff5300',
                    cancelButtonColor: '#C1BCBB',
                    confirmButtonText: 'Sí, desactivalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`api/products/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Desactivado!',
                            'El producto ha sido desactivado.',
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
                axios.get('api/products')
                .then(response => {
                    this.desserts = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            getNameProviders(){
                axios.get('api/providers')
                .then(response => {
                    this.providers = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            getTypeUnit(){
                axios.get('api/units')
                .then(response => {
                    this.units = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
        },

        created () {
            this.getResults();
            this.getNameProviders();
            this.getTypeUnit();
        },
    }
</script>
