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

    <!-- Medical Records List -->
    <div>
      <h1>Medical Records List</h1>
      <table class="table">
        <thead>
          <tr>
            <th>Patient ID</th>
            <th>Patient Name</th>
            <th>Date of Birth</th>
            <th>Diagnosis</th>
            <th>Treatment</th>
            <th>Billing Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="record in records" :key="record.id">
            <td>{{ record.patient_id }}</td>
            <td>{{ record.patient_name }}</td>
            <td>{{ new Date(record.dob).toLocaleDateString() }}</td>
            <td>{{ record.diagnosis }}</td>
            <td>{{ record.treatment }}</td>
            <td>{{ record.billing_status }}</td>
            <td>
              <button class="btn btn-info btn-sm" @click="viewDetails(record.id)">View</button>
              <button class="btn btn-danger btn-sm" @click="deleteRecord(record.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
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
    this.fetchRecords();
  },
  methods: {
    async fetchRecords() {
      try {
        const response = await axios.get('/api/admin/medicalrecords');
        this.records = response.data;
      } catch (error) {
        console.error('There was an error fetching the medical records:', error);
      }
    },
    viewDetails(id) {
      this.$router.push({ name: 'view-medicalrecord-details', params: { id } });
    },
    async deleteRecord(id) {
      if (confirm('Are you sure you want to delete this record?')) {
        try {
          await axios.delete(`/api/admin/medicalrecords/${id}`);
          this.fetchRecords();
        } catch (error) {
          console.error('There was an error deleting the medical record:', error);
        }
      }
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

button {
  padding: 5px 10px;
}

.btn-info {
  background-color: #17a2b8;
  border: none;
}

.btn-info:hover {
  background-color: #138496;
}

.btn-danger {
  background-color: #dc3545;
  border: none;
}

.btn-danger:hover {
  background-color: #c82333;
}
</style>
