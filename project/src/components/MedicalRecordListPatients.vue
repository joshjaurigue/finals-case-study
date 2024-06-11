<template>
  <div>
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
                <li><router-link class="dropdown-item" :to="{ name: 'view-patient-details', params: { id: patientId } }">My Profile</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'appointment-list-patients' }">My Appointments</router-link></li>
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
                <li><router-link class="dropdown-item" :to="{ name: 'appointment-list-patients' }">My Appointments</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-appointment' }">Book an Appointment</router-link></li>
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
                <li><router-link class="dropdown-item" :to="{ name: 'medical-record-list-patients' }">My Medical Records</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>
          </ul>
          <!-- Logout Button -->
          <button class="btn btn-outline-danger" @click="logoutUser">Logout</button>
        </div>
      </div>
    </nav>

    <!-- Medical Records Section -->
    <div class="container mt-5">
      <h2 class="text-center mb-4">My Medical Records</h2>
      <div v-if="records.length" class="row row-cols-1 row-cols-md-2 g-4">
        <div v-for="record in records" :key="record.id" class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">Record Type: {{ record.type }}</h5>
              <p class="card-text"><strong>Date:</strong> {{ formatDate(record.record_date) }}</p>
              <p class="card-text"><strong>Doctor:</strong> {{ record.doctor_full_name }}</p>
              <p class="card-text"><strong>Details:</strong> {{ record.record }}</p>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center">
        <p>No medical records found.</p>
      </div>
    </div>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from '@/axios';

export default {
  data() {
    return {
      records: []
    };
  },
  computed: {
    patientId() {
      return localStorage.getItem('patient_id');
    }
  },
  methods: {
    fetchMedicalRecords() {
      axios.get(`http://127.0.0.1:8000/api/getPatientRecords/${this.patientId}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          'Custom-Header': 'CustomHeaderValue'  
        }
      })
      .then(response => {
        this.records = response.data;
      })
      .catch(error => {
        console.error('Error fetching medical records:', error);
      });
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString(undefined, options);
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
  },
  mounted() {
    this.fetchMedicalRecords();
  }
};
</script>

<style>
.container {
  max-width: 800px;
}
.card {
  margin: 10px 0;
}
</style>
