<template>
  <div>
    <!-- Navigation -->
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
    
            <!-- Dropdown for Appointment Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAppointment" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Specialization Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownAppointment">
                <li><router-link class="dropdown-item" :to="{name: 'specialization-list'}">Specialization List</router-link></li>
                <li><router-link class="dropdown-item" :to="{name: 'create-specialization'}">Create Specialization</router-link></li>
              </ul>
            </li>
    
            <!-- Dropdown for Patient Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPatient" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Patient Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownPatient">
                <li><router-link class="dropdown-item" :to="{name: 'patient-list-admin'}">Patient List</router-link></li>
                <li><router-link class="dropdown-item" :to="{name: 'create-patient'}">Create Patient</router-link></li>
              </ul>
            </li>
  
            <!-- Dropdown for Medical Records -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRecords" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Doctor Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownRecords">
                <li><router-link class="dropdown-item" :to="{name: 'doctor-list-admin'}">Doctor List</router-link></li>
                <li><router-link class="dropdown-item" :to="{name: 'create-doctor'}">Create Doctor</router-link></li>
              </ul>
            </li>
  
            <!-- Dropdown for Appointment Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Appointment Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
                <li><router-link class="dropdown-item" :to="{name: 'appointments-admin'}">View Appointments</router-link></li>
              </ul>
            </li>

             <!-- Dropdown for Medical Records -->
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Medical Records
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
                <li><router-link class="dropdown-item" :to="{name: 'view-medicalrecords-admin'}">Medical Records</router-link></li>
              </ul>
            </li>
          </ul>
    
          <!-- Logout Button -->
          <button class="btn btn-outline-danger" @click="logoutUser">Logout</button>
        </div>
      </div>
    </nav>

    <!-- Patient List -->
    <div class="container mt-5">
      <h2>Patient List</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Second Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Place of Birth</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(patient, index) in patients" :key="patient.id">
            <td>{{ index + 1 }}</td>
            <td>{{ patient.first_name }}</td>
            <td>{{ patient.second_name }}</td>
            <td>{{ patient.last_name }}</td>
            <td>{{ patient.date_of_birth }}</td>
            <td>{{ patient.place_of_birth }}</td>
            <td>{{ patient.age }}</td>
            <td>{{ patient.sex }}</td>
            <td>{{ patient.address }}</td>
            <td>{{ patient.phone }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="viewPatient(patient.id)">View</button>
              <button class="btn btn-danger btn-sm" @click="deletePatient(patient.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from '@/axios';

export default {
  data() {
    return {
      patients: [],
    };
  },
  created() {
    this.fetchPatients();
  },
  methods: {
    fetchPatients() {
  axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

  axios.get(`${BASE_URL}/patients`)
    .then(response => {
      console.log('Fetched patients:', response.data); // Log the fetched patients
      this.patients = response.data; // Update patients data property
    })
    .catch(error => {
      console.error('Error fetching patients:', error.response ? error.response.data : error.message);
    });
},
    viewPatient(id) {
      this.$router.push({ name: 'patient-details', params: { id } });
    },
    deletePatient(id) {
      if (confirm('Are you sure you want to delete this patient?')) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

        axios.delete(`${BASE_URL}/patients/${id}`)
          .then(() => {
            this.patients = this.patients.filter(patient => patient.id !== id);
          })
          .catch(error => {
            console.error('Error deleting patient:', error.response ? error.response.data : error.message);
          });
      }
    },
    logoutUser() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.post(`${BASE_URL}/logout`)
        .then(() => {
          localStorage.clear();
          this.$router.push('/');
        })
        .catch(error => {
          console.error('Error logging out:', error);
        });
    }
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
}
.table {
  margin-top: 20px;
}
</style>

