
<template>
    <layout-div>
      <div class="card" style="margin-top:20px">
        <div class="card-header" style="text-align: center;">
          Login
        </div>
        
        <div class="card-body">
          <form>
            <div class="form-group">
              <label for="username">Username</label>
              <input 
                v-model="loginForm.email"
                type="text"
                class="form-control"
                id="username"
                name="username"/>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input 
                v-model="loginForm.password"
                type="password"
                class="form-control"
                id="password"
                name="password"/>
            </div>
            <div class="form-group">
              <button 
                @click="handleLogin()"
                :disabled="isLoggingIn"
                type="button"
                style="margin-left: 10px; margin-top:10px"
                class="btn btn-primary float-end">
                Login
              </button>
            </div>
          </form>
        </div>
      </div>
    </layout-div>
  </template>
  
  <script>
  import axios from 'axios';
  import LayoutDiv from './LayoutDivLogin.vue';
  import Swal from 'sweetalert2'
  
  export default {
    name: 'LoginForm',
    components: {
      LayoutDiv,
    },
    data() {
      return {
        loginForm: {
          email: '',
          password: '',
        },
        isLoggingIn: false,
      };
    },
    methods: {
      handleLogin() {
        this.isLoggingIn = true
        // Example: make a POST request to your login endpoint
        axios.post('/login', this.loginForm)
          .then(response => {
            localStorage.setItem('authToken', response.data.token);
            Swal.fire({
              icon: 'success',
              title: 'Login successful!',
              showConfirmButton: false,
              timer: 1500
            })
            
            window.location.href = '/'; 
            // Redirect or perform any other action upon successful login
            this.isLoggingIn = false
            this.loginForm.email = ""
            this.loginForm.password = ""
            return response
          })
          .catch(error => {
            this.isLoggingIn = false
            console.error("Login failed:", error);
            Swal.fire({
              icon: 'error',
              title: 'Login failed!',
              showConfirmButton: false,
              timer: 1500
            })
            return error
          });
      },
    },
  };
  </script>
  