<template>
  <div class="container mt-5">
    <router-link :to="{ path: '/doctor/records' }" class="btn btn-secondary mb-3">Back</router-link>

    <h2 class="text-center mb-4">Add New Medical Record</h2>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="addRecord">
              <div class="form-group mb-3">
                <label for="type">Record Type</label>
                <select id="type" v-model="record.type" class="form-control">
                  <option value="diagnosis">Diagnosis</option>
                  <option value="prescription">Prescription</option>
                  <option value="treatment">Treatment</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="recordDate">Record Date</label>
                <input type="datetime-local" id="recordDate" v-model="record.recordDate" class="form-control"/>
              </div>
              <div class="form-group mb-3">
                <label for="patientId">Patient Name</label>
                <select id="patientId" v-model="record.patient_id" class="form-control">
                  <option v-for="patient in patients" :key="patient.patient_id" :value="patient.patient_id">
                    {{ patient.patient_name }}
                  </option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="details">Details</label>
                <input type="text" id="details" v-model="record.details" class="form-control"/>
              </div>
              <button type="submit" class="btn btn-success">Add Record</button>
            </form>
          </div>
        </div>
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
      record: {
        type: '',
        recordDate: '',
        patient_id: '', 
        details: ''
      },
      patients: [] 
    };
  },
  methods: {
    fetchPatients() {
      axios.get(`http://127.0.0.1:8000/api/getPatientsForDoctor`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      .then(response => {
        this.patients = response.data;
      })
      .catch(error => {
        console.error('Error fetching patients:', error);
      });
    },
    addRecord() {
      const doctorId = localStorage.getItem('doctor_id');
      axios.post(`http://127.0.0.1:8000/api/addRecord`, {
        type: this.record.type,
        record_date: this.record.recordDate,
        patient_id: this.record.patient_id,
        doctor_id: doctorId, 
        record: this.record.details
      }, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      .then(() => {
        Swal.fire({
          title: 'Success',
          text: 'Medical record added successfully',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          this.$router.push('/doctor/records');
        });
      })
      .catch(error => {
        console.error('Error adding medical record:', error);
        Swal.fire({
          title: 'Error',
          text: 'Failed to add medical record',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      });
    }
  },
  mounted() {
    this.fetchPatients(); 
  }
};
</script>

<style scoped>
.card {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-success {
  background-color: #28a745;
  border: none;
}

.btn-success:hover {
  background-color: #218838;
}
</style>
