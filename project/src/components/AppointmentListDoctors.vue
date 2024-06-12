<template>
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
              <!-- Edit the routes manually -->
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
              <!-- Edit the routes manually -->
              <li><router-link class="dropdown-item"
                  :to="{ name: 'view-doctor-profile-details', params: { id: doctorId } }">My Profile</router-link></li>
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
              <!-- Edit the routes manually -->
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
              <!-- Edit the routes manually -->
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
        <h2>My Appointments</h2>
      </div>
      <div class="card-body">
        <div v-if="datas.length">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="data in datas" :key="data.id">
                <td>{{ data.appointment.id }}</td>
                <td>
                  {{ data.patient.first_name ?
                    data.patient.first_name + " " +
                    (data.patient.middle_name ? data.patient.middle_name + " " : "") +
                    (data.patient.last_name ? data.patient.last_name : "")
                    :
                    data.user_name }}
                </td>
                <td>{{ new Date(data.appointment.appointment_date).toLocaleDateString() }}</td>
                <td>{{ data.appointment.status }}</td>
                <td> <button v-show="data.appointment.status == 'scheduled'"
                    @click="completeAppointment(data.appointment.id)" class="btn btn-success">Complete</button> </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else>
          <p>No appointments found.</p>
        </div>
      </div>
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
      datas: []
    };
  },
  computed: {
    doctorId() {
      return localStorage.getItem('doctor_id');
    }
  },
  methods: {
    fetchDatas() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;
      axios.get(`${BASE_URL}/doctor/appointments`)
        .then(response => {
          console.log(response)
          this.datas = response.data;
        })
        .catch(error => {
          console.error('Error fetching appointments:', error);
        });
    },
    completeAppointment(appointmentId) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.patch(`${BASE_URL}/doctor/completeAppointment/${appointmentId}`)
        .then(() => {
          this.fetchDatas();
          Swal.fire({
            icon: 'success',
            title: 'Appointment completed successfully!',
            text: 'You have successfully completed your appointment.',
            confirmButtonText: 'OK'
          });
        })
        .catch(error => {
          console.error('Error canceling appointment:', error);
        });
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
  created() {
    this.fetchDatas();
  },
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}
</style>