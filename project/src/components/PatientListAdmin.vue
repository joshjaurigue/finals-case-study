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

  <h1>Patient List</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="patient in patients" :key="patient.id">
        <td>{{ patient.first_name }}</td>
        <td>{{ patient.middle_name }}</td>
        <td>{{ patient.last_name }}</td>
        <td>{{ patient.user.email }}</td>
        <td>{{ patient.date_of_birth }}</td>
        <td>{{ patient.age }}</td>
        <td>{{ patient.sex }}</td>
        <td>{{ patient.address }}</td>
        <td>{{ patient.phone }}</td>
        <td>
          <router-link :to="{ name: 'edit-patient-admin', params: { id: patient.id } }" class="btn btn-primary btn-sm">Edit</router-link>
          <button @click="deletePatient(patient.id)" class="btn btn-danger btn-sm">Delete</button>
        </td>
      </tr>
    </tbody>
  </table>

</template>

<script>
import { BASE_URL } from '@/config';
import axios from '@/axios';
import Swal from 'sweetalert2';  

export default {
  data() {
    return {
      patients: []
    };
  },
  created() {
    this.fetchPatients();
  },
  methods: {
    fetchPatients() {
      axios.get(`${BASE_URL}/admin/patients`)
        .then(response => {
          this.patients = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    deletePatient(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`${BASE_URL}/admin/patients/delete/${id}`)
            .then(() => {
              Swal.fire(
                'Deleted!',
                'Patient has been deleted.',
                'success'
              );
              this.fetchPatients();
            })
            .catch(error => {
              Swal.fire(
                'Error!',
                error.response.data.message || 'There was a problem deleting the patient.',
                'error'
              );
              console.error('Error deleting patient:', error); // Log the error for debugging
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
