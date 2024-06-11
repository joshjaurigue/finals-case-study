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
<!-- Medical Records Section -->
<div class="container mt-5">
      <h2 class="text-center mb-4">All Medical Records</h2>
      <div v-if="records.length" class="row row-cols-1 row-cols-md-2 g-4">
        <div v-for="record in records" :key="record.id" class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">Record Type: {{ record.type }}</h5>
              <p class="card-text"><strong>Details:</strong> {{ record.record }}</p>
              <p class="card-text"><strong>Patient Name:</strong> {{ record.patient_name }}</p>
              <p class="card-text"><strong>Doctor Name:</strong> {{ record.doctor_name }}</p>
              <p class="card-text"><strong>Date:</strong> {{ formatDate(record.record_date) }}</p>

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
import axios from 'axios';
import Swal from 'sweetalert2';

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
    async deleteRecord(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`/api/admin/medicalrecords/${id}`);
            this.fetchRecords();
            Swal.fire(
              'Deleted!',
              'Your record has been deleted.',
              'success'
            );
          } catch (error) {
            console.error('There was an error deleting the medical record:', error);
            Swal.fire(
              'Error!',
              'An error occurred while deleting the record.',
              'error'
            );
          }
        }
      });
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
