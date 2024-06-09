<template>
  <div>
      <!--Navigation Bar -->
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
      <!-- Login Form -->
      <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-md-6">
                  <form @submit.prevent="loginUser" class="shadow p-4">
                      <h4 class="mb-4 text-center">Login</h4>
                      <div class="mb-3">
                          <input type="email" class="form-control" v-model="email" placeholder="Enter your Email" @input="clearErrors('email')">
                          <div class="text-danger" v-if="errors.email">{{ errors.email }}</div>
                      </div>
                      <div class="mb-3">
                          <input :type="passwordVisible ? 'text' : 'password'" class="form-control" v-model="password" placeholder="Enter your Password" @input="clearErrors('password')">
                          <div class="text-danger" v-if="errors.password">{{ errors.password }}</div>
                      </div>
                      <div class="form-check mb-3">
                          <input type="checkbox" id="showPassword" v-model="passwordVisible" class="form-check-input">
                          <label for="showPassword" class="form-check-label">Show Password</label>
                      </div>
                      <button type="submit" class="btn btn-primary w-100">Login</button>
                  </form>
                  <p class="mt-3 text-center">Don't have an account? <router-link to="/register">Register here!</router-link></p>
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
  name: 'LoginPage',
  data() {
      return {
          email: '',
          password: '',
          passwordVisible: false,
          errors: {}
      };
  },
  methods: {
      clearErrors(field) {
          if (this.errors[field]) {
              this.errors[field] = null;
          }
      },
      async loginUser() {
          try {
              const response = await axios.post(`${BASE_URL}/login`, {
                  email: this.email,
                  password: this.password
              });
              if (response.status === 201) {
                  const { access_token, user, additional_data } = response.data;
                  localStorage.setItem('auth_token', access_token);
                  localStorage.setItem('user', JSON.stringify(user));
                  // Store doctor_id or patient_id if available
                    if (additional_data) {
                        if (additional_data.doctor_id) {
                            localStorage.setItem('doctor_id', additional_data.doctor_id);
                        }
                        if (additional_data.patient_id) {
                            localStorage.setItem('patient_id', additional_data.patient_id);
                        }
                    }
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Successful!',
                      text: 'You will be redirected shortly.',
                      timer: 2000,
                      timerProgressBar: true,
                      showConfirmButton: false
                  });
                  setTimeout(() => {
                      if (user.role === 'admin') {
                          this.$router.push({ name: 'admin-dashboard' });
                      } else if (user.role === 'doctor') {
                          this.$router.push({ name: 'doctor-dashboard' });
                      } else if (user.role === 'patient') {
                          this.$router.push({ name: 'patient-dashboard' });
                      }
                  }, 2000);
              }
          } catch (error) {
              console.error('Error logging in:', error);
              Swal.fire({
                  icon: 'error',
                  title: 'Login Failed!',
                  text: 'Please check your credentials and try again.',
                  confirmButtonText: 'OK'
              });
          }
      }
  }
};
</script>

<style scoped>
</style>
