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
                            <p style="text-align: center; font-size:25px; margin-bottom: -10px;"><strong>Listado de creditos aprobados</strong></p>
                         </v-col>
                    </v-container>
                    <v-col cols="12" sm="12" md="11">
                        <v-data-table
                            :headers="headers"
                            :items="credits"
                            sort-by="calories"
                            class="elevation-3"
                            :search="search"
                            :loading="loading" loading-text="Estamos cargando tu información"
                            :items-per-page="6"
                            :footer-props="{
                                'items-per-page-options': [7, 10, 20]
                            }">
                            <template v-slot:item.fecha="{ item }">
                                {{item.fecha |  formatDateTimeShort | formatUpperCase}}
                            </template>

                            <template v-slot:item.monto="{item}">
                                <v-chip color="orange" dark>
                                    <v-avatar left color="green">
                                        <v-icon color="white">monetization_on</v-icon>
                                    </v-avatar>{{item.monto}}
                                </v-chip>

                            </template>
                            <template v-slot:item.aPagar="{item}">
                                <v-chip color="orange" dark>
                                    <v-avatar left color="green">
                                        <v-icon color="white">monetization_on</v-icon>
                                    </v-avatar>{{item.aPagar}}
                                </v-chip>

                            </template>

                            <template v-slot:item.customer.nombre="{ item }" style="left: 350px;">
                                <v-row

                                    align="center"
                                    style="left: 350px;"
                                    >
                                    <v-menu
                                        bottom
                                        right
                                        transition="scale-transition"
                                        origin="top left"
                                    >
                                        <template v-slot:activator="{ on }">
                                        <v-chip
                                            pill
                                            v-on="on"
                                        >
                                            <v-avatar left >
                                                <v-icon color="teal">mdi-account-circle</v-icon>
                                            </v-avatar>{{item.customer.nombre | formatUpperCase}}
                                        </v-chip>
                                        </template>
                                        <v-card width="400">
                                        <v-list dark>
                                            <v-list-item>
                                            <v-list-item-avatar>
                                                <v-icon color="teal" large>mdi-account-circle</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.customer.nombre | formatUpperCase}}</v-list-item-title>
                                                <v-list-item-subtitle>Monto aprobado: ${{item.monto}}</v-list-item-subtitle>
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
                                        <v-list three-line>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-comment-text</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>Descripción</v-list-item-title>
                                                <v-list-item-subtitle>{{item.descripcion | formatUpperCase}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                            <v-list-item>
                                            <v-list-item-icon>
                                                <v-icon color="indigo">mdi-calendar</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item.fecha}}</v-list-item-title>
                                                <v-list-item-subtitle>Fecha de aprobación</v-list-item-subtitle>
                                            </v-list-item-content>
                                            </v-list-item>
                                        </v-list>
                                        </v-card>
                                    </v-menu>
                                </v-row>
                            </template>
                            <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="orange--text text--accent-4 font-weight-bold">Creditos</v-toolbar-title>
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

                                <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="#ff3f00" outlined dark v-on="on" ><v-icon left>mdi-credit-card-multiple</v-icon>Nuevo Credito</v-btn>
                                </template>
                                <v-card style="border-radius:20px;">

                                    <v-container class="align-items-center" style="background: linear-gradient(60deg, #fd2d21, #fc831a);">
                                         <v-col
                                        cols="12"
                                        md="12"
                                        sm="12">
                                            <p style="text-align: center; color:#ffffff; margin-bottom: -5px;">
                                                <i class="material-icons" style="font-size:85px;">credit_card</i>
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
                                                    v-if="!edit_mode"
                                                    >
                                                    <v-select
                                                        v-model="select"
                                                        :items="nombres"
                                                        item-text="nombre"
                                                        item-value="id"
                                                        label="Selecccione al cliente"
                                                        prepend-icon="local_shipping"
                                                        persistent-hint
                                                        return-object
                                                        ></v-select>
                                                    </v-col>
                                                     <v-col
                                                    cols="12"
                                                    md="12"
                                                    sm="6"
                                                    v-if="edit_mode"
                                                    >
                                                    <v-text-field
                                                       :rules="[required('descripcion'), minimum_length(8)]"
                                                        v-model="editedItem.descripcion"
                                                        label="Descripción del abono"
                                                        type="text"
                                                        prepend-icon="post_add"
                                                        clearable
                                                        required
                                                    ></v-text-field>
                                                    </v-col>
                                                     <v-col
                                                    cols="12"
                                                    md="12"
                                                    sm="6"
                                                    v-if="!edit_mode"
                                                    >
                                                    <v-text-field
                                                    :rules="[required('descripcion'), minimum_length(8)]"
                                                        v-model="editedItem.descripcion"
                                                        label="Descripción"
                                                        type="text"
                                                        prepend-icon="post_add"
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
                                                        :rules="[required('monto'), minimum_length(1)]"
                                                        v-model="editedItem.monto"
                                                        :counter=true
                                                        type="number"
                                                        clearable
                                                        label="Monto"
                                                        prepend-icon="attach_money"
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
                                                        :rules="[required('monto'), minimum_length(1)]"
                                                        v-model="editedItem.monto"
                                                        :counter="15"
                                                        type="text"
                                                        clearable
                                                        label="Monto"
                                                        prepend-icon="attach_money"
                                                        required
                                                    ></v-text-field>
                                                    </v-col>



                                                    <v-col
                                                    cols="12"
                                                    md="6"
                                                    sm="12"
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
                                                            v-model="editedItem.fecha"
                                                            label="Fecha de aprobación"
                                                            prepend-icon="event"
                                                            readonly
                                                            v-on="on"
                                                        ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                        :rules="[required('fecha')]"
                                                        v-model="editedItem.fecha"
                                                        locale="mx"
                                                        type="date"
                                                        format="YYYY-MM-dd"
                                                        color="#fd2d21"
                                                        required
                                                        @input="menu1 = false"
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
                                    <v-icon small @click="editItem(item)">mdi-credit-card-multiple </v-icon>
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
                                elevation="4">No hay Creditos aprobados.</v-alert>
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
                nombre:'',
                select: {
                    id: '',
                    nombre: '',
                },
                date1: new Date().toISOString().substr(0, 10),
                menu1:false,
                headers: [
                    { text: 'Nombre', value: 'customer.nombre' }, //Se establecen los titulos de columna de la tabla de Creditos
                    { text: 'Monto', value: 'monto' },            //Estos se establen en objetos que estan  dentro de un arreglo
                    { text: 'Por pagar', value: 'aPagar'},        //Dentro de cada objeto se establece el valor de las celdas decada columna
                    //{ text: 'Detalles', value: 'descripcion' },
                    { text: 'Fecha de aprobación', value: 'fecha'},
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                credits: [],//Se declara el arreglo que almacenara la informacion de los creditos
                nombres: [],//Para guardar los nombre de los clientes se crea el arreglo "nombres"
                editedIndex: -1,
                editedItem: {
                    id: '',         //Dentro del objeto "Editediten" se establecen los items que se utilizan para
                    monto: '',      //los modelos de los componentes de los formularios de creacion, edicion y eliminar
                    descripcion: '',
                    fecha: '',
                    created_at: ''
                },
                defaultItem: {
                    id: '',
                    monto: '',
                    descripcion: '',
                    fecha: '',
                    created_at: ''
                },
                required( propertyName ) {
                    return v => v && v.length > 0 || `Debes ingresar un ${propertyName}`
                },
                minimum_length( length ) {
                    return v => v && v.length >= length || `Longitud mínima de ${length} caracteres`
                },
             }
        },

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Nuevo registro' : 'Registrar abono'
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        methods: {
            editItem (item) { //Se manda a llamar al objeto a editar
                this.editedIndex = this.credits.indexOf(item) //Con indexOf buscamos la posicion de este dentro del arreglo de credits
                if(item.aPagar>0){ //Comprobacion para saber si el monto por pagar del credito es mayor a 0
                this.editedItem = Object.assign({}, item) //Clonacion del objeto recibido anteriormente
                this.dialog = true //Se abre el dialogo(formulario) que permite abonar al credito
                this.edit_mode = true
                this.editedItem.monto = ''
                this.editedItem.descripcion = ''
                }else{//Si el saldo ya esta saldado de muestra un mensaje informando que el credito ya esta saldado
                    Swal.fire({
                        title:'Este crédito ya ha sido saldado',
                        type:'success',
                        confirmButtonColor: '#ff5300'
                    })
                }
            },
            close () {
                this.$refs.form.reset()//Cuando de cancela la operacion de editar se resetea el obheto
                this.dialog = false //Despues se cierra el dialogo que estaba abierto
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem) //Se restablecen los valores iniciales del objeto
                this.editedIndex = -1
                })
                if (this.edit_mode == true) {
                    this.edit_mode = false
                }
            },
            async save () {
                if (this.editedIndex > -1) { //Comprobacion para saber si estamos editando o creando un nuevo credito
                    const response = await axios.put(`api/credits/${this.editedItem.id}`, this.editedItem)
                    .catch(error => console.log(error));//Cuando se selecciona la opcion de guardar se insertar los nuevos valores ingresados en el objeto de items
                    if (response.data.validation_errors) {
                        Toast.fire({
                            icon: 'error',//Si algun dato es erroneo se muestra un mensaje de alerta
                            title: '¡Ocurrió un error, vuelve a intentarlo!'
                        });
                        console.log(response.data);
                    } else {
                        this.getResults();
                        Toast.fire({
                            icon: 'success', //En caso de que los valores ingresados sean validos se muestra un mensaje de exito
                            title: '¡Datos del credito actualizados!'
                        })
                    }
                } else {
                    const response = await axios.post('/api/credits',{
                        'monto': this.editedItem.monto, //Se insertan los valores en la bd
                        'descripcion' : this.editedItem.descripcion,
                        'fecha': this.editedItem.fecha,
                        'customer_id': this.select.id,
                    }).catch(error => console.log("Error: " + error));

                    if (response) {
                        this.getResults();
                        Toast.fire({
                            icon: 'success',
                            title: 'Credito aprobado!'
                        })
                        console.log(response.data);
                    }
                }

                this.close();
            },
            async deleteItem (item) {
                this.editedIndex = this.credits.indexOf(item)
                this.editedItem = Object.assign({}, item)
                Swal.fire({
                    title: '¿Estás seguro de cancelar este credito?',
                    text: "Se cambiara el status de activo!",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff5300',
                    cancelButtonColor: '#C1BCBB',
                    confirmButtonText: 'Si, cancelalo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`api/credits/${this.editedItem.id}`).then(() => {
                            this.getResults();
                            Swal.fire(
                            'Desactivado!',
                            'El credito ha sido cancelado.',
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
                axios.get('api/credits')
                .then(response => {
                    this.credits = response.data; //Se consultan todos los registros de creditos aprobados
                    console.log(response.data)    //Y se insertan en el arreglo de credits
                    this.loading = false;
                });
            },
            getNames(){
                 axios.get('api/customers')
                .then(response => {
                    this.nombres = response.data; //Se obtienen los regisros delos clientes activos
                    console.log(response.data)    //Se insertan los objetos recibidos en el arreglo de nombres
                    this.loading = false;
                });
            }

        },

        created () {
            this.getResults();
            this.getNames();
        },
    }
</script>
