<template>
    <div>
      <!-- Navigation Bar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light p-1">
        <div class="container-fluid">
          <router-link class="navbar-brand" to="/">Hospital Management System</router-link>
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <router-link class="nav-link" to="/">Login</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/register">Register</router-link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      
      <!-- Registration Form -->
      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <form @submit.prevent="registerUser" class="shadow p-4">
              <h4 class="mb-4 text-center">Register</h4>
              <div class="mb-3">
                <input type="text" class="form-control" v-model="name" placeholder="Enter your Name" @input="clearErrors('name')">
                <div class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</div>
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" v-model="email" placeholder="Enter your Email" @input="clearErrors('email')">
                <div class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</div>
              </div>
              <div class="mb-3">
                <input :type="passwordVisible ? 'text' : 'password'" class="form-control" v-model="password" placeholder="Enter your Password (Password must be 8 characters or more)" @input="clearErrors('password')">
                <div class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</div>
              </div>
              <div class="mb-3">
                <input :type="confirmPasswordVisible ? 'text' : 'password'" class="form-control" v-model="password_confirmation" placeholder="Confirm Password">
                <div class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</div>
              </div>
              <div class="mb-3">
                <select class="form-select" v-model="role" @change="clearErrors('role')">
                  <option value="" disabled>Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="doctor">Doctor</option>
                  <option value="patient">Patient</option>
                </select>
                <div class="text-danger" v-if="errors?.role">{{ errors.role[0] }}</div>
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" id="showPassword" v-model="passwordVisible" class="form-check-input">
                <label for="showPassword" class="form-check-label">Show Password</label>
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" id="showConfirmPassword" v-model="confirmPasswordVisible" class="form-check-input">
                <label for="showConfirmPassword" class="form-check-label">Show Confirm Password</label>
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="mt-3 text-center">Already have an account? <router-link to="/">Login here!</router-link></p>
          </div>
        </div>
      </div>
    </div>
  </template>
  

  <script>
  import { BASE_URL } from '@/config';
  import axios from '@/axios';
  import Swal from 'sweetalert2';
  
  export default {
    name: 'RegisterPage',
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '',
        passwordVisible: false,
        confirmPasswordVisible: false,
        errors: {}
      };
    },
    methods: {
      clearErrors(field) {
        if (this.errors[field]) {
          this.errors[field] = null;
        }
      },
      async registerUser() {
        try {
          const response = await axios.post(`${BASE_URL}/register`, {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
            role: this.role
          });
          if (response.status === 201) {
            this.clearForm();
            Swal.fire({
              icon: 'success',
              title: 'Registration Successful!',
              text: 'You have successfully registered.',
              confirmButtonText: 'OK'
            }).then(() => {
              this.$router.push({ name: 'login' });
            });
          }
        } catch (error) {
          if (error.response && error.response.data && error.response.data) {
            this.errors = error.response.data;
            Swal.fire({
              icon: 'error',
              title: 'Registration Failed',
              text: 'Please check your input and try again.',
              confirmButtonText: 'OK'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Registration Failed',
              text: 'Please check your credentials and try again.',
              confirmButtonText: 'OK'
            });
            console.error('An unexpected error occurred:', error);
          }
        }
      },
      clearForm() {
        this.name = '';
        this.email = '';
        this.password = '';
        this.password_confirmation = '';
        this.role = '';
        this.errors = {};
      }
    }
  };
  </script>
  

<style scoped>

</style>