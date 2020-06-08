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
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Repartidores</v-toolbar-title>
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

                                <v-dialog v-model="dialog" max-width="650px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff5300" dark class="mb-2" v-on="on">Nuevo Repartidor</v-btn>
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
                                                    md="4"
                                                    sm="4"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.nombre"
                                                        :counter="25"
                                                        label="Nombre"
                                                        type="text"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="4"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.aPaterno"
                                                        :counter="15"
                                                        label="Apellido paterno"
                                                        type="text"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="4"
                                                    sm="4"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.aMaterno"
                                                        :counter="15"
                                                        label="Apellido materno"
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
                                                    :rules="[required('email'), email_form()]"
                                                        v-model="editedItem.email"
                                                        label="E-mail"
                                                        type="text"
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
                                                        v-model="editedItem.telefono"
                                                        :counter=true
                                                        type="text"
                                                        clearable
                                                        label="Telefono"
                                                        hint="*Solo si está seguro, min. 8 caracteres"
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
                                                        :rules="[required('nombre'), minimum_length(8)]"
                                                        v-model="editedItem.telefono"
                                                        :counter="15"
                                                        type="text"
                                                        clearable
                                                        label="Telefono"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-dialog
                                                        ref="dialog"
                                                        v-model="menu1"
                                                        :return-value.sync="date1"
                                                        persistent
                                                        width="290px"
                                                    >
                                                        <template v-slot:activator="{ on }">
                                                        <v-text-field
                                                            v-model="date1"
                                                            label="Fecha de nacimiento"
                                                            prepend-icon="event"
                                                            readonly
                                                            v-on="on"
                                                        ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                        :rules="[required('nombre')]"
                                                        v-model="editedItem.fecha_nacimiento"
                                                        locale="mx"
                                                        type="date"
                                                        format="YYYY-MM-dd"
                                                        required
                                                        @input="menu1 = false"
                                                    ></v-date-picker>
                                                    </v-dialog>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-dialog
                                                        ref="dialog"
                                                        v-model="menu2"
                                                        :return-value.sync="date1"
                                                        persistent
                                                        width="290px"
                                                    >
                                                        <template v-slot:activator="{ on }">
                                                        <v-text-field
                                                            v-model="date1"
                                                            label="Fecha de contratacion"
                                                            prepend-icon="event"
                                                            readonly
                                                            v-on="on"
                                                        ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                        :rules="[required('nombre')]"
                                                        v-model="editedItem.fecha_contratacion"
                                                        locale="mx"
                                                        format="YYYY-MM-dd"
                                                        required
                                                        @input="menu2 = false"
                                                    ></v-date-picker>
                                                    </v-dialog>

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
                                elevation="4">No hay repartidores registrados.</v-alert>
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
                menu1:false,
                menu2:false,
                loading: true,
                valid: false,
                edit_mode: false,
                headers: [
                    { text: 'Nombre', value: 'nombre'}, /*align: 'start', sortable: false,*/
                    { text: 'Telefono', value: 'telefono' },
                    { text: 'Email', value: 'email' },
                    { text: "Fecha de nacimiento", value: "fecha_nacimiento"},
                    { text: "Fecha de contratación", value: "fecha_contratacion"},
                    { text: 'Registrado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                desserts: [],
                editedIndex: -1,
                editedItem: {
                    id: '',
                    nombre: '',
                    aPaterno: '',
                    aMaterno: '',
                    telefono: '',
                    email: '',
                    fecha_nacimiento: '',
                    fecha_contratacion: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    aPaterno: '',
                    aMaterno: '',
                    telefono: '',
                    email: '',
                    fecha_nacimiento: '',
                    fecha_contratacion: '',
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
                    const response = await axios.put(`api/deliverers/${this.editedItem.id}`, this.editedItem)
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
                            title: '¡Datos del repartidor actualizados!'
                        })
                    }
                } else {
                    const response = await axios.post('/api/deliverers',{
                        'nombre': this.editedItem.nombre,
                        'aPaterno': this.editedItem.aPaterno,
                        'aMaterno': this.editedItem.aMaterno,
                        'telefono': this.editedItem.telefono,
                        'email': this.editedItem.email,
                        'fecha_nacimiento': this.editedItem.fecha_nacimiento,
                        'fecha_contratacion': this.editedItem.fecha_contratacion,
                        'status': this.editedItem.status
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: 'Repartidor registrado!'
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
                    title: '¿Estás seguro de desactivar este repartidor?',
                    text: "Se cambiara el status de activo!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff5300',
                    cancelButtonColor: '#C1BCBB',
                    confirmButtonText: 'Si, desactivalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`api/deliverers/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Desactivado!',
                            'El repartidor ha sido desactivado.',
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
                axios.get('api/deliverers')
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
