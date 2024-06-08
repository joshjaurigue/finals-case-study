import { createRouter, createWebHashHistory } from 'vue-router'

import Login from '../components/LoginPage.vue'
import Register from '../components/RegisterPage.vue'
import AdminDashboard from '../components/AdminDashboard.vue'
import DoctorDashboard from '../components/DoctorDashboard.vue'
import PatientDashboard from '../components/PatientDashboard.vue'
import UserList from '../components/UserList.vue'
import CreateUser from '../components/CreateUser.vue'
import EditUser from '../components/EditUser.vue'
import DoctorListAdmin from '../components/DoctorListAdmin.vue'
import CreateDoctor from '../components/CreateDoctor.vue'
import EditDoctor from '../components/EditDoctor.vue'

import PatientListAdmin from '../components/PatientListAdmin.vue'
import CreatePatient from '../components/CreatePatient.vue'
import EditPatientStatus from '../components/EditPatientStatus.vue'
import EditPatientAdmin from '../components/EditPatientAdmin.vue'
import ViewPatientDetails from '../components/ViewPatientDetails.vue'
import AppointmentListDoctors from '../components/AppointmentListDoctors.vue'
import AppointmentListPatients from '../components/AppointmentListPatients.vue'
import CreateAppointment from '../components/CreateAppointment.vue'
import EditAppointmentDoctors from '../components/EditAppointmentDoctors.vue'
import EditAppointmentPatients from '../components/EditAppointmentPatients.vue'
import ViewAppointmentDetailsDoctors from '../components/ViewAppointmentDetailsDoctors.vue'
import ViewAppointmentDetailsPatients from '../components/ViewAppointmentDetailsPatients.vue'
import ViewAppointmentDetailsAdmin from '../components/ViewAppointmentDetailsAdmin.vue'
import MedicalRecordListDoctors from '../components/MedicalRecordListDoctors.vue'
import MedicalRecordListPatients from '../components/MedicalRecordListPatients.vue'
import CreateMedicalRecord from '../components/CreateMedicalRecord.vue'
import EditMedicalRecord from '../components/EditMedicalRecord.vue'
import ViewMedicalRecordDetailsDoctors from '../components/ViewMedicalRecordDetailsDoctors.vue'
import ViewMedicalRecordDetailsPatients from '../components/ViewMedicalRecordDetailsPatients.vue'
import SpecializationList from '../components/SpecializationList.vue'
import CreateSpecialization from '../components/CreateSpecialization.vue'
import EditSpecialization from '../components/EditSpecialization.vue'
import ViewSpecializationDetails from '../components/ViewSpecializationDetails.vue'
import ErrorPage from '../components/ErrorPage.vue'

import ViewMedicalRecordDetailsAdmin from '@/components/ViewMedicalRecordDetailsAdmin.vue'
import AppointmentListAdmin from '@/components/AppointmentListAdmin.vue'
import EditDoctorAdmin from '@/components/EditDoctorAdmin.vue'
import MedicalRecordListAdmin from '@/components/MedicalRecordListAdmin.vue'
import ViewMyDoctorProfile from '@/components/ViewMyDoctorProfile.vue'
import PatientListDoctors from '@/components/PatientListDoctors.vue'
import ViewPatientDetailsDoctors from '@/components/ViewPatientDetailsDoctors.vue'
import ViewPatientDetailsAdmin from '@/components/ViewPatientDetailsAdmin.vue'


