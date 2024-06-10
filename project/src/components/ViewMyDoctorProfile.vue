<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Navbrand -->
      <router-link class="navbar-brand" :to="{ name: 'doctor-dashboard' }">Hospital Management System</router-link>
  
      <!-- Toggler/collapsible Button -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- Dropdown for Patient Management -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPatient" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Patient Management
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownPatient">
              <!-- Edit the routes manually -->
              <li><router-link class="dropdown-item" :to="{name: 'view-my-patients'}">My Patients</router-link></li>
              <!-- Add more items as needed -->
            </ul>
          </li>
  
          <!-- Dropdown for Doctor Management -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Doctor Management
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
              <!-- Edit the routes manually -->
              <li><router-link class="dropdown-item" :to="{name: 'view-doctor-profile-details',  params: { id: doctorId }}">My Profile</router-link></li>
              <li><router-link class="dropdown-item" :to="{name: 'appointment-list-doctors'}">My Appointments</router-link></li>
              <!-- Add more items as needed -->
            </ul>
          </li>

          <!-- Dropdown for Appointment Management -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAppointment" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Appointment Management
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownAppointment">
              <!-- Edit the routes manually -->
              <li><router-link class="dropdown-item" :to="{name: 'appointment-list-doctors'}">My Appointments</router-link></li>
              <!-- Add more items as needed -->
            </ul>
          </li>

          <!-- Dropdown for Medical Records-->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRecords" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Medical Records
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownRecords">
              <!-- Edit the routes manually -->
              <li><router-link class="dropdown-item" :to="{name: 'medical-record-list-doctors'}">Medical Records</router-link></li>
              <li><router-link class="dropdown-item" :to="{name: 'create-medical-record'}">Create Medical Records</router-link></li>
              <!-- Add more items as needed -->
            </ul>
          </li>
        </ul>
        <!-- Logout Button -->
        <button class="btn btn-outline-danger" @click="logoutUser">Logout</button>
      </div>
    </div>
  </nav>

  <!-- Edit Profile Button-->
  <router-link class="btn btn-primary" :to="{ name: 'edit-doctor-profile', params: {id: doctorId}}">Edit Profile</router-link>


  <div class="container mt-5">
    <h1>Your Profile Details</h1>
    <div v-if="loading" class="mt-3">Loading...</div>
    <div v-else-if="error" class="mt-3">{{ error }}</div>
    <div v-else class="mt-3">
      <p><strong>Name:</strong> {{ doctor.user.name }}</p>
      <p><strong>Email:</strong> {{ doctor.user.email }}</p>
      <p><strong>First Name:</strong> {{ doctor.first_name }}</p>
      <p><strong>Last Name:</strong> {{ doctor.last_name }}</p>
      <p><strong>Specialization:</strong> {{ specializationTitle }}</p>
      <p><strong>Phone Number:</strong> {{ doctor.phone_number }}</p>
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
    doctor: {},
    specialization: {},
    loading: true,
    error: null
  };
},
mounted() {
  this.fetchProfile();
},
computed: {
  doctorId() {
    return localStorage.getItem('doctor_id');
  },
  specializationTitle() {
    return this.specialization.specialization_title || 'None';
  }
},
methods: {
  fetchProfile() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

    axios.get(`${BASE_URL}/doctors/my-profile`)
      .then(response => {
        this.doctor = response.data;
        this.fetchSpecialization();
        this.loading = false;
      })
      .catch(() => {
        this.loading = false;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'An error occurred while fetching data!',
        });
      });
  },
  fetchSpecialization() {
    axios.get(`${BASE_URL}/specializations/${this.doctor.specialization_id}`)
      .then(response => {
        this.specialization = response.data.specialization_data;
      })
      .catch(error => {
        console.error('Error fetching specialization:', error);
      });
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
