<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row justify="center">
                    <v-col cols="10" sm="8" md="10">
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
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Rutas</v-toolbar-title>
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

                                <v-dialog v-model="dialog" max-width="400px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff5300" dark class="mb-2" v-on="on">Nueva Ruta</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">directions</i>
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
                                                    :items="nombres"
                                                    v-model="editedItem.nombre"
                                                    label="Seleccione el repartidor"
                                                    item-text="title"
                                                    prepend-icon="local_shipping"
                                                    >

                                                    </v-select>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="12"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('nombre')]"
                                                        v-model="editedItem.municipio"
                                                        label="Municipio"
                                                        type="text"
                                                        clearable
                                                        prepend-icon="explore"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
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
                                elevation="4">No se ha creado ninguna ruta.</v-alert>
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
                    { text: 'Repartidor', value: 'nombre' }, /*align: 'start', sortable: false,*/
                    { text: 'Municipio', value: 'municipio' },
                    { text: 'Creado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                desserts: [],
                editedIndex: -1,
                editedItem: {
                    id: '',
                    nombre: '',
                    municipio: '',
                    created_at: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    municipio: '',
                    created_at: '',
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
                    const response = await axios.put(`api/routes/${this.editedItem.id}`, this.editedItem)
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
                            title: '¡Datos del proveedor actualizados!'
                        })
                    }
                } else {
                    const response = await axios.post('/api/routes',{
                        'nombre': this.editedItem.nombre,
                        'telefono': this.editedItem.telefono,
                        'email' : this.editedItem.email,
                        'status': this.editedItem.status
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Proveedor registrado!'
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
                    title: '¿Estás seguro de desactivar este proveedor?',
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
                            'El proveedor ha sido desactivado.',
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
                axios.get('api/routes')
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
