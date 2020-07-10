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
                            <p style="text-align: center; font-size:28px; margin-bottom: -10px;"><strong>Listado de rutas activas</strong></p>
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

                                <v-dialog v-model="dialog" max-width="450px">
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
                                                    :rules="[required('nombre')]"
                                                        v-model="editedItem.municipio"
                                                        label="Municipio"
                                                        type="text"
                                                        clearable
                                                        prepend-icon="explore"
                                                        required
                                                        style="padding-top:2.5rem;"
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

                                <v-dialog v-model="dialogAddDeliverer" scrollable max-width="650px">

                                <v-card style="border-radius:20px;">
                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">person_add</i>
                                            </p>
                                            <p style="text-align: center; color:#ffffff; font-size:24px; margin-bottom: -10px;"><strong>Asignar Repartidores</strong></p>
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
                                                    sm="12">
                                                        <v-row>
                                                            <v-col
                                                            cols="12"
                                                            md="6"
                                                            sm="12"
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
                                                            <v-col
                                                            cols="12"
                                                            md="6"
                                                            sm="12"
                                                            >
                                                            <v-autocomplete
                                                                v-model="select"

                                                                :items="nombres"
                                                                item-text="nombre"
                                                                item-value="id"
                                                                label="Selecccione al repartidor"
                                                                prepend-icon="local_shipping"
                                                                persistent-hint
                                                                return-object
                                                                ></v-autocomplete>
                                                            </v-col>
                                                        </v-row>
                                                    </v-col>
                                                    <v-col
                                                    cols="12"
                                                    md="12"
                                                    sm="12">
                                                        <v-data-table
                                                            :headers="headersDeliverers"
                                                            :items="route"
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
                                                            </v-toolbar>
                                                            </template>
                                                            <template v-slot:item.created_at="{ item }">
                                                            {{item.created_at | formatDateTime | formatUpperCase}}
                                                            </template>
                                                        </v-data-table>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-form>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn color="secondary" style="min-width: 28px; padding: 0px 5.888889px;" x-small dark class="mr-1" @click="closeDeliverer">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn dark class="ma-2" color="#ff5300" :disabled="!valid"  @click="saveDeliverer">Guardar</v-btn>
                                </v-card-actions>
                                </v-card>
                                </v-dialog>
                            </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-btn color="secondary" style="min-width: 30px; min-height: 30px; padding: 0px 5.888889px;" x-small dark class="mr-1">
                                    <v-icon  @click="addDeliverers(item)"> person_add </v-icon>
                                </v-btn>
                                <v-btn color="red" style="min-width: 30px; min-height: 30px; padding: 0px 5.888889px;" x-small dark >
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
                loading: true,
                valid: false,
                edit_mode: false,
                id_Route: 0,
                numRep: 0,
                nameDeliverer: '',
                select: {
                    id: '',
                    nombre: '',
                },
                headers: [ /*align: 'start', sortable: false,*/
                    { text: 'Municipio', value: 'municipio' },
                    { text: 'Creado', value: 'created_at'},
                    { text: 'Num. de repartidores', value: 'deliverer.length'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
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
                return this.editedIndex === -1 ? 'Nueva Ruta' : 'Editar registro'
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
            addDeliverers (item){
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item) // Clone an object
                this.id_Route=this.editedItem.id
                this.getDelivererRoute()
                this.dialogAddDeliverer = true
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
            closeDeliverer () {
                this.dialogAddDeliverer=false
            },
            async save () {
                    const response = await axios.post('/api/routes',{
                        'municipio': this.editedItem.municipio,
                        'status': this.editedItem.status
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

            getResults() {
                axios.get('api/routes')
                .then(response => {
                    this.desserts = response.data;
                    console.log(response.data)
                    this.loading = false;


                });

            },
            getDeliverers(){
                axios.get('api/deliverers')
                .then(response => {
                    this.nombres = response.data;
                    console.log(response.data)
                    this.loading = false;
                });
            },
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
