<template>
    <v-app-bar flat="flat">
        <v-app-bar-title>
            <v-icon icon="mdi-circle-slice-4"/>
            <router-link to="/" class="no-underline">
                Base Preset
            </router-link>
        </v-app-bar-title>
        <v-btn rounded="xl" size="small" @click="changeLanguage('en')">{{$t('text.en')}}</v-btn>
        <v-btn rounded="xl" size="small" @click="changeLanguage('id')">{{$t('text.id')}}</v-btn>
        <v-btn>
            <v-icon icon="mdi-login"/>
            {{ $t('text.login') }}

            <v-dialog v-model="dialog" activator="parent" width="600">

                <v-card>
                    <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
                        <v-tab :key="0" @click="tab= 0">{{ $t('text.login') }}</v-tab>
                        <v-tab :key="1" @click="tab= 1">{{ $t('text.register') }}</v-tab>
                    </v-tabs>
                    <v-window v-model="tab">
                        <v-window-item>
                            <div class="ml-4 mr-4">
                                <v-form v-if="tab === 0" @submit.prevent="formLogin">
                                    <v-text-field
                                        v-model="login.username"
                                        :rules="rules.Username"
                                        :label="$t('text.username')"/>
                                    <v-text-field
                                        v-model="login.password"
                                        :rules="rules.Password"
                                        :label="$t('text.password')"/>
                                    <v-btn type="submit" color="primary">Login</v-btn>
                                </v-form>
                            </div>
                            <div class="ml-4 mr-4">
                                <v-form v-if="tab === 1" @submit.prevent="register">
                                    <v-text-field
                                        v-model="register.username"
                                        :rules="rules.Username"
                                        :label="$t('username')"/>
                                    <v-text-field
                                        v-model="register.email"
                                        :rules="rules.Email"
                                        label="$t('e-mail')"/>
                                    <v-text-field
                                        v-model="register.password"
                                        :rules="rules.Password"
                                        type="password"
                                        label="$t('password')"/>
                                    <v-btn type="submit" color="primary">{{ $t('text.register') }}</v-btn>
                                </v-form>
                            </div>

                        </v-window-item>
                    </v-window>
                    <v-card-actions>
                        <v-btn color="primary" block="block" @click="dialog = false">{{$t('text.closeDialog')}}</v-btn>
                    </v-card-actions>
                </v-card>

            </v-dialog>
        </v-btn>

    </v-app-bar>
</template>

<script >
    import axios from "axios";
    import {apiUrl} from "@/api/index.js";
    export default {
        data: () => ({
            dialog: false,
            tab: 0,
            login: {
                username: '',
                password: ''
            },
            register: {
                username: '',
                email: '',
                password: ''
            },
            rules: {
                Username: [value => !!value || "Username is Required"],
                Password: [
                    value => !!value || "Password is Required",
                    value => (value && value.length >= 6) || "Password must be more than 5 characters"
                ],
                Email: [value => !!value || "E-mail is Required"]
            }

        }),
        methods: {
            changeLanguage(locale) {
                this.$i18n.locale = locale;
            },

            formLogin() {
                axios
                    .post(`${apiUrl}/login`, {
                        email: this.login.username,
                        password: this.login.password
                    })
                    .then(response => {
                        console.log("You have successfully logged in",response);

                        this.$router.push('/admin/dashboard');

                    })
                    .catch(error => {
                      console.error(error);
                      this.$vuetify.alert.error("Login failed. Please check your credentials.");
                    });
            }

        },

    };
</script>

<style>

    .no-underline {
        text-decoration: none;
    }
</style>
