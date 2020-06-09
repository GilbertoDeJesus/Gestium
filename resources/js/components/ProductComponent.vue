<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row justify="center">
                    <v-col cols="11" sm="9" md="11">
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
                                <v-spacer></v-spacer>

                                <v-dialog v-model="dialog" max-width="550px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff5300" dark class="mb-4" v-on="on" >Nuevo Producto</v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                    <span class="headline orange--text text--accent-4">{{ formTitle }}</span>
                                    </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-form v-model="valid" ref="form">
                                            <v-container>
                                                <v-row>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.nombre"
                                                        :counter="45"
                                                        label="Nombre"
                                                        type="text"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('stock'), minimum_length(1)]"
                                                        v-model="editedItem.stock"
                                                        label="Stock"
                                                        type="number"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    v-if="edit_mode"
                                                    >
                                                    <v-text-field
                                                        v-model="editedItem.precio_compra"
                                                        :counter=true
                                                        type="text"
                                                        clearable
                                                        label="Precio de compra"
                                                        hint="*Solo si está seguro"
                                                        persistent-hint
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                        v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('precio_compra'), minimum_length(2)]"
                                                        v-model="editedItem.precio_compra"
                                                        :counter="2"
                                                        type="price"
                                                        clearable
                                                        label="Precio de compra"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    v-if="edit_mode"
                                                    >
                                                    <v-text-field
                                                        v-model="editedItem.precio_venta"
                                                        :counter=true
                                                        type="number"
                                                        clearable
                                                        label="Precio de venta"
                                                        hint="*Solo si está seguro"
                                                        persistent-hint
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                        v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('precio_venta'), minimum_length(2)]"
                                                        v-model="editedItem.precio_venta"
                                                        :counter="2"
                                                        type="number"
                                                        clearable
                                                        label="Precio de venta"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('descripcion'), minimum_length(8)]"
                                                        v-model="editedItem.descripcion"
                                                        :counter="45"
                                                        label="Descripción"
                                                        type="text"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
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
                                    <v-btn color="#ff5300" text @click="close">Cancel</v-btn>
                                    <v-btn color="#ff5300" :disabled="!valid" text @click="save">Save</v-btn>
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
                headers: [
                    { text: 'Nombre', value: 'nombre' }, /*align: 'start', sortable: false,*/
                    { text: 'Meta', value: 'meta' },
                    { text: 'Unidad de medidad', value: 'unit_id' },
                    { text: 'Precio de Venta', value: 'precio_venta' },
                    { text: 'Stock', value: 'stock' },
                    { text: 'Descripción', value: 'descripcion' },
                    { text: 'Registrado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                desserts: [],
                editedIndex: -1,
                editedItem: {
                    id: '',
                    nombre: '',
                    meta: '',
                    unit_id: '',
                    precio_compra:'',
                    precio_venta: '',
                    stock: '',
                    descripcion: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    meta: '',
                    unit_id: '',
                    precio_compra:'',
                    precio_venta: '',
                    stock: '',
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
                    confirmButtonText: 'Si, desactivalo!',
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
        },

        created () {
            this.getResults();
        },
    }
</script>
