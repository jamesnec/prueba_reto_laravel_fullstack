<template>
    <div class="into-main-content">
        <header-component></header-component>
        <div class="rw-content-page">
            <div class="into-content-page">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <div class="rw-form-login-admin">
                                <div class="into-form-login-admin">
                                    <div class="rw-title-form-login">
                                        <h2>Iniciar sesión</h2>
                                    </div>
                                    <form action="#" id="formLogin" v-on:submit.prevent="sendForm()">
                                        <div class="row">
                                            <div class="input-field col s12 mb-0">
                                                <input id="email_admin" type="email" v-model.trim="user.email" autocomplete="off" required>
                                                <label for="email_admin">Correo</label>
                                                <div class="error" v-if="errors.email">{{ errors.email[0] }}</div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 mb-0">
                                                <input id="password_admin" type="password" v-model.trim="user.password" required>
                                                <label for="password_admin">Contraseña</label>
                                                <div class="error" v-if="errors.password">{{ errors.password[0] }}</div>
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
                    </div>    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {     
        data(){
            return {
                user: {
                    email: '',
                    password: '',
                },
                errors: {},
                text_button: 'Ingresar',
                bool_button: false
            }
        },    
        methods: {
            sendForm: async function(){
                this.bool_button = true;
                this.text_button = "Procesando...";
                this.errors = {};

                if(this.user.email != '' && this.user.password != ''){
                    await axios.post('/login', this.user)
                    .then((response)=> {
                        window.location.href = "/administrador";
                    }).catch((error) => {
                        this.bool_button = false;
                        this.text_button = "Ingresar";  
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
                    this.text_button = "Ingresar";                      
                    Swal.fire({
                        text: "Los campos son obligatorios",
                        icon: 'error',
                    });                     
                }
            },
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        },
    }
</script>        