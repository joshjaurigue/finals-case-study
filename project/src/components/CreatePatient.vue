<template>

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

  <!-- Your existing template code -->
  <div class="container mt-5 bg-gray">
    <h2>Create Patient</h2>
    <form @submit.prevent="createPatient">
      <div class="row">
        <!-- First Column -->
        <div class="col-md-6">
          <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="number" class="form-control shadow-sm" id="user_id" v-model="patient.user_id" required>
          </div>
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control shadow-sm" id="first_name" v-model="patient.first_name">
          </div>
          <div class="mb-3">
            <label for="second_name" class="form-label">Second Name</label>
            <input type="text" class="form-control shadow-sm" id="second_name" v-model="patient.second_name">
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control shadow-sm" id="last_name" v-model="patient.last_name">
          </div>
          <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" class="form-control shadow-sm" id="date_of_birth" v-model="patient.date_of_birth">
          </div>
        </div>
        <!-- Second Column -->
        <div class="col-md-6">
          <div class="mb-3">
            <label for="place_of_birth" class="form-label">Place of Birth</label>
            <input type="text" class="form-control shadow-sm" id="place_of_birth" v-model="patient.place_of_birth">
          </div>
          <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control shadow-sm" id="age" v-model="patient.age">
          </div>
          <div class="mb-3">
            <label for="sex" class="form-label">Sex</label>
            <input type="text" class="form-control shadow-sm" id="sex" v-model="patient.sex">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control shadow-sm" id="address" v-model="patient.address">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control shadow-sm" id="phone" v-model="patient.phone">
          </div>
        </div>
          <div class="text-center">
          <button type="submit" class="btn btn-primary">Create Patient</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from '@/axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      patient: {
        user_id: '',
        first_name: '',
        second_name: '',
        last_name: '',
        date_of_birth: '',
        place_of_birth: '',
        age: '',
        sex: '',
        address: '',
        phone: ''
      }
    };
  },
  methods: {
    createPatient() {
      if (!this.patient.user_id || !this.patient.first_name || !this.patient.last_name || !this.patient.date_of_birth || !this.patient.place_of_birth || !this.patient.age || !this.patient.sex || !this.patient.address || !this.patient.phone) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'All fields are required!',
        });
        return;
      }

      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.post(`${BASE_URL}/patients`, this.patient)
        .then(response => {
          console.log('Patient created successfully:', response.data);
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Patient created successfully',
          });
          this.$emit('patientCreated');
          this.$router.push({ name: 'patient-list-admin' });
        })
        .catch(error => {
          console.error('Error creating patient:', error.response ? error.response.data : error.message);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again later.',
          });
        });
    }
  }
};
</script>

<style scoped>
.container {
  background-color: #f5f5f5; /* Gray background color */
}

.form-control {
  border: 1px solid black; /* Add black border to text fields */
}
</style>