const routes = [
  { 
    path: '/', 
    name: 'login', 
    component: Login 
  },
  { 
    path: '/register', 
    name: 'register', 
    component: Register 
  },
  
  // Admin Routes
  { 
    path: '/admin', 
    name: 'admin-dashboard', 
    component: AdminDashboard, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/users', 
    name: 'user-list', 
    component: UserList, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/users/create', 
    name: 'create-user', 
    component: CreateUser, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/users/:id/edit', 
    name: 'edit-user', 
    component: EditUser, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/specializations', 
    name: 'specialization-list', 
    component: SpecializationList, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/specializations/create', 
    name: 'create-specialization', 
    component: CreateSpecialization, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/specializations/:id/edit', 
    name: 'edit-specialization', 
    component: EditSpecialization, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/specializations/:id', 
    name: 'view-specialization-details', 
    component: ViewSpecializationDetails, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/doctors', 
    name: 'doctor-list-admin', 
    component: DoctorListAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/doctors/create', 
    name: 'create-doctor', 
    component: CreateDoctor, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/doctors/:id/edit', 
    name: 'edit-doctor-admin', 
    component: EditDoctorAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/patients', 
    name: 'patient-list-admin', 
    component: PatientListAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/patients/create', 
    name: 'create-patient', 
    component: CreatePatient, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/patients/:id/edit', 
    name: 'edit-patient-admin', 
    component: EditPatientAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/patients/:id', 
    name: 'view-patient-details', 
    component: ViewPatientDetailsAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/appointments', 
    name: 'appointments-admin', 
    component: AppointmentListAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/appointments/:id', 
    name: 'view-appointments-details-admin', 
    component: ViewAppointmentDetailsAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/medicalrecords', 
    name: 'view-medicalrecords-admin', 
    component: MedicalRecordListAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  { 
    path: '/admin/medicalrecords/:id', 
    name: 'view-medicalrecords-details-admin', 
    component: ViewMedicalRecordDetailsAdmin, 
    meta: { requiresAuth: true, role: 'admin' } 
  },
  
  
  // Doctor Routes
  { 
    path: '/doctor', 
    name: 'doctor-dashboard', 
    component: DoctorDashboard, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/patients/:id/edit', 
    name: 'edit-patient-status', 
    component: EditPatientStatus, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/patients', 
    name: 'view-my-patients', 
    component: PatientListDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/patients/:id', 
    name: 'view-patient-details', 
    component: ViewPatientDetailsDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/doctors/:id/edit', 
    name: 'edit-doctor-profile', 
    component: EditDoctor, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/doctors/:id', 
    name: 'view-doctor-profile-details', 
    component: ViewMyDoctorProfile, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/appointments', 
    name: 'appointment-list-doctors', 
    component: AppointmentListDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/appointments/:id', 
    name: 'view-appointment-details-doctors', 
    component: ViewAppointmentDetailsDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/appointments/:id/edit', 
    name: 'edit-appointment-doctors', 
    component: EditAppointmentDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/records', 
    name: 'medical-record-list-doctors', 
    component: MedicalRecordListDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/records/create', 
    name: 'create-medical-record', 
    component: CreateMedicalRecord, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/records/:id/edit', 
    name: 'edit-medical-record', 
    component: EditMedicalRecord, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  { 
    path: '/doctor/records/:id', 
    name: 'view-medical-record-details-doctors', 
    component: ViewMedicalRecordDetailsDoctors, 
    meta: { requiresAuth: true, role: 'doctor' } 
  },
  
  // Patient Routes
  { 
    path: '/patient', 
    name: 'patient-dashboard', 
    component: PatientDashboard, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/patients/:id', 
    name: 'view-patient-details', 
    component: ViewPatientDetails, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/appointments', 
    name: 'appointment-list-patients', 
    component: AppointmentListPatients, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/appointments/create', 
    name: 'create-appointment', 
    component: CreateAppointment, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/appointments/:id', 
    name: 'view-appointment-details-patients', 
    component: ViewAppointmentDetailsPatients, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/appointments/:id/edit', 
    name: 'edit-appointment-patients', 
    component: EditAppointmentPatients, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/records', 
    name: 'medical-record-list-patients', 
    component: MedicalRecordListPatients, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/patient/records/:id', 
    name: 'view-medical-record-details-patients', 
    component: ViewMedicalRecordDetailsPatients, 
    meta: { requiresAuth: true, role: 'patient' } 
  },
  { 
    path: '/error', 
    name: 'error-page', 
    component: ErrorPage, 
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

// Route guard to check for authentication and authorization
// Route guard to check for authentication and authorization
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!sessionStorage.getItem('auth_token')
  const user = JSON.parse(sessionStorage.getItem('user'))
  const userRole = user?.role

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next({ name: 'login' })
    } else if (to.matched.some(record => record.meta.role && record.meta.role !== userRole)) {
      next({ name: 'error-page' })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
