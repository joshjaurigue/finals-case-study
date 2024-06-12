<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Navbrand -->
      <router-link class="navbar-brand" :to="{ name: 'patient-dashboard' }">Hospital Management System</router-link>

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
              <li><router-link class="dropdown-item"
                  :to="{ name: 'view-patient-details', params: { id: patientId } }">My
                  Profile</router-link></li>
              <li><router-link class="dropdown-item" :to="{ name: 'appointment-list-patients' }">My
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
              <li><router-link class="dropdown-item" :to="{ name: 'appointment-list-patients' }">My
                  Appointments</router-link></li>
              <li><router-link class="dropdown-item" :to="{ name: 'create-appointment' }">Book an
                  Appointment</router-link></li>
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
              <li><router-link class="dropdown-item" :to="{ name: 'medical-record-list-patients' }">My Medical
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
                <th>Doctor</th>
                <th>Specialization</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="data in datas" :key="data.id">
                <td>{{ data.appointment.id }}</td>
                <td>
                  {{ data.doctor.first_name ?
                    data.doctor.first_name + " " +
                    (data.doctor.middle_name ? data.doctor.middle_name + " " : "") +
                    (data.doctor.last_name ? data.doctor.last_name : "")
                    : data.user_name }}
                </td>
                <td>{{ data.specialization.specialization_title }}</td>
                <td>{{ new Date(data.appointment.appointment_date).toLocaleDateString() }}</td>
                <td>{{ data.appointment.status }}</td>
                <td>
                  <router-link v-show="data.appointment.status == 'scheduled'"
                    :to="{ name: 'edit-appointment-patients', params: { id: data.appointment.id } }"
                    class="btn btn-warning text-white">Reschedule</router-link>
                  <button v-show="data.appointment.status == 'scheduled'"
                    @click="cancelAppointment(data.appointment.id)" class="btn btn-danger">Cancel</button>
                </td>
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
    patientId() {
      return localStorage.getItem('patient_id');
    }
  },
  created() {
    this.fetchDatas();
  },
  methods: {
    fetchDatas() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.get(`${BASE_URL}/patient/appointments`)
        .then(response => {
          console.log(response.data)
          this.datas = response.data;
        })
        .catch(error => {
          console.error('Error fetching appointments:', error);
        });
    },
    cancelAppointment(appointmentId) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`;

      axios.delete(`${BASE_URL}/patient/cancelAppointment/${appointmentId}`)
        .then(() => {
          this.fetchDatas();
          Swal.fire({
            icon: 'success',
            title: 'Appointment cancelled successfully!',
            text: 'You have successfully cancelled your appointment.',
            confirmButtonText: 'OK'
          });
        })
        .catch(error => {
          Swal.fire({
            icon: 'warning',
            title: 'Cannot Cancel Appointment!',
            text: 'Today is the schedule of your appointment.',
            confirmButtonText: 'OK'
          });
          console.error('Error canceling appointment:', error);
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

<style scoped>
.container {
  max-width: 800px;
}

.table {
  margin-top: 20px;
}

.thead-dark th {
  background-color: #343a40;
  color: white;
}
</style>