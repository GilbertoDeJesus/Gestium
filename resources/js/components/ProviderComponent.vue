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
                            <p style="text-align: center; font-size:28px; font-weight:700; margin-bottom: -10px;"><strong>Listado de proveedores activos</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="10" sm="12" md="10">
                        <v-data-table
                            :headers="headers"
                            :items="providers"
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
                               <v-chip class="ma-2">
                                    <v-avatar left >
                                        <v-icon color="teal">mdi-account-circle</v-icon>
                                    </v-avatar>{{item.nombre | formatUpperCase}}
                                </v-chip>
                            </template>
                            <template v-slot:item.email="{ item }">
                               <v-chip class="ma-1" color="red" dark>
                                    <v-avatar left>
                                        <v-icon color="white">mdi-email</v-icon>
                                    </v-avatar>{{item.email}}
                                </v-chip>
                            </template>

                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Proveedores</v-toolbar-title>
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
                                    style="background-color: #FFFFFE;"
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
                                <v-dialog v-model="dialog" max-width="400px">
                                <template v-slot:activator="{ on }">
                                     <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>group_add</v-icon>Nuevo Proveedor</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">store</i>
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
                                                    <v-text-field
                                                        :rules="[required('nombre'), minimum_length(4)]"
                                                        v-model="editedItem.nombre"
                                                        :counter="15"
                                                        label="Nombre"
                                                        type="text"
                                                        prepend-icon="spellcheck"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="12"
                                                    sm="6"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('email'), email_form()]"
                                                        v-model="editedItem.email"
                                                        label="E-mail"
                                                        type="text"
                                                        clearable
                                                        prepend-icon="email"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="12"
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
                                                         prepend-icon="phone"
                                                    ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                    cols="12"
                                                    md="12"
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
                                                         prepend-icon="phone"
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
                                <v-btn
                                color="secondary"
                                style="min-width: 28px; padding: 0px 5.888889px;"
                                x-small
                                dark
                                class="mr-1"
                                title="Editar registro de proveedor">
                                    <v-icon small @click="editItem(item)"> mdi-pencil </v-icon>
                                </v-btn>
                                <v-btn
                                color="red"
                                style="min-width: 28px; padding: 0px 5.888889px;"
                                x-small
                                dark
                                title="Eliminar proveedor">
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
                                elevation="4">No hay proveedores registrados.</v-alert>
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
                //Se asignan los títulos de las columnas de la tabla principal,
                 //así como su valor correspondiente.
                headers: [
                    { text: 'Nombre', value: 'nombre' }, /*align: 'start', sortable: false,*/
                    { text: 'Telefono', value: 'telefono' },
                    { text: 'Email', value: 'email' },
                    { text: 'Registrado', value: 'created_at'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                providers: [],
                editedIndex: -1,
                //Se crean los objetos a utilizar
                //Se crean  e indican los elementos que contendra el objeto y su valor predeterminado
                editedItem: {
                    id: '',
                    nombre: '',
                    telefono: '',
                    email: '',
                    status: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    telefono: '',
                    email: '',
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

        //Llamamos al objeto a editar
        methods: {
            editItem (item) {
                //IndexOf nos permite  buscamor la posicion de este dentro del arreglo de "providers"
                this.editedIndex = this.providers.indexOf(item)
                // Clonamos el objeto
                this.editedItem = Object.assign({}, item)
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
                //Comprobamos si estamos agregando o editando un proveedor
                if (this.editedIndex > -1) {
                    //Cuando se selecciona la opción de guardar se insertar los nuevos
                    //valores ingresados en el objeto de items (actualizamos)
                    const response = await axios.put(`api/providers/${this.editedItem.id}`, this.editedItem)
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
                            title: '¡Datos del proveedor actualizados!'
                        })
                    }
                } else {
                     //Enviamos los datos a nuestro controlador para insertarlo en la bd
                    const response = await axios.post('/api/providers',{
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
            //Eliminamos de la tabla al proveedores seleccionado y cambiamos su "status"
            async deleteItem (item) {
                this.editedIndex = this.providers.indexOf(item)
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
                        axios.delete(`api/providers/${this.editedItem.id}`).then(() => {
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

            //obtenemos en el arreglo "providers" lo que devulve la consulta del controlador solicitada
            getResults() {
                axios.get('api/providers')
                .then(response => {
                    this.providers = response.data;
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
