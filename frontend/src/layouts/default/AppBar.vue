<template>
  <v-app-bar flat>
    <v-app-bar-title>
      <v-icon icon="mdi-circle-slice-4" />
      <router-link to="/"  class="no-underline"> Base Preset </router-link>
    </v-app-bar-title>
    <v-btn>
      <v-icon icon="mdi-login"/> Login

      <v-dialog v-model="dialog" activator="parent" width="600">

        <v-card>
          <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
            <v-tab :key="0" @click="tab= 0">Login</v-tab>
            <v-tab :key="1" @click="tab= 1">Registrasi</v-tab>
          </v-tabs>
          <v-window v-model="tab">
            <v-window-item>
              <div class="ml-4 mr-4">
                <v-form v-if="tab === 0" @submit.prevent="login">
                  <v-text-field v-model="login.username" :rules="rules.Username" label="Username"/>
                  <v-text-field v-model="login.password" :rules="rules.Password" label="Password"/>
                  <v-btn type="submit" color="primary">Login</v-btn>
                </v-form>
              </div>
              <div class="ml-4 mr-4">
                <v-form v-if="tab === 1" @submit.prevent="register">
                  <v-text-field v-model="register.username" :rules="rules.Username" label="Username"/>
                  <v-text-field v-model="register.email" :rules="rules.Email" label="E-Mail"/>
                  <v-text-field v-model="register.password" :rules="rules.Password" label="Password"/>
                  <v-btn type="submit" color="primary">Registrasi</v-btn>
                </v-form>
              </div>

            </v-window-item>
          </v-window>
          <v-card-actions>
            <v-btn color="primary" block @click="dialog = false">Close Dialog</v-btn>
          </v-card-actions>
        </v-card>

      </v-dialog>
    </v-btn>

  </v-app-bar>
</template>

<script >
  export default{
    data:()=>({
      dialog:false,
      tab:0,
      login:{
        username:'',
        password:''
      },
      register:{
        username:'',
        email:'',
        password:''
      },
      rules:{
        Username:[
          value=> !!value || "Username is Required",
        ],
        Password:[
          value=>!!value || "Password is Required",
          value=>(value && value.length <=6)|| "Password must be more than 5 characters"
        ],
        Email:[
          value=>!!value || "E-mail is Required"
        ]
      }

    })
  }
</script>

<style>

.no-underline {
  text-decoration: none;
}
</style>
