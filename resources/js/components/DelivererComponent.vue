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
                            <p style="text-align: center; font-size:28px; font-weight:700; margin-bottom: -10px;"><strong>Listado de repartidores activos</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="12" sm="12" md="11">
                        <v-data-table
                            :headers="headers"
                            :items="deliverers"
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
                            <template v-slot:item.telefono="{ item }">
                               <v-chip>
                                    <v-avatar left >
                                        <v-icon color="green">mdi-phone</v-icon>
                                    </v-avatar>{{item.telefono | formatUpperCase}}
                                </v-chip>
                            </template>
                        <!--    <template v-slot:item.nombre="{ item }">
                                {{item.nombre | formatUpperCase}}
                            </template> -->
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
                                            <v-list-item-avatar color="teal">
                                                <v-icon color="white" large>mdi-account-circle</v-icon>
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
                                                <v-icon color="indigo">mdi-calendar-text</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.fecha_nacimiento}}</v-list-item-title>
                                                <v-list-item-subtitle>Fecha de nacimiento</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-calendar-blank</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.fecha_contratacion}}</v-list-item-title>
                                                <v-list-item-subtitle>Fecha de contratacion</v-list-item-subtitle>
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
                            <template v-slot:item.fecha_nacimiento="{ item }">
                                {{item.fecha_nacimiento |  formatDateTimeShort | formatUpperCase}}
                            </template>
                            <template v-slot:item.fecha_contratacion="{ item }">
                                {{item.fecha_contratacion |  formatDateTimeShort | formatUpperCase}}
                            </template>
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
                                <v-dialog v-model="dialog" max-width="650px" persistent>
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>person_add</v-icon>Nuevo Repartidor</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">local_shipping</i>
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
                                                    md="4"
                                                    sm="4"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(3)]"
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
                                                        :rules="[required('Apellido paterno'), minimum_length(3)]"
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
                                                        :rules="[required('Apellido materno'), minimum_length(3)]"
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
                                                        v-model="editedItem.email"
                                                        label="E-mail"
                                                        type="text"
                                                        prepend-icon="email"
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
                                                        prepend-icon="phone"
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="6"
                                                        v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                        :rules="[required('Telefono'), minimum_length(8)]"
                                                        v-model="editedItem.telefono"
                                                        :counter="15"
                                                        type="text"
                                                        clearable
                                                        prepend-icon="phone"
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
                                                            v-model="editedItem.fecha_nacimiento"
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
                                                        color="#fd2d21"
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
                                                            v-model="editedItem.fecha_contratacion"
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
                                                        color="#fd2d21"
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
                                    <v-btn outlined color="#ff5300" @click="close">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
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
                //Con el comando date se obtiene la fecha actual y se crea una nueva fecha
                //aplicando un formato legible para el usuario
                date1: new Date().toISOString().substr(0, 10),
                menu1:false,
                menu2:false,
                loading: true,
                valid: false,
                edit_mode: false,
                 //Se asignan los títulos de las columnas de la tabla principal,
                 //así como su valor correspondiente.
                headers: [
                    { text: 'Nombre', value: 'nombre'} , /*align: 'start', sortable: false,*/
                    { text: 'Telefono', value: 'telefono' },
                    { text: 'Registrado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                deliverers: [],
                editedIndex: -1,
                 //Se crean los objetos a utilizar
                //Se crean  e indican los elementos que contendra el objeto y su valor predeterminado
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
                }
             }
        },

        computed: {
            //Verificamos si el formulario es de creación o actualización y dependiendo de esto se le asigna un título
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
             //Llamamod al objeto a editar
            editItem (item) {
                //IndexOf nos permite  buscamor la posicion de este dentro del arreglo de "deliverers"
                this.editedIndex = this.deliverers.indexOf(item)
                // Clonamos el objeto
                this.editedItem = Object.assign({}, item)
                //Se abre el dialogo(formulario) que permite editar la info. del repartidor
                this.dialog = true
                this.edit_mode = true
            },
            close () {
                //Cuando de cancela la operación de editar se resetea el objeto
                this.$refs.form.reset()
                //Cerramos el dialogo que estaba abierto
                this.dialog = false
                this.$nextTick(() => {
                 //Se restablecen los valores iniciales del objeto
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                })
                if (this.edit_mode == true) {
                    this.edit_mode = false
                }
            },
            async save () {
                //Comprobamos si estamos agregando o editando un repartidor
                if (this.editedIndex > -1) {
                    //Cuando se selecciona la opción de guardar se insertar los nuevos
                    //valores ingresados en el objeto de items (actualizamos)
                    const response = await axios.put(`api/deliverers/${this.editedItem.id}`, this.editedItem)
                    .catch(error => console.log(error));
                    //Si algun dato es erroneo se muestra un mensaje de alerta
                    if (response.data.validation_errors) {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Ocurrió un error, vuelve a intentarlo!'
                        });
                        console.log(response.data);
                         //Si los valores son correctos se muestra un mensaje de exito
                    } else {
                        //Ejecutamos el método "getResults"
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Datos del repartidor actualizados!'
                        })
                    }
                } else {
                     //Enviamos los datos a nuestro controlador para insertarlo en la bd
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
            //Eliminamos de la tabla al repartidor seleccionado y cambiamos su "status"
            async deleteItem (item) {
                this.editedIndex = this.deliverers.indexOf(item)
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

            //obtenemos en el arreglo "deliverers" lo que devulve la consulta del controlador solicitada
            getResults() {
                axios.get('api/deliverers')
                .then(response => {
                    this.deliverers = response.data;
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
