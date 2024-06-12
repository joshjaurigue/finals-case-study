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
      <div v-if="records.length">
        <div class="table-responsive">
          <table class="table w-100">
            <thead>
              <tr>
                <th @click="sortBy('type')">Record Type</th>
                <th @click="sortBy('doctor_full_name')">Doctor</th>
                <th>Details</th>
                <th @click="sortBy('record_date')">Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="record in sortedRecords" :key="record.id">
                <td>{{ record.type }}</td>
                <td>{{ record.doctor_full_name }}</td>
                <td>{{ record.record }}</td>
                <td>{{ formatDate(record.record_date) }}</td>
              </tr>
            </tbody>
          </table>
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
      records: [],
      sortKey: 'doctor_full_name',
      sortOrder: 'asc'
    };
  },
  computed: {
    patientId() {
      return localStorage.getItem('patient_id');
    },
    sortedRecords() {
      return this.records.slice().sort((a, b) => {
        let modifier = 1;
        if (this.sortOrder === 'desc') modifier = -1;
        if (a[this.sortKey] < b[this.sortKey]) return -1 * modifier;
        if (a[this.sortKey] > b[this.sortKey]) return 1 * modifier;
        return 0;
      });
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
    sortBy(key) {
      if (this.sortKey === key) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortKey = key;
        this.sortOrder = 'asc';
      }
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

<style scoped>
.table-responsive {
  max-height: 500px;
  overflow-y: auto;
}

.table th {
  cursor: pointer;
}
</style>
