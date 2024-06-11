<template>
  <div>
    <!-- Navbar -->
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
                <li><router-link class="dropdown-item" :to="{ name: 'user-list' }">User List</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-user' }">Create User</router-link></li>
              </ul>
            </li>

            <!-- Dropdown for Specialization Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSpecialization" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Specialization Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownSpecialization">
                <li><router-link class="dropdown-item" :to="{ name: 'specialization-list' }">Specialization List</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-specialization' }">Create Specialization</router-link></li>
              </ul>
            </li>

            <!-- Dropdown for Patient Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPatient" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Patient Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownPatient">
                <li><router-link class="dropdown-item" :to="{ name: 'patient-list-admin' }">Patient List</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-patient' }">Create Patient</router-link></li>
              </ul>
            </li>

            <!-- Dropdown for Doctor Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Doctor Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
                <li><router-link class="dropdown-item" :to="{ name: 'doctor-list-admin' }">Doctor List</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-doctor' }">Create Doctor</router-link></li>
              </ul>
            </li>

            <!-- Dropdown for Appointment Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAppointment" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Appointment Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownAppointment">
                <li><router-link class="dropdown-item" :to="{ name: 'appointments-admin' }">View Appointments</router-link></li>
              </ul>
            </li>

            <!-- Dropdown for Medical Records -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRecords" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Medical Records
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownRecords">
                <li><router-link class="dropdown-item" :to="{ name: 'view-medicalrecords-admin' }">Medical Records</router-link></li>
              </ul>
            </li>
          </ul>

          <!-- Logout Button -->
          <button class="btn btn-outline-danger" @click="logoutUser">Logout</button>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
      <h2 class="text-center mb-4">All Medical Records</h2>
      <div v-if="records.length">
        <table class="table">
          <thead>
            <tr>
              <th>Record Type</th>
              <th>Patient Name</th>
              <th>Doctor Name</th>
              <th>Details</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="record in sortedRecords" :key="record.id">
              <td>{{ record.type }}</td>
              <td>{{ record.patient_name }}</td>
              <td>{{ record.doctor_name }}</td>
              <td>{{ record.record }}</td>
              <td>{{ formatDate(record.record_date) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-center">
        <p>No medical records found.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      records: []
    };
  },
  mounted() {
    this.fetchMedicalRecords();
  },
  methods: {
    fetchMedicalRecords() {
      axios.get(`http://127.0.0.1:8000/api/getAdminRecords/`, {
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
      axios.post(`${process.env.VUE_APP_BASE_URL}/logout`)
        .then(() => {
          localStorage.clear();
          this.$router.push('/');
        })
        .catch(error => {
          console.error('Error logging out:', error);
        });
    }
  },
  computed: {
    sortedRecords() {
      // Sort records based on doctor's name
      return this.records.slice().sort((a, b) => a.doctor_name.localeCompare(b.doctor_name));
    }
  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

thead {
  background-color: #f5f5f5;
}

th, td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ddd;
}

</style>
