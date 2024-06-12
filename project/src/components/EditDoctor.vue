<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Navbrand -->
      <router-link class="navbar-brand" :to="{ name: 'doctor-dashboard' }">Hospital Management System</router-link>
  
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
              <li><router-link class="dropdown-item" :to="{name: 'view-my-patients'}">My Patients</router-link></li>
              <!-- Add more items as needed -->
            </ul>
          </li>
  
          <!-- Dropdown for Doctor Management -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDoctor" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Doctor Management
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownDoctor">
              <!-- Edit the routes manually -->
              <li><router-link class="dropdown-item" :to="{name: 'view-doctor-profile-details',  params: { id: doctorId }}">My Profile</router-link></li>
              <li><router-link class="dropdown-item" :to="{name: 'appointment-list-doctors'}">My Appointments</router-link></li>
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
              <li><router-link class="dropdown-item" :to="{name: 'appointment-list-doctors'}">My Appointments</router-link></li>
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
              <li><router-link class="dropdown-item" :to="{name: 'medical-record-list-doctors'}">Medical Records</router-link></li>
              <li><router-link class="dropdown-item" :to="{name: 'create-medical-record'}">Create Medical Records</router-link></li>
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
      <form @submit.prevent="updateProfile" class="shadow p-4">
        <h4 class="mb-4 text-center">Edit Profile</h4>

        <!-- Name -->
        <div class="mb-3">
          <input type="text" class="form-control" v-model="doctor.user.name" placeholder="Enter Name" @input="clearErrors('user.name')">
          <div class="text-danger" v-if="errors?.['user.name']">{{ errors['user.name'][0] }}</div>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <input type="email" class="form-control" v-model="doctor.user.email" placeholder="Enter Email" @input="clearErrors('user.email')">
          <div class="text-danger" v-if="errors?.['user.email']">{{ errors['user.email'][0] }}</div>
        </div>

        <!-- Password -->
        <div class="mb-3">
          <input :type="showPassword ? 'text' : 'password'" class="form-control" v-model="doctor.password" placeholder="Enter Password" @input="clearErrors('password')">
          <div class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</div>
        </div>

        <!-- Show Password Checkbox -->
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" v-model="showPassword" id="showPassword">
          <label class="form-check-label" for="showPassword">Show Password</label>
        </div>

        <!-- Password Confirmation -->
        <div class="mb-3">
          <input :type="showConfirmPassword ? 'text' : 'password'" class="form-control" v-model="doctor.password_confirmation" placeholder="Confirm Password" @input="clearErrors('password_confirmation')">
        </div>

        <!-- Show Confirm Password Checkbox -->
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" v-model="showConfirmPassword" id="showConfirmPassword">
          <label class="form-check-label" for="showConfirmPassword">Show Confirm Password</label>
        </div>

        <!-- First Name -->
        <div class="mb-3">
          <input type="text" class="form-control" v-model="doctor.first_name" placeholder="Enter First Name" @input="clearErrors('first_name')">
          <div class="text-danger" v-if="errors?.first_name">{{ errors.first_name[0] }}</div>
        </div>

        <!-- Last Name -->
        <div class="mb-3">
          <input type="text" class="form-control" v-model="doctor.last_name" placeholder="Enter Last Name" @input="clearErrors('last_name')">
          <div class="text-danger" v-if="errors?.last_name">{{ errors.last_name[0] }}</div>
        </div>

        <!-- Specialization Combobox -->
        <div class="mb-3">
          <select class="form-select" v-model="doctor.specialization_id" @change="clearErrors('specialization_id')">
            <option value="" disabled>Select Specialization</option>
            <option v-for="specialization in specializations" :key="specialization.id" :value="specialization.id">
              {{ specialization.specialization_title }}
            </option>
          </select>
          <div class="text-danger" v-if="errors?.specialization_id">{{ errors.specialization_id[0] }}</div>
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
          <input type="text" class="form-control" v-model="doctor.phone_number" placeholder="Enter Phone Number" @input="clearErrors('phone_number')">
          <div class="text-danger" v-if="errors?.phone_number">{{ errors.phone_number[0] }}</div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
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
      doctor: {
        user: {
          name: '',
          email: ''
        },
        password: '',
        password_confirmation: '',
        first_name: '',
        last_name: '',
        specialization_id: '',
        phone_number: ''
      },
      specializations: [],
      errors: {},
      showPassword: false, // To toggle password visibility
      showConfirmPassword: false // To toggle confirm password visibility
    };
  },
  mounted() {
    this.fetchProfile();
    this.fetchSpecializations();
  },
  methods: {
    async fetchProfile() {
      try {
        const response = await axios.get(`${BASE_URL}/doctors/my-profile`);
        this.doctor = response.data;
      } catch (error) {
        console.error('Error fetching doctor profile:', error);
      }
    },
    async fetchSpecializations() {
      try {
        const response = await axios.get(`${BASE_URL}/specializations`);
        this.specializations = response.data;
      } catch (error) {
        console.error('Failed to fetch specializations:', error);
      }
    },
    clearErrors(field) {
      if (this.errors[field]) {
        this.errors[field] = null;
      }
    },
    async updateProfile() {
      try {
        const response = await axios.put(`${BASE_URL}/doctors/update-profile`, this.doctor);
        if (response.status === 201) {
          Swal.fire(
            'Success',
            'Profile updated successfully',
            'success'
          ).then(() => {
              this.$router.push({ name: 'view-doctor-profile-details' });
            });
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.errors = error.response.data.errors;
          Swal.fire(
            'Error',
            'Please check your input and try again.',
            'error'
          )
        } else {
          console.error('An unexpected error occurred:', error);
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

