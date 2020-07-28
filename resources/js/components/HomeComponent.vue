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
                            <p style="text-align: center; font-size:25px; font-weight:700; margin-bottom: -10px;"><strong>Listado de Usuarios registrados</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="10" sm="12" md="10">
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

                            <template v-slot:item.name="{ item }">
                               <v-chip class="ma-2">
                                    <v-avatar left >
                                        <v-icon color="teal">mdi-account-circle</v-icon>
                                    </v-avatar>{{item.name | formatUpperCase}}
                                </v-chip>
                            </template>
                            <template v-slot:item.created_at="{ item }">
                                {{item.created_at | formatDateTime | formatUpperCase}}
                            </template>
                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold" color="#007879">Usuarios</v-toolbar-title>
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

                                <v-dialog v-model="dialog" max-width="420px" persistent>
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>group_add</v-icon>Agregar</v-btn>
                                </template>
                                    <v-card style="border-radius:20px;">

                                            <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                                <v-col
                                                cols="12"
                                                md="12"
                                                sm="12">
                                                    <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                        <i class="material-icons" style="font-size:85px;">account_box</i>
                                                    </p>
                                                    <p style="text-align: center; color:#ffffff; font-size:24px; margin-bottom: -10px;"><strong>{{ formTitle }}</strong></p>
                                                </v-col>
                                            </v-container>

                                            <v-card-text style="padding: 5px 40px 0px; border-radius:20px;">
                                                <v-container style="padding-bottom:0px;">
                                                    <v-form v-model="valid" ref="form">
                                                        <v-container style="padding: 0px;">
                                                            <v-row>

                                                                <v-col
                                                                cols="12"
                                                                md="12"
                                                                sm="12">
                                                                    <v-text-field
                                                                    :rules="[required('nombre'), minimum_length(4)]"
                                                                    v-model="editedItem.name"
                                                                    :counter="15"
                                                                    label="Nombre"
                                                                    type="text"
                                                                    prepend-icon="account_circle"
                                                                    clearable
                                                                    required></v-text-field>
                                                                </v-col>

                                                                <v-col
                                                                cols="12"
                                                                md="12"
                                                                sm="12"
                                                                >
                                                                    <v-text-field
                                                                    :rules="[required('email'), email_form()]"
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
                                                                md="12"
                                                                sm="12"
                                                                v-if="edit_mode"
                                                                >
                                                                <v-text-field
                                                                    v-model="editedItem.password"
                                                                    :counter=true
                                                                    type="password"
                                                                    clearable
                                                                    label="Nueva contraseña"
                                                                    prepend-icon="vpn_key"
                                                                    hint="*Solo si está seguro, min. 8 caracteres"
                                                                    persistent-hint
                                                                ></v-text-field>
                                                                </v-col>

                                                                <v-col
                                                                cols="12"
                                                                md="12"
                                                                sm="12"
                                                                    v-if="!edit_mode"
                                                                >
                                                                <v-text-field
                                                                    :rules="[required('password'), minimum_length(8)]"
                                                                    v-model="editedItem.password"
                                                                    :counter="15"
                                                                    type="password"
                                                                    clearable
                                                                    label="Contraseña"
                                                                    prepend-icon="vpn_key"
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
                                                <v-btn dark class="ma-2" color="#ff5300" :disabled="!valid" @click="save">Guardar</v-btn>
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
                //Se asignan los titulos de las columnas de la tabla, asi como su valor correspondiente
                headers: [
                    { text: 'Nombre', value: 'name' }, /*align: 'start', sortable: false,*/
                    { text: 'Email', value: 'email' },
                    { text: 'Creado', value: 'created_at' },
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                desserts: [],
                editedIndex: -1,
                //Se crean los objetos a utilizar
                //Se crean indican los elementos que contendra el objeto y su valor predeterminado
                editedItem: {
                    id: '',
                    name: '',
                    email: '',
                    created_at: '',
                    password: ''
                },
                defaultItem: {
                    id: '',
                    name: '',
                    email: '',
                    created_at: '',
                    password: ''
                },
                required( propertyName ) {
                    return v => v && v.length > 0 || `Debes ingresar un ${propertyName}`
                    //Se verifica que se ingrese el dato solicitado y no se deje vacio el campo
                },
                minimum_length( length ) {
                    return v => v && v.length >= length || `Longitud mínima de ${length} caracteres`
                    //Se verifica que la cantidad de caracteres ingresados no sea menor a lo que se especifico
                },
                email_form() {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return v => v && regex.test(v) || `Debes ingresar un email valido`
                    //Mediante el uso de expresiones regulares se verifica que el dato ingresado sea un Email
                }
             }
        },

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Nuevo registro' : 'Editar registro'
                //Se verifica si el formulario es de creacion o actualizacion y dependiendo de esto se le asiga un titulo
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        methods: {
            editItem (item) {
                this.editedIndex = this.desserts.indexOf(item) // Se busca la posicion del objeto en el arreglo
                this.editedItem = Object.assign({}, item) // Se clona el objeto indicado
                this.dialog = true // Se muestra el dialogo que permite ingresar los datos solicitados
                this.edit_mode = true // Se habilita el modo de edicion
            },
            initialize(){
                this.$forceUpdate();
            },
            close () {
                this.$refs.form.reset()
                this.dialog = false //Se oculta el dialogo de edicion
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem) //Se restablecen los valores por defecto del objeto
                this.editedIndex = -1
                })
                if (this.edit_mode == true) {
                    this.edit_mode = false //Se desactiva el modo de edicion
                }
            },
            async save () {
                //Se verifica si se esta en modo de edicion o creacion
                if (this.editedIndex > -1) {
                    const response = await axios.put(`api/users/${this.editedItem.id}`, this.editedItem)
                    .catch(error => console.log(error)); //Se cargan en el dialogo los datos encontrados indicando el id para poder editarlos
                    if (response.data.validation_errors) {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Ocurrió un error, vuelve a intentarlo!'
                        });//Si la actualizacion falla se muestra un mensaje de error
                        console.log(response.data);
                    } else {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Datos del usuario actualizados!'
                        })//Si la actualizacion de los datos es exitosa se muestra un mensaje informando el exito de la operacion
                    }
                } else {
                    //Si se encuentra en modo de creacion mediante la funcion post se indica la ruta del controlador a utilizar
                    //Y se pasan los datos que ingreso el usuario
                    const response = await axios.post('/api/users',{
                        'name': this.editedItem.name,
                        'email' : this.editedItem.email,
                        'password': this.editedItem.password
                    }).catch(error => console.log("Error: " + error));//Si hay algun error al hacer el registro se muestra cual es en la consola

                    if (response) {
                        //Si no se presenta ningun error al hacer el registro se muestra un mensaje de operacion exitosa
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Usuario registrado!'
                        })
                        console.log(response.data);
                    }
                }

                this.close();//Cierra el formulario
            },
            async deleteItem (item) {
                this.editedIndex = this.desserts.indexOf(item)//Para eliminar un objeto se indica la posicion que este ocupa en el arreglo
                this.editedItem = Object.assign({}, item) //Se clona el objeto seleccionado
                Swal.fire({
                    //Se crea un mensaje de confirmacion estableciendo sus componentes y el diseño de estos
                    title: '¿Estás seguro de eliminar este usuario?',
                    text: "No podrás revertir esta acción!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff5300',
                    cancelButtonColor: '#C1BCBB',
                    confirmButtonText: 'Si, elimínalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    //Se hace una comprobacion de las opciones disponibles para el usuario
                    if (result.value) {
                        //Si se confirma la operacion se remueve el registro de la Base de datos
                        //El registro es removido mediante un controlador especifico al cual se le indica el id del registro
                        axios.delete(`api/users/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Eliminado!',
                            'El usuario ha sido eliminado.', //Se muestra un mensaje de operacion exitosa
                            'success'
                            )
                        }).catch(() => {
                            Swal('Ocurrió un error', 'Algo salió mal con el servidor.', 'warning');//Se muestra un mensaje de error si la operacion falla
                        });
                    } else {
                        this.editedItem = Object.assign({}, this.defaultItem)//Si se cancela la operacion se restablecen los valores del objeto seleccionado
                    }
                });
            },

            getResults() {
                //Se obtienen todos los registros de la tabla mediante una consulta a la Base de datos
                axios.get('api/users')
                .then(response => {
                    this.desserts = response.data;//Se cargan todos los registros obtenidos en la consulta en un arreglo
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
