<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Navbrand -->
      <router-link class="navbar-brand" :to="{ name: 'patient-dashboard' }">Hospital Management System</router-link>
  
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
              <li><router-link class="dropdown-item" :to="{name: 'view-patient-details', params: { id: patientId }}">My Profile</router-link></li>
              <li><router-link class="dropdown-item" :to="{name: 'appointment-list-patients'}">My Appointments</router-link></li>
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
              <li><router-link class="dropdown-item" :to="{name: 'appointment-list-patients'}">My Appointments</router-link></li>
              <li><router-link class="dropdown-item" :to="{name: 'create-appointment'}">Book an Appointment</router-link></li>
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
              <li><router-link class="dropdown-item" :to="{name: 'medical-record-list-patients'}">My Medical Records</router-link></li>
              <!-- Add more items as needed -->
            </ul>
          </li> 
        </ul>
        <!-- Logout Button -->
        <button class="btn btn-outline-danger" @click="logoutUser">Logout</button>
      </div>
    </div>
  </nav>

  <div class="container">
      <h1>My Patient Profile Details</h1>
      <div v-if="loading" class="mt-3">Loading...</div>
      <div v-else-if="error" class="mt-3">{{ error }}</div>
      <div v-else class="mt-3">
        <p><strong>Name:</strong> {{ patient.user.name }}</p>
        <p><strong>Email:</strong> {{ patient.user.email }}</p>
        <p><strong>First Name:</strong> {{ patient.first_name }}</p>
        <p><strong>Middle Name:</strong> {{ patient.middle_name }}</p>
        <p><strong>Last Name:</strong> {{ patient.last_name }}</p>
        <p><strong>Date of Birth:</strong> {{ patient.date_of_birth }}</p>
        <p><strong>Place of Birth:</strong> {{ patient.place_of_birth }}</p>
        <p><strong>Age:</strong> {{ patient.age }}</p>
        <p><strong>Sex:</strong> {{ patient.sex }}</p>
        <p><strong>Address:</strong> {{ patient.address }}</p>
        <p><strong>Phone:</strong> {{ patient.phone }}</p>
        <p><strong>Diagnosis:</strong> {{ diagnosis }}</p>
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
      patient: {},
      loading: true,
      error: null
    };
  },
  mounted() {
    this.fetchProfile();
  },
computed: {
  patientId() {
    return localStorage.getItem('patient_id');
  }, 
  diagnosis() {
      return this.patient.diagnosis !== null ? this.patient.diagnosis : 'None';
    }
},
methods: {
  fetchProfile() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.get(`${BASE_URL}/patients/${this.patientId}`)
        .then(response => {
          this.patient = response.data;
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
          if (error.response && error.response.status === 404) {
            this.error = 'Patient not found';
          } else {
            this.error = 'An error occurred while fetching data';
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'An error occurred while fetching data!',
            });
          }
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
