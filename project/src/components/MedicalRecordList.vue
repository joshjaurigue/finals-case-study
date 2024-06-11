<template>
    <div class="container mt-5">
      <h2 class="text-center mb-4">My Medical Records</h2>
      <div v-if="records.length" class="row row-cols-1 row-cols-md-2 g-4">
        <div v-for="record in records" :key="record.id" class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">Record Type: {{ record.type }}</h5>
              <p class="card-text"><strong>Date:</strong> {{ formatDate(record.record_date) }}</p>
              <p class="card-text"><strong>Doctor:</strong> {{ record.doctor_full_name }}</p>
              <p class="card-text"><strong>Details:</strong> {{ record.record }}</p>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center">
        <p>No medical records found.</p>
      </div>
    </div>
  </template>
  
  <script>
  import { BASE_URL } from '@/config';
  import axios from '@/axios';
  
  export default {
    name: 'MedicalRecordList',
    data() {
      return {
        records: []
      };
    },
    methods: {
      fetchMedicalRecords() {
        const patientId = localStorage.getItem('patient_id');
        axios.get(`${BASE_URL}/patient/records/${patientId}`)
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
      }
    },
    mounted() {
      this.fetchMedicalRecords();
    }
  };
  </script>
  
  <style>
  .container {
    max-width: 800px;
  }
  .card {
    margin: 10px 0;
  }
  </style>
  