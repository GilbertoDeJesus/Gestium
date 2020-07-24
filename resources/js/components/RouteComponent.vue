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
                            <p style="text-align: center; font-size:28px; font-weight:700; margin-bottom: -10px;"><strong>Listado de rutas activas</strong></p>
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
                            <template v-slot:item.created_at="{ item }">
                               {{item.created_at | formatDateTime | formatUpperCase}}
                            </template>
                            <template v-slot:item.municipio="{ item }">
                                <v-chip>
                                    <v-avatar left color="primary">
                                        <v-icon color="light-green accent-4">mdi-earth</v-icon>
                                    </v-avatar>{{item.municipio | formatUpperCase}}
                                </v-chip>
                            </template>
                            <template v-slot:item.deliverer.length="{ item }">
                                <v-chip color="orange" dark>
                                    <v-avatar left>
                                        <v-icon>mdi-account-multiple</v-icon>
                                    </v-avatar>{{item.deliverer.length}}
                                </v-chip>
                            </template>

                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Rutas</v-toolbar-title>
                                <v-divider
                                class="mx-6"
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
                                class="mx-6"
                                inset
                                vertical
                                ></v-divider>

                                <v-dialog v-model="dialog" max-width="400px" persistent>
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>mdi-plus-network</v-icon>Nueva Ruta</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:65px;">directions</i>
                                            </p>
                                            <p style="text-align: center; color:#ffffff; font-size:18px; margin-bottom: -10px;"><strong>Agregar Ruta</strong></p>
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
                                                    sm="12"
                                                    >
                                                    <v-text-field
                                                        v-model="editedItem.municipio"
                                                        label="Municipio"
                                                        type="text"
                                                        clearable
                                                        prepend-inner-icon="explore"
                                                        required
                                                        style="padding-top:1.5rem;"
                                                    ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        >
                                                        <v-autocomplete
                                                            v-model="select"

                                                            :items="nombres"
                                                            item-text="nombre"
                                                            item-value="id"
                                                            label="Selecccione al repartidor"

                                                            clearable
                                                            prepend-inner-icon="local_shipping"
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
                                    <v-btn class="ma-2" outlined color="#ff5300" @click="close">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn dark class="ma-2" color="#ff5300" :disabled="!valid"  @click="save">Guardar</v-btn>
                                </v-card-actions>
                                </v-card>
                                </v-dialog>

                                <v-dialog v-model="dialogAddDeliverer" scrollable max-width="900px" persistent>

                                <v-card style="border-radius:10px; height:100%; margin: 0; display: flex; flex-direction: column;">


                                <v-card-text style="padding-bottom:0px; height:100%; padding-left:12px;" >

                                        <v-form v-model="valid" ref="form" style="height:100%; margin-bottom: 0px;">

                                                <v-row>
                                                    <v-col
                                                    cols="12"
                                                    md="5"
                                                    sm="12"
                                                    style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                                    <v-container class="align-items-center">
                                                     <v-container class="align-items-center">
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12">
                                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                                <i class="material-icons" style="font-size:65px;">person_add</i>
                                                            </p>
                                                            <p style="text-align: center; color:#ffffff; font-size:18px; margin-bottom: -10px;">Asignar Repartidores</p>
                                                        </v-col>
                                                    </v-container>
                                                        <v-row>
                                                            <v-col
                                                            cols="12"
                                                            md="12"
                                                            sm="12"
                                                            >
                                                            <v-text-field
                                                            :rules="[required('nombre')]"
                                                                v-model="editedItem.municipio"
                                                                dark
                                                                label="Municipio"
                                                                type="text"
                                                                clearable
                                                                prepend-icon="explore"
                                                                required
                                                            ></v-text-field>
                                                            </v-col>
                                                            <v-col
                                                            cols="12"
                                                            md="12"
                                                            sm="12"
                                                            >
                                                            <v-autocomplete
                                                                v-model="select"
                                                                dark
                                                                :items="nombres"
                                                                item-text="nombre"
                                                                item-value="id"
                                                                label="Selecccione al repartidor"
                                                                prepend-icon="local_shipping"
                                                                persistent-hint
                                                                return-object
                                                                ></v-autocomplete>
                                                            </v-col>
                                                            <v-col
                                                            cols="12"
                                                            md="6"
                                                            sm="6">
                                                                <v-btn outlined color="#fff" @click="closeDeliverer">Cancelar</v-btn>
                                                            </v-col>
                                                            <v-col
                                                            cols="12"
                                                            md="6"
                                                            sm="6">
                                                                <v-btn color="#fff" style="float: right; color: #ff5200;" :disabled="!valid"  @click="saveDeliverer">Guardar</v-btn>
                                                            </v-col>
                                                        </v-row>
                                                    </v-container>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="7"
                                                    sm="12">
                                                    <v-container class="align-items-center">
                                                        <v-col
                                                        cols="12"
                                                        md="12"
                                                        sm="12"
                                                        style="padding-bottom: 0px;">
                                                            <p style="text-align: center; font-size:28px; margin-bottom: -10px;"><strong>Listado de repartidores</strong></p>
                                                            <v-container style="margin-top:1.5rem;" >

                                                                <v-spacer></v-spacer>
                                                                    <v-text-field
                                                                        v-model="searchD"
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

                                                            </v-container>
                                                        </v-col>

                                                    </v-container>
                                                    <v-container class="align-items-center">

                                                        <v-data-table
                                                            :headers="headersDeliverers"
                                                            :items="route"
                                                            sort-by="calories"
                                                            fixed-header
                                                            class="elevation-3"
                                                            :search="searchD"
                                                            :loading="loading" loading-text="Estamos cargando tu información"
                                                            :items-per-page="5"
                                                            :footer-props="{
                                                                'items-per-page-options': [5, 10, 20]
                                                            }">
                                                            <template v-slot:item.created_at="{ item }">
                                                            {{item.created_at | formatDateTime | formatUpperCase}}
                                                            </template>
                                                        </v-data-table>
                                                    </v-container>
                                                    </v-col>
                                                </v-row>

                                        </v-form>

                                </v-card-text>
                                </v-card>
                                </v-dialog>
                            </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-btn color="secondary" style="min-width: 20px; min-height: 25px; padding: 0px 4.888889px;" x-small dark class="mr-1">
                                    <v-icon  @click="addDeliverers(item)"> person_add </v-icon>
                                </v-btn>
                                <v-btn color="red" style="min-width: 20px; min-height: 25px; padding: 0px 4.888889px;" x-small dark >
                                    <v-icon  @click="deleteItem(item)"> mdi-cancel </v-icon>
                                </v-btn>
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
                dialogAddDeliverer: false,
                search: '',
                searchD: '',
                loading: true,
                valid: false,
                edit_mode: false,
                id_Route: 0,
                numRep: 0,
                nameDeliverer: '',
                //Declaramos las propiedades del select
                select: {
                    id: '',
                    nombre: '',
                },
                //Se asignan los títulos de las columnas de la tabla principal,
                 //así como su valor correspondiente.
                headers: [ /*align: 'start', sortable: false,*/
                    { text: 'Municipio', value: 'municipio' },
                    { text: 'Creado', value: 'created_at'},
                    { text: 'Num. de repartidores', value: 'deliverer.length'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                //Se asignan los títulos de las columnas de la tabla que se muestra en el dialogo,
                 //así como su valor correspondiente.
                headersDeliverers: [
                    { text: 'Nombre', value: 'nombre'},
                    { text: 'Registrado', value: 'created_at'}
                ],
                desserts: [],
                nombres:[],
                route: [
                    {id: ''},
                    {nombre: ''},
                    {created_at: ''},
                ],
                editedIndex: -1,
                //Se crean los objetos a utilizar
                //Se crean  e indican los elementos que contendra el objeto y su valor predeterminado
                editedItem: {
                    id: '',
                    nombre: '',
                    municipio: '',
                    created_at: '',
                    status: '',
                    numDev: ''
                },
                defaultItem: {
                    id: '',
                    nombre: '',
                    municipio: '',
                    created_at: '',
                    status: '',
                    numDev: ''
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

             }
        },

        computed: {
            //Verificamos si el formulario es de creación o actualización y dependiendo de esto se le asigna un título
            formTitle () {
                return this.editedIndex === -1 ? 'Nueva Ruta' : 'Editar registro'
            },

        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        methods: {
             //Llamamos al objeto a editar
            editItem (item) {
                //IndexOf nos permite  buscamos la posición de este dentro del arreglo de "routes"
                this.editedIndex = this.desserts.indexOf(item)
                 // Clonamos el objeto
                this.editedItem = Object.assign({}, item)
                //Se abre el dialogo(formulario) que permite asignar un repartidor a una ruta
                this.dialog = true
                this.edit_mode = true
            },

            addDeliverers (item){
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.id_Route=this.editedItem.id
                //llamamos al método "getDelivererRoute"
                this.getDelivererRoute()
                //abrimos el dialogo para añadir un nuevo repartidor
                this.dialogAddDeliverer = true
            },
            close () {
                //Cuando de cancela la operación de editar se resetea el objeto
                //this.$refs.form.reset()
                this.route = []
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
            //Cerramos el dialogo para asignar nuevos repartidores a una ruta
            closeDeliverer () {
                this.dialogAddDeliverer = false
                this.editedItem.municipio = ''
                this.select = [0]
            },
            async save () {
                 //vamos a crear una ruta y asignar una ruta enviando nuestros datos de los formularios
                 //a la función indicada del controlador solicitado
                    const response = await axios.post('/api/routes',{
                        'municipio': this.editedItem.municipio,
                        'status': this.editedItem.status,
                        'deliverer_id': this.select.id
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: '¡Ruta registrada!'
                        })
                        console.log(response.data);
                    }


                this.close();
            },
            async saveDeliverer () {
                //comprobamos que el repartidor seleccionado no está asigando a la ruta que elegimos
                for (let index = 0; index < this.route.length; index++) {
                    if (this.route[index].nombre == this.select.nombre) {
                        this.nameDeliverer = this.route[index].nombre
                        break
                    }

                }
                if (this.select.nombre == this.nameDeliverer) {
                        //confirm('Este repartidor ya esta registrado')
                        Swal.fire({
                        title: 'Alerta',
                        text: "Este repartidor ya esta registrado!",
                        type: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Entendido'
                        });
                        this.nameDeliverer=''
                    }
                    else{
                        //Enviamos la lista de los nuevos repartidores para asignarlos a la ruta elegida
                        const response = await axios.post('/api/createdeliverer_route',{
                        'id':this.editedItem.id,
                        'deliverer_id': this.select.id
                        }).catch(error => console.log("Error: " + error));
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
                                title: '¡Repartidores agregados!'
                            })
                        }
                        this.dialogAddDeliverer=false
                        this.nameDeliverer=''
                    }
                    this.nameDeliverer=''


            },
            //Eliminamos de la tabla a la ruta seleccionada y cambiamos su "status"
            async deleteItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                Swal.fire({
                    title: '¿Está seguro de desactivar esta ruta?',
                    text: "Esta acción no es reversible!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, desactivalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`api/routes/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Desactivada!',
                            'La ruta ha sido desactivada.',
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

            //Obtenemos todas las rutas que devuelve la consulta de nuestro controlador solicitado
            getResults() {
                axios.get('api/routes')
                .then(response => {
                    //Lo guardamos en el arreglo
                    this.desserts = response.data;
                    console.log(response.data)
                    this.loading = false;


                });

            },
            //Obtenemos todos los reprtiores con estado activo
            getDeliverers(){
                axios.get('api/deliverers')
                .then(response => {
                    this.nombres = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
            //obtenemos de nuestro controlador los repartidores que tiene una ruta
            //y lo guardamos en el arreglo "route"
            getDelivererRoute(){
                axios.get(`api/getDelivererList/${this.id_Route}`)
                .then(response => {
                    this.route = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },

        },

        created () {
            this.getResults();
            this.getDeliverers();
            this.getDelivererRoute();
        },
    }
</script>
