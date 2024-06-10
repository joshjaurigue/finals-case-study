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

  <div class="row justify-content-center">
    <div class="col-md-6">
      <form @submit.prevent="updatePatient" class="shadow p-4">
        <h4 class="mb-4 text-center">Edit Patient</h4>
        <!-- Form fields for patient data pre-filled with current data -->
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.name" placeholder="Enter your Name" @input="clearErrors('name')">
          <div class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="email" class="form-control" v-model="form.email" placeholder="Enter your Email" @input="clearErrors('email')">
          <div class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</div>
        </div>
        <!-- Repeat similar blocks for all other patient fields -->
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.first_name" placeholder="First Name" @input="clearErrors('first_name')">
          <div class="text-danger" v-if="errors?.first_name">{{ errors.first_name[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.middle_name" placeholder="Middle Name" @input="clearErrors('middle_name')">
          <div class="text-danger" v-if="errors?.middle_name">{{ errors.middle_name[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.last_name" placeholder="Last Name" @input="clearErrors('last_name')">
          <div class="text-danger" v-if="errors?.last_name">{{ errors.last_name[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="date" class="form-control" v-model="form.date_of_birth" placeholder="Date of Birth" @input="clearErrors('date_of_birth')">
          <div class="text-danger" v-if="errors?.date_of_birth">{{ errors.date_of_birth[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.place_of_birth" placeholder="Place of Birth" @input="clearErrors('place_of_birth')">
          <div class="text-danger" v-if="errors?.place_of_birth">{{ errors.place_of_birth[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="number" class="form-control" v-model="form.age" placeholder="Age" @input="clearErrors('age')">
          <div class="text-danger" v-if="errors?.age">{{ errors.age[0] }}</div>
        </div>
        <div class="mb-3">
          <select class="form-select" v-model="form.sex" @change="clearErrors('sex')">
            <option value="" disabled>Select Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <div class="text-danger" v-if="errors?.sex">{{ errors.sex[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.address" placeholder="Address" @input="clearErrors('address')">
          <div class="text-danger" v-if="errors?.address">{{ errors.address[0] }}</div>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" v-model="form.phone" placeholder="Phone" @input="clearErrors('phone')">
          <div class="text-danger" v-if="errors?.phone">{{ errors.phone[0] }}</div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Patient</button>
      </form>
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
    form: {
      name: '',
      email: '',
      first_name: '',
      middle_name: '',
      last_name: '',
      date_of_birth: '',
      place_of_birth: '',
      age: '',
      sex: 'Male',
      address: '',
      phone: ''
    },
    errors: {}
  };
},
created() {
  this.fetchPatient();
},
methods: {
  clearErrors(field) {
    if (this.errors[field]) {
      this.errors[field] = null;
    }
  },
  async fetchPatient() {
    try {
      const response = await axios.get(`${BASE_URL}/admin/patients/${this.$route.params.id}`);
      const patient = response.data;
      this.form.name = patient.user.name;
      this.form.email = patient.user.email;
      this.form.first_name = patient.first_name;
      this.form.middle_name = patient.middle_name;
      this.form.last_name = patient.last_name;
      this.form.date_of_birth = patient.date_of_birth;
      this.form.place_of_birth = patient.place_of_birth;
      this.form.age = patient.age;
      this.form.sex = patient.sex;
      this.form.address = patient.address;
      this.form.phone = patient.phone;
    } catch (error) {
      console.error(error);
    }
  },
  async updatePatient() {
    try {
      const response = await axios.put(`${BASE_URL}/admin/patients/edit/${this.$route.params.id}`, this.form);
      if(response.status === 201) {
        Swal.fire(
        'Success',
        'Patient updated successfully',
        'success'
      );
      }
      this.$router.push({ name: 'patient-list-admin' });
    } catch (error) {
      if (error.response && error.response.data) {
        this.errors = error.response.data.errors;
        Swal.fire(
          'Error',
          'There was a problem updating the patient',
          'error'
        );
      } else {
        Swal.fire(
          'Error',
          'An unexpected error occurred. Please try again.',
          'error'
        ).then(() => {
          this.$router.push({ name: 'patient-list-admin' });
        });
      }
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
}
};
</script>
