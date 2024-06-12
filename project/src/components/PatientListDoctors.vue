<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <!-- Navbrand -->
        <router-link class="navbar-brand" :to="{ name: 'doctor-dashboard' }">Hospital Management System</router-link>

        <!-- Toggler/collapsible Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- Dropdown for Patient Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPatient" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Patient Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownPatient">
                <li><router-link class="dropdown-item" :to="{ name: 'view-my-patients' }">My Patients</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>

            <!-- Dropdown for Doctor Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Doctor Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
                <li><router-link class="dropdown-item"
                    :to="{ name: 'view-doctor-profile-details', params: { id: doctorId } }">My Profile</router-link>
                </li>
                <li><router-link class="dropdown-item" :to="{ name: 'appointment-list-doctors' }">My
                    Appointments</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>

            <!-- Dropdown for Appointment Management -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAppointment" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Appointment Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownAppointment">
                <li><router-link class="dropdown-item" :to="{ name: 'appointment-list-doctors' }">My
                    Appointments</router-link></li>
                <!-- Add more items as needed -->
              </ul>
            </li>

            <!-- Dropdown for Medical Records-->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRecords" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Medical Records
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownRecords">
                <li><router-link class="dropdown-item" :to="{ name: 'medical-record-list-doctors' }">Medical
                    Records</router-link></li>
                <li><router-link class="dropdown-item" :to="{ name: 'create-medical-record' }">Create Medical
                    Records</router-link></li>
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
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
          <h2>My Patients</h2>
        </div>
        <div class="card-body">
          <div v-if="patients.length">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Phone</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="patient in patients" :key="patient.id">
                    <td>{{ patient.patient.id }}</td>
                    <td>{{ patient.patient.first_name }}</td>
                    <td>{{ patient.patient.last_name }}</td>
                    <td>{{ patient.patient.date_of_birth }}</td>
                    <td>{{ patient.patient.age }}</td>
                    <td>{{ patient.patient.sex }}</td>
                    <td>{{ patient.patient.address }}</td>
                    <td>{{ patient.patient.phone }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-else>
            <p class="text-center">No patients found.</p>
          </div>
        </div>
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
      patients: []
    };
  },
  computed: {
    doctorId() {
      return localStorage.getItem('doctor_id');
    }
  },
  created() {
    this.fetchPatients();
  },
  methods: {
    fetchPatients() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.get(`${BASE_URL}/doctor/myPatients`)
        .then(response => {
          console.log(response.data)
          this.patients = response.data;
        })
        .catch(error => {
          console.error('Error fetching patients:', error);
        });
    },
    logoutUser() {
      // Clear local storage items
      localStorage.removeItem('auth_token');
      localStorage.removeItem('doctor_id');

      // Redirect to login page or perform any other necessary action
      // For example, if you have a router, you can redirect to the login page:
      this.$router.push({ name: 'login' });

      console.log('User logged out');
    }
  }
};
</script>

<style scoped>
.card {
  border-radius: 10px;
  overflow: hidden;
}

.card-header {
  padding: 20px;
}

.card-body {
  padding: 30px;
}

.table {
  margin-top: 20px;
}

.thead-dark th {
  background-color: #343a40;
  color: white;
}
</style>