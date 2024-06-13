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
  <div class="space-y-2">
    <div class="flex justify-between">
      <div>
        <h1 class="font-semibold text-2xl text-gray-800">Edit Medical Record</h1>
      </div>
      <div>
        <button
          class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-200"
          @click="goToRecords"
        >
          <v-icon name="md-arrowbackiosnew-round" class="mr-1"></v-icon>
          Back
        </button>
      </div>
    </div>

    <div class="flex flex-col space-y-4 p-4 bg-white rounded-lg shadow-md">
      <div class="space-y-5">
        <!-- Record Type -->
        <div>
          <label for="type" class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Record Type:</label>
          <select id="type" v-model="record.type" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5">
            <option value="diagnosis">Diagnosis</option>
            <option value="prescription">Prescription</option>
            <option value="treatment">Treatment</option>
          </select>
        </div>

        <!-- Record Date -->
        <div>
          <label for="recordDate" class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Record Date:</label>
          <input type="datetime-local" id="recordDate" v-model="record.recordDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        </div>

        <!-- Patient Name -->
        <div>
          <label for="patientName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white font-bold">Patient Name:</label>
          <input type="text" id="patientName" v-model="record.patientName" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        </div>

        <!-- Details -->
        <div>
          <label for="details" class="block mb-2 text-sm font-medium text-gray-600 dark:text-white font-bold">Details:</label>
          <input type="text" id="details" v-model="record.details" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"/>
        </div>
      </div>
    </div>
    <div class="flex justify-end">
      <button
        @click="updateRecord"
        class="px-4 py-2 text-black bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-500 font-medium"
      >
        Update
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "EditMedicalRecord",

  data() {
    return {
      recordId: null,
      record: {
        type: "",
        recordDate: "",
        patientName: "",
        details: ""
      }
    };
  },

  methods: {
    goToRecords() {
      this.$router.push("/doctor/records").then(() => {
        window.location.reload();
      });
    },

    updateRecord() {
      axios.put(`http://127.0.0.1:8000/api/updateRecord/${this.recordId}`, {
        type: this.record.type,
        record_date: this.record.recordDate,
        record: this.record.details
      }, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      .then(() => {
        Swal.fire({
          title: 'Success',
          text: 'Medical record updated successfully',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          this.$router.push(`/doctor/records`);
        });
      })
      .catch(error => {
        console.error(error);
        Swal.fire({
          title: 'Error',
          text: 'Failed to update medical record',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      });
    },

    fetchRecord() {
      axios.get(`http://127.0.0.1:8000/api/getRecordById/${this.recordId}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      .then(response => {
        const record = response.data[0];
        this.record.type = record.type;
        this.record.recordDate = record.record_date;
        this.record.patientName = record.name;
        this.record.details = record.record;
      })
      .catch(error => {
        console.error(error);
      });
    },
  },

  mounted() {
    this.recordId = this.$route.params.id;
    this.fetchRecord();
  }
};
</script>

<style scoped>
/* Add your custom styles here */
.bg-blue-500 {
  background-color: #3b82f6;
}

.hover\:bg-blue-600:hover {
  background-color: #2563eb;
}
</style>