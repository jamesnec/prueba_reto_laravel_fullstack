<template>
    <div class="into-main-content">
        <header-component></header-component>
        <div class="rw-content-page">
            <div class="into-content-page">
                <div class="container">
                    <div class="row">
                        <div class="col s8">
                            <div class="rw-form-change-type">
                                <div class="into-form-change-type" v-if="Object.keys(list_exchanges).length > 0">
                                    <form action="#" id="formExchange" v-on:submit.prevent="sendForm()">
                                        <div class="row">
                                            <div class="input-field col s12 mb-0">
                                                <input id="amount" type="number" v-model.trim="exchange.amount">
                                                <label for="amount">Monto</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 mb-0">                                                
                                                <label class="active" style="margin-bottom:5px">Moneda origen</label>  
                                                <select v-model.trim="exchange.origin">
                                                    <option value="" hidden disabled selected>Elegir una opción</option>
                                                    <option :value="o_exchange.origin" v-for="(o_exchange, ind) in list_exchanges" :key="'or' + ind">{{ o_exchange.origin }}</option>
                                                </select>                                                                                              
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 mb-0">                                                
                                                <label class="active" style="margin-bottom:5px">Moneda destino</label>   
                                                <select v-model.trim="exchange.destination">
                                                    <option value="" hidden disabled selected>Elegir una opción</option>
                                                    <option :value="o_exchange_n.destination" v-for="(o_exchange_n, indx) in list_exchanges" :key="'de' + indx">{{ o_exchange_n.destination }}</option>
                                                </select>                                                                                             
                                            </div>  
                                        </div>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="rw-bttn-form">
                                                    <button class="btn waves-effect waves-light" type="submit" name="action" :disabled="bool_button">{{ text_button }}<i class="material-icons right">send</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col s4">
                            <div class="rw-result-amount" v-if="new_amount">
                                <div class="into-result-amount">
                                    <div class="rw-title-result-amount">Resultados:</div>
                                    <div class="rw-item-result-amount">
                                        <p><b>Monto: </b>{{ old_amount }}</p>
                                    </div>
                                    <div class="rw-item-result-amount">
                                        <p><b>Monto al cambio: </b>{{ new_amount }}</p>
                                    </div>
                                    <div class="rw-item-result-amount">
                                        <p><b>Moneda origen: </b>{{ exchange_result.origin }}</p>
                                    </div>
                                    <div class="rw-item-result-amount">
                                        <p><b>Moneda destino: </b>{{ exchange_result.destination }}</p>
                                    </div>
                                    <div class="rw-item-result-amount">
                                        <p><b>Tipo de cambio: </b>{{ exchange_result.amount }}</p>
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
                list_exchanges: [],
                bool_button: false,
                text_button: "Convertir",
                exchange_result: {},
                old_amount: "",
                new_amount: "",
            }
        },    
        methods: {
            getValuesMain: function(){
                axios.get('/api/exchanges/list')
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
                this.text_button = "Convertiendo..."; 

                await axios.post('/api/exchange/convert', this.exchange)
                .then((response)=> {
                    this.bool_button = false;
                    this.text_button = "Convertir";     
                    this.exchange_result = response.data.my_exchange;                
                    this.old_amount = response.data.old_amount;
                    this.new_amount = response.data.new_amount;
                }).catch((error) => {
                    this.bool_button = false;
                    this.text_button = "Convertir";  
                    if(error.response.status == 500){
                        Swal.fire({
                            text: error.response.data.message,
                            icon: 'error',
                        }); 
                    }else{
                        this.errors = error.response.data.errors;
                    }
                }) 
            }
        },
        mounted: function(){

        },        
        watch: {

        }
    }
</script>   