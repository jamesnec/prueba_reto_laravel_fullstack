<template>
    <div class="into-main-content">
        <header-component></header-component>
        <div class="rw-content-page">
            <div class="into-content-page">
                <div class="container">
                    <div class="row">
                        <div class="col s4">
                            <div class="rw-form-exchange-admin">
                                <div class="into-form-exchange-admin">
                                    <div class="rw-title-form-exchange">
                                        <h4>{{ text_title }}</h4>
                                    </div>
                                    <form action="#" id="formExchange" v-on:submit.prevent="sendForm()">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="amount_exchange" type="number" v-model.trim="exchange.amount" autocomplete="off" required step="any">
                                                <label for="amount_exchange">Tipo de cambio</label>
                                                <div class="error" v-if="errors.amount">{{ errors.amount[0] }}</div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="origin_exchange" type="text" v-model.trim="exchange.origin" autocomplete="off" required>
                                                <label for="origin_exchange">Moneda origen</label>
                                                <div class="error" v-if="errors.origin">{{ errors.origin[0] }}</div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="destination_exchange" type="text" v-model.trim="exchange.destination" autocomplete="off" required>
                                                <label for="destination_exchange">Moneda destino</label>
                                                <div class="error" v-if="errors.destination">{{ errors.destination[0] }}</div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="rw-bttn-form">
                                                    <button class="btn waves-effect waves-light" type="submit" name="action" :disabled="bool_button"><span>{{ text_button }}</span><i class="material-icons right">send</i></button>
                                                </div>
                                            </div>
                                        </div>                                                                                
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col s8">
                            <div class="rw-table-exchanges">
                                <div class="into-table-exchanges">
                                    <table width="100%" class="highlight" v-if="Object.keys(list_exchanges).length > 0">
                                        <thead>
                                            <tr>
                                                <th>Tipo de cambio</th>
                                                <th>Moneda origen</th>
                                                <th>Moneda destino</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="o_exchange in list_exchanges" :key="o_exchange.id">
                                                <td>{{ o_exchange.amount }}</td>
                                                <td>{{ o_exchange.origin }}</td>
                                                <td>{{ o_exchange.destination }}</td>
                                                <td>
                                                    <button type="button" class="btn bttn-info" v-on:click="editExchange(o_exchange)"><i class="material-icons border_color">border_color</i></button>
                                                    <button type="button" class="btn btn-error red" v-on:click="deleteExchange(o_exchange.id)"><i class="material-icons delete">delete</i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="rw-not-data" v-else>
                                        <h5>No hay tipos de cambios registrados</h5>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {    
		created() {
            this.getValuesMain();
		},         
        data(){
            return {
                exchange: {
                    amount: '',
                    origin: '',
                    destination: ''
                },
                errors: {},
                text_title: 'Agregar tipo de cambio',
                text_button: 'Enviar',
                bool_button: false,
                list_exchanges: [],
                id_selected: 0,
            }
        },    
        methods: {
            getValuesMain: function(){
                axios.get('/api/exchanges')
                .then(response => {
                    this.list_exchanges = response.data.list_exchanges;
                }).catch((error) => {
                    if(error.response){
                        Swal.fire({
                            text: error.response.data.message,
                            icon: 'error',
                        });
                    }
                }); 
            },
            sendForm: async function(){
                this.bool_button = true;
                this.text_button = "Procesando...";
                this.errors = {};

                if(this.id_selected == 0){
                    if(this.exchange.amount != '' && this.exchange.origin != '' && this.exchange.destination != ''){
                        await axios.post('/api/exchanges', this.exchange)
                        .then((response)=> {
                            Swal.fire({
                                text: "Tipo de cambio agregado con éxito",
                                icon: 'success',
                            }); 
                            this.bool_button = false;
                            this.text_button = "Enviar";
                            var myForm = document.getElementById("formExchange");
                            myForm.reset();
                            this.exchange.amount = '';
                            this.exchange.origin = '';
                            this.exchange.destination = '';

                            this.getValuesMain();
                        }).catch((error) => {
                            this.bool_button = false;
                            this.text_button = "Enviar";  
                            if(error.response.status == 500){
                                Swal.fire({
                                    text: error.response.data.message,
                                    icon: 'error',
                                }); 
                            }else{
                                this.errors = error.response.data.errors;
                            }
                        }) 
                    }else{
                        this.bool_button = false;
                        this.text_button = "Enviar";
                        Swal.fire({
                            text: "Los campos son obligatorios.",
                            icon: 'error',
                        });                    
                    }
                }else{
                    if(this.exchange.amount != '' && this.exchange.origin != '' && this.exchange.destination != ''){
                        await axios.put('/api/exchange/' + this.id_selected, this.exchange)
                        .then((response)=> {
                            Swal.fire({
                                text: "Tipo de cambio actualizado con éxito",
                                icon: 'success',
                            }); 
                            this.bool_button = false;
                            this.text_button = "Enviar";
                            this.text_title = 'Agregar tipo de cambio';
                            var myForm = document.getElementById("formExchange");
                            myForm.reset();
                            this.id_selected = 0;
                            this.exchange.amount = '';
                            this.exchange.origin = '';
                            this.exchange.destination = '';

                            this.getValuesMain();
                        }).catch((error) => {
                            this.bool_button = false;
                            this.text_button = "Guardar";  
                            if(error.response.status == 500){
                                Swal.fire({
                                    text: error.response.data.message,
                                    icon: 'error',
                                }); 
                            }else{
                                this.errors = error.response.data.errors;
                            }
                        }) 
                    }else{
                        this.bool_button = false;
                        this.text_button = "Guardar";
                        Swal.fire({
                            text: "Los campos son obligatorios.",
                            icon: 'error',
                        });                    
                    }                    
                }
            },
            editExchange: function(itemExchange){
                this.id_selected = itemExchange.id;
                this.exchange.amount = itemExchange.amount;
                this.exchange.origin = itemExchange.origin;
                this.exchange.destination = itemExchange.destination;
                const myForm = document.getElementById("formExchange");
                const inpts = myForm.getElementsByTagName('label');

                for (const o_inpt of inpts) {
                    o_inpt.classList.add("active");
                }

                this.text_button = "Guardar";
                this.text_title = 'Editar tipo de cambio';
            },
            deleteExchange: async function(id){
                await axios.delete('/api/exchange/' + id)
                .then((response)=> {
                    Swal.fire({
                        text: "Tipo de cambio eliminado con éxito",
                        icon: 'success',
                    }); 

                    this.getValuesMain();
                }).catch((error) => {
                    if(error.response){
                        Swal.fire({
                            text: error.response.data.message,
                            icon: 'error',
                        }); 
                    }
                })                 
            }
        },
    }
</script>        