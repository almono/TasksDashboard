<template>
  <div>
    <BCard
      :title="settingsStore?.settings?.registration_enabled ? 'Create an account' : 'Registration process is currently disabled'"
      img-src="https://picsum.photos/id/25/600/300"
      img-alt="Register-Image"
      img-top
      tag="article"
      style="max-width: 30rem"
      class="mx-auto my-auto text-left d-flex align-center justify-center register-card"
    >
      <BForm v-if="settingsStore?.settings?.registration_enabled" @submit.prevent="registerUser()">
        <BCardText class="align-right mt-4">
          <BInputGroup class="mt-3">
            <BFormInput
              id="input-first"
              v-model="registrationForm.firstName"
              placeholder="First Name"
              class="register-input px-2"
            />
            <BFormInput
              id="input-last"
              v-model="registrationForm.lastName"
              type="text"
              placeholder="Last Name"
              class="register-input px-2"
            />
          </BInputGroup>
          <BFormInput
            id="input-username"
            v-model="registrationForm.username"
            type="text"
            placeholder="Username"
            class="register-input px-2 mt-3"
            required
          />
          <BFormInput
            id="input-1"
            v-model="registrationForm.email"
            type="email"
            placeholder="Enter email"
            class="register-input px-2 mt-3"
            required
          />
          <BInputGroup class="mt-3">
            <template #append>
              <BInputGroupText class="pass-append">
                <i id="forgot-pass-eye" :class="data.showPassword === false ? 'bi bi-eye-slash' : 'bi bi-eye-fill'" @click="togglePassword()"></i>
              </BInputGroupText>
            </template>
            <BFormInput
              id="input-2"
              v-model="registrationForm.password"
              :type="data.showPassword === false ? 'password' : 'text'"
              placeholder="Enter password"
              class="register-input px-2"
              required
            />
          </BInputGroup>
          <BFormInput
            id="input-3"
            v-model="registrationForm.confirmPassword"
            type="password"
            placeholder="Confirm password"
            class="register-input px-2 mt-3"
            required
          />
          <BFormInput
            id="input-phone"
            v-model="registrationForm.phoneNumber"
            type="text"
            placeholder="Phone"
            class="register-input px-2 mt-3"
            required
          />
          <span class="text-red-700 font-bold error-msg my-2" v-if="data?.validationErrors">
            <li class="d-block px-0" v-for="(err, val) in data.validationErrors">{{ err }}</li>
          </span>
        </BCardText>
        <div class="text-center col-12 result-msg" v-if="data.registrationResult">
          <span class="col-12 px-0">{{ data.registrationResult }}</span>
        </div>
        <div class="col-12 px-0 text-center align-items-center justify-content-center mt-3">
          <BButton class="col-8" pill variant="primary" type="submit" v-if="!data.requestProcessing">Register</BButton>
          <BButton class="col-8" pill variant="primary" v-else :disabled="true">Processing...</BButton>
        </div>
        <div class="col-12 px-0 text-center mt-2">
          <span>Already have an account? <span class="login-here-text" @click="goToLogin()">Login here</span></span>
        </div>
      </BForm>
      <template v-else>
        <div class="col-12 px-0 text-center mt-2">
          <span class="login-here-text" @click="goToLogin()">Login here</span>
        </div>
      </template>
    </BCard>
  </div>
</template>

<script setup>
import { useSettingsStore } from '../../stores/settings/settings';
import { useAuthStore } from '../../stores/auth/auth'

const settingsStore       = useSettingsStore();
const authStore           = useAuthStore();

const data = reactive({
  validationErrors: null,
  registrationErrors: null,
  showPassword: false,
  requestProcessing: false,
  registrationResult: null
})

const registrationForm = reactive({
    username: null,
    firstName: null,
    lastName: null,
    email: null,
    password: null,
    phoneNumber: null
})

function registerUser() {
  data.validationErrors   = null
  data.registrationErrors = null
  data.requestProcessing  = true

  authStore.register({
    username: registrationForm.username,
    email: registrationForm.email,
    password: registrationForm.password,
    c_password: registrationForm.confirmPassword,
    first_name: registrationForm.firstName,
    last_name: registrationForm.lastName,
    phone: registrationForm.phoneNumber
  }).then(response => {    
    data.requestProcessing = false
    
    data.validationErrors = response.status === 422 ? response?.data?.errors : null
    data.registrationErrors = response.status === 401 ? response?.data?.message : null
    data.registrationResult = response.status === 201 ? response?.data?.message : null
  })
}

function togglePassword() {
  data.showPassword = !data.showPassword
}
</script>

<script>
import { BButton, BForm, BFormGroup, BFormInput, BInputGroup, BInputGroupText } from 'bootstrap-vue-next';
import { reactive } from 'vue';

export default {
  name: "Register",
  methods: {
    goToLogin() {
      this.$router.push({path: '/login'})
    }
  }
};
</script>
  
<style scoped>

h2 {
  color: #42b983;
}

.register-input {
  border-radius: 0px;
  padding-left: 5px;
  color: rgb(90, 90, 90) !important;
  height: 3rem;
  border: 0px 0px 1px 1px gray solid;
}

.error-msg {
  color: red !important;
}

.result-msg {
  color: rgb(6, 184, 0) !important;
  font-weight: 600;
}

.new-account-text {
  cursor: pointer !important;
}

.new-account-text:hover {
  text-decoration: underline;
}

.card-body > h4 {
  font-size: 30px !important;
}

.register-card {
  box-shadow: 3px 3px 3px rgba(201, 201, 201, 0.438);
}

#forgot-pass-eye {
  color: rgb(0, 121, 177) !important;
  font-size: 20px;
}

.pass-append {
  height: 3rem;
}

.login-here-text {
  color: rgb(0, 102, 255) !important;
  cursor: pointer !important;
  font-size: 16px;
  font-weight: 600 !important;
}

.login-here-text:hover {
  text-decoration: underline;
}
</style>
  