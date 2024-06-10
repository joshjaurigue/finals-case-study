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
  <div class="row justify-content-center">
<div class="col-md-6">
  <form @submit.prevent="createDoctor" class="shadow p-4">
    <h4 class="mb-4 text-center">Create Doctor</h4>
    <!-- Form fields for doctor data -->
    <div class="mb-3">
      <input type="text" class="form-control" v-model="doctor.name" placeholder="Enter Doctor's Name" @input="clearErrors('name')">
      <div class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</div>
    </div>
    <div class="mb-3">
      <input type="email" class="form-control" v-model="doctor.email" placeholder="Enter Doctor's Email" @input="clearErrors('email')">
      <div class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</div>
    </div>
    <!-- Add password field -->
    <div class="mb-3">
      <input type="password" class="form-control" v-model="doctor.password" placeholder="Enter Doctor's Password" @input="clearErrors('password')">
      <div class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</div>
    </div>
    <div class="mb-3">
      <input type="password" class="form-control" v-model="doctor.password_confirmation" placeholder="Confirm Password" @input="clearErrors('password')">
      <div class="text-danger" v-if="errors?.password_confirmation">{{ errors.password[0] }}</div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" v-model="doctor.first_name" placeholder="Enter Doctor's First Name" @input="clearErrors('first_name')">
      <div class="text-danger" v-if="errors?.first_name">{{ errors.first_name[0] }}</div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" v-model="doctor.middle_name" placeholder="Enter Doctor's Middle Name" @input="clearErrors('middle_name')">
      <div class="text-danger" v-if="errors?.middle_name">{{ errors.middle_name[0] }}</div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" v-model="doctor.last_name" placeholder="Enter Doctor's Last Name" @input="clearErrors('last_name')">
      <div class="text-danger" v-if="errors?.last_name">{{ errors.last_name[0] }}</div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" v-model="doctor.phone_number" placeholder="Enter Doctor's Phone Number" @input="clearErrors('phone_number')">
      <div class="text-danger" v-if="errors?.phone_number">{{ errors.phone_number[0] }}</div>
    </div>
    <div class="mb-3">
      <select class="form-select" v-model="doctor.specialization_id" @change="clearErrors('specialization_id')">
        <option value="" disabled>Select Specialization</option>
        <!-- Populate this select with specialization options from the backend -->
        <option v-for="specialization in specializations" :key="specialization.id" :value="specialization.id">{{ specialization.specialization_title }}</option>
      </select>
      <div class="text-danger" v-if="errors?.specialization_id">{{ errors.specialization_id[0] }}</div>
    </div>
    <!-- Include other doctor fields here -->
    <button type="submit" class="btn btn-primary w-100">Create Doctor</button>
  </form>
</div>
</div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from '@/axios';
import Swal from 'sweetalert2';

export default {
data() {
  return {
    doctor: {
      name: '',
      email: '',
      first_name: '',
      middle_name: '',
      last_name: '',
      password: '',
      password_confirmation: '',
      specialization_id: '',
      phone_number: ''
    },
    specializations: [], // To store the list of specializations
    errors: {}
  };
},
created() {
  this.fetchSpecializations(); // Fetch specialization options when the component is created
},
methods: {
  clearErrors(field) {
    if (this.errors[field]) {
      this.errors[field] = null;
    }
  },
  async fetchSpecializations() {
    try {
      const response = await axios.get(`${BASE_URL}/specializations`);
      this.specializations = response.data;
    } catch (error) {
      console.error('Failed to fetch specializations:', error);
    }
  },
  async createDoctor() {
    try {
      const response = await axios.post(`${BASE_URL}/admin/doctors/create`, this.doctor);
      if(response.status === 201) {
        Swal.fire(
          'Success',
          'Doctor created successfully',
          'success'
        );
      }
      this.$router.push({ name: 'doctor-list-admin' });
    } catch (error) {
      if (error.response && error.response.data) {
        this.errors = error.response.data.errors;
        Swal.fire(
          'Error',
          'There was a problem creating the doctor',
          'error'
        );
      } else {
        Swal.fire(
          'Error',
          'An unexpected error occurred. Please try again.',
          'error'
        ).then(() => {
          this.$router.push({ name: 'doctor-list-admin' });
        });
      }
    }
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