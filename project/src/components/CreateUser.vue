<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <!-- Navbrand -->
        <router-link class="navbar-brand" :to="{ name: 'admin-dashboard' }">Hospital Management System</router-link>
    
        <!-- Toggler/collapsible Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- Dropdown for User Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                User Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                <!-- Edit the routes manually -->
                <li><router-link class="dropdown-item" :to="{ name: 'user-list' }">User List</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-user' }">Create User</router-link></li>
              </ul>
            </li>
    
            <!-- Dropdown for Appointment Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAppointment" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Specialization Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownAppointment">
                <!-- Edit the routes manually -->
                <li><router-link class="dropdown-item" :to="{name: 'specialization-list'}">Specialization List</router-link></li>
                <li><router-link class="dropdown-item" :to="{name: 'create-specialization'}">Create Specialization</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>
    
            <!-- Dropdown for Patient Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPatient" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Patient Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownPatient">
                <!-- Edit the routes manually -->
                <li><router-link class="dropdown-item" :to="{name: 'patient-list-admin'}">Patient List</router-link></li>
                <li><router-link class="dropdown-item" :to="{name: 'create-patient'}">Create Patient</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>
  
            <!-- Dropdown for Medical Records -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRecords" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Doctor Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownRecords">
                <!-- Edit the routes manually -->
                <li><router-link class="dropdown-item" :to="{name: 'doctor-list-admin'}">Doctor List</router-link></li>
                <li><router-link class="dropdown-item" :to="{name: 'create-doctor'}">Create Doctor</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>
  
            <!-- Dropdown for Doctor Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Appointment Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
                <!-- Edit the routes manually -->
                <li><router-link class="dropdown-item" :to="{name: 'appointments-admin'}">View Appointments</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>

             <!-- Dropdown for Doctor Management -->
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Medical Records
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
                <!-- Edit the routes manually -->
                <li><router-link class="dropdown-item" :to="{name: 'view-medicalrecords-admin'}">Medical Records</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>
          </ul>
    
          <!-- Logout Button -->
          <button class="btn btn-outline-danger" @click="logoutUser">Logout</button>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <form @submit.prevent="createUser" class="shadow p-4">
              <h4 class="mb-4 text-center">Create User</h4>
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
              <button type="submit" class="btn btn-primary w-100">Create User</button>
            </form>
          </div>
        </div>
      </div>
  </template>
  
  <script>
import { BASE_URL } from '@/config';
import axios from '@/axios';
import Swal from 'sweetalert2';

export default {
  name: 'CreateUserPage',
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
    async createUser() {
      try {
        const response = await axios.post(`${BASE_URL}/users`, {
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
            title: 'User created successfully!',
            text: 'You have successfully created a user.',
            confirmButtonText: 'OK'
          }).then(() => {
            this.$router.push({ name: 'admin-dashboard' });
          });
        }
      } catch (error) {
        console.log('Error response:', error.response);
        if (error.response && error.response.data) {
          this.errors = error.response.data;
          Swal.fire({
            icon: 'error',
            title: 'User Creation Failed',
            text: 'Please check your input and try again.',
            confirmButtonText: 'OK'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'User Creation Failed',
            text: 'An unexpected error occurred. Please try again.',
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
    },
    logoutUser() {
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      // Call the logout API
      axios.post(`${BASE_URL}/logout`)
        .then(() => {
          // Clear localStorage
          localStorage.clear();
          // Redirect to login page
          this.$router.push('/');
        })
        .catch(error => {
          console.error('Error logging out:', error);
        });
    }
  }
};
</script>

<style scoped>
/* Add any styles you need */
</style>
  