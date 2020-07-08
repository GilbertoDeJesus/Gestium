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
                            <p style="text-align: center; font-size:25px; margin-bottom: -10px;"><strong>Listado de clientes registrados</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="11" sm="12" md="11">
                        <v-data-table
                            :headers="headers"
                            :items="desserts"
                            sort-by="calories"
                            class="elevation-4"
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
                                <v-row
                                    class="px-6 py-3"
                                    align="center"
                                    >
                                    <v-menu

                                        bottom
                                        right
                                        transition="slide-y-transition"
                                        origin="top left"
                                    >
                                        <template v-slot:activator="{ on }">
                                        <v-chip
                                            pill
                                            v-on="on"
                                        >
                                            <v-avatar left>
                                            <v-icon color="teal">mdi-account-circle</v-icon>
                                            </v-avatar>
                                            {{item.nombre | formatUpperCase}}
                                        </v-chip>
                                        </template>
                                        <v-card width="380">
                                        <v-list dark>
                                            <v-list-item>
                                            <v-list-item-avatar>
                                                <v-icon color="teal" large>mdi-account-circle</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.nombre | formatUpperCase}}</v-list-item-title>
                                                <v-list-item-subtitle>{{item.email}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-btn
                                                icon
                                                @click="menu = false"
                                                >
                                                <v-icon>mdi-close-circle</v-icon>
                                                </v-btn>
                                            </v-list-item-action>
                                            </v-list-item>
                                        </v-list>
                                        <v-list two-line>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-phone</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.telefono}}</v-list-item-title>
                                                <v-list-item-subtitle>Telefono</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-directions</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.direccion}}</v-list-item-title>
                                                <v-list-item-subtitle>Direccion</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-store</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.establecimiento}}</v-list-item-title>
                                                <v-list-item-subtitle>Establecimiento</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-calendar</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.created_at | formatDateTime | formatUpperCase}}</v-list-item-title>
                                                <v-list-item-subtitle>Fecha de registro</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                        </v-list>
                                        </v-card>
                                    </v-menu>
                                </v-row>
                            </template>
                            <template v-slot:item.direccion="{ item }">
                                {{item.direccion | formatUpperCase}}
                            </template>
                            <template v-slot:item.establecimiento="{ item }">
                               <v-chip color="orange" dark>
                                    <v-avatar left >
                                        <v-icon>store</v-icon>
                                    </v-avatar>{{item.establecimiento | formatUpperCase}}
                                </v-chip>
                            </template>

                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Clientes</v-toolbar-title>
                                <v-divider
                                class="mx-5"
                                inset
                                vertical
                                ></v-divider>
                                <v-text-field
                                    v-model="search"
                                    prepend-inner-icon="search"
                                    label="Buscar"
                                    hide-details
                                    style="background-color: #FFFFFE;"
                                    filled
                                    rounded
                                    single-line
                                    dense
                                    color="#ff5200"
                                    clearable
                                ></v-text-field>
                                <v-divider
                                class="mx-5"
                                inset
                                vertical
                                ></v-divider>

                                <v-dialog v-model="dialog" max-width="550px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>person_add</v-icon>Agregar</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">assignment_ind</i>
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
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.nombre"
                                                        :counter="45"
                                                        label="Nombre"
                                                        type="text"
                                                        prepend-icon="spellcheck"
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
                                                    :rules="[email_form()]"
                                                        v-model="editedItem.email"
                                                        label="E-mail"
                                                        prepend-icon="email"
                                                        type="text"
                                                        clearable
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
                                                        prepend-icon="phone"
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
                                                        :rules="[required('nombre')]"
                                                        v-model="editedItem.telefono"
                                                        :counter="15"
                                                        type="text"
                                                        prepend-icon="phone"
                                                        clearable
                                                        label="Telefono"
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.direccion"
                                                        :counter="45"
                                                        label="Dirección"
                                                        type="text"
                                                        prepend-icon="location_on"
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
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.establecimiento"
                                                        :counter="30"
                                                        label="Establecimiento"
                                                        type="text"
                                                        prepend-icon="store_mall_directory"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                        cols="12"
                                                        md="6"
                                                        sm="6"
                                                        >
                                                        <v-autocomplete

                                                            v-model="select_route"
                                                            :items="routes"
                                                            item-text="municipio"
                                                            item-value="id"
                                                            label="Rutas"
                                                            prepend-icon="local_shipping"
                                                            persistent-hint
                                                            return-object
                                                            ></v-autocomplete>
                                                        </v-col>

                                                </v-row>
                                            </v-container>
                                        </v-form>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn class="ma-2" outlined color="#ff5300" @click="close">Cancelar</v-btn>

                                    <v-btn dark class="ma-2" color="#ff5300" :disabled="!valid" @click="save">Guardar</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                                </v-card>
                                </v-dialog>
                            </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-btn color="secondary" style="min-width: 28px; padding: 0px 5.888889px;" x-small dark class="mr-1">
                                    <v-icon small @click="editItem(item)"> mdi-pencil </v-icon>
                                </v-btn>
                                <v-btn color="red" style="min-width: 28px; padding: 0px 5.888889px;" x-small dark >
                                    <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
                                </v-btn>
                            </template>
                            <template v-slot:no-data>
                            <v-alert
                                justify="center"
                                type="info"
                                color="#ff5400"
                                dense
                                border="left"
                                elevation="4">No hay Clientes registrados.</v-alert>
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
                select_route:{
                    id: '',
                    municipio: '',
                },
                headers: [
                    { text: 'Nombre', value: 'nombre'},
                    //{ text: 'Telefono', value: 'telefono' },
                    //{ text: 'Email', value: 'email' },
                    { text: 'Dirección', value: 'direccion' },
                    { text: 'Establecimiento', value: 'establecimiento' },
                    //{ text: 'Ruta', value: 'route_id' },
                    { text: 'Registrado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                desserts: [],
                routes:[],
                editedIndex: -1,
                editedItem: {
                    id: '',
                    nombre: '',
                    telefono: '',
                    email: '',
                    direccion: '',
                    establecimiento: '',
                    route_id: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    telefono: '',
                    email: '',
                    direccion: '',
                    establecimiento: '',
                    route_id: '',
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
                    const response = await axios.put(`api/customers/${this.editedItem.id}`, this.editedItem)
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
                            title: '¡Datos del Cliente actualizados!'
                        })
                    }
                } else {
                    const response = await axios.post('/api/customers',{
                        'nombre': this.editedItem.nombre,
                        'telefono': this.editedItem.telefono,
                        'direccion': this.editedItem.direccion,
                        'establecimiento': this.editedItem.establecimiento,
                        'email' : this.editedItem.email,
                        'status': this.editedItem.status,
                        'route_id': this.select_route.id,
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: 'Cliente registrado!'
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
                    title: '¿Estás seguro de desactivar este cliente?',
                    text: "Se cambiara el status de activo!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff5300',
                    cancelButtonColor: '#C1BCBB',
                    confirmButtonText: 'Si, desactivalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`api/customers/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Desactivado!',
                            'El cliente ha sido desactivado.',
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
                axios.get('api/customers')
                .then(response => {
                    this.desserts = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            getRoutesList(){
                this.dis=false
                axios.get('api/routes')
                .then(response => {
                    this.routes = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
        },

        created () {
            this.getResults();
            this.getRoutesList();
        },
    }
</script>
