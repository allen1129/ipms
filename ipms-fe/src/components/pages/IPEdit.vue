<template>
    <layout-div>
         <h2 class="text-center mt-5 mb-3">Edit IP</h2>
         <div class="card">
             <div class="card-header">
                 <router-link 
                     class="btn btn-info float-right"
                     to="/">View All IPS
                 </router-link>
             </div>
             <div class="card-body">
                 <form>
                     <div class="form-group">
                         <label htmlFor="name">IP</label>
                         <input 
                             v-model="ip.name"
                             type="text"
                             class="form-control"
                             id="name"
                             name="name"/>
                     </div>
                     <div class="form-group">
                         <label htmlFor="description">Name</label>
                         <textarea 
                             v-model="ip.description"
                             class="form-control"
                             id="description"
                             rows="3"
                             name="description"></textarea>
                     </div>
                     <div class="form-group">
                         <label htmlFor="description">Comment</label>
                         <textarea 
                             v-model="ip.description"
                             class="form-control"
                             id="description"
                             rows="3"
                             name="description"></textarea>
                     </div>
                     <button 
                         @click="handleSave()"
                         :disabled="isSaving"
                         type="button"
                         class="btn btn-primary mt-3">
                         Save
                     </button>
                 </form>
             </div>
         </div>
    </layout-div>
 </template>
  
 <script>
 import axios from 'axios';
 import LayoutDiv from '../LayoutDiv.vue';
 import Swal from 'sweetalert2'
  
 export default {
   name: 'ipEdit',
   components: {
     LayoutDiv,
   },
   data() {
     return {
       ip: {
         ip: '',
         name: '',
         comment: '',
       },
       isSaving:false,
     };
   },
   created() {
     const id = this.$route.params.id;
     axios.get(`/api/ips/${id}`)
     .then(response => {
         let ipInfo = response.data
         this.ip.name = ipInfo.name
         this.ip.description = ipInfo.description
         return response
     })
     .catch(error => {
         Swal.fire({
             icon: 'error',
             title: 'An Error Occured!',
             showConfirmButton: false,
             timer: 1500
         })
         return error
     })
   },
   methods: {
     handleSave() {
         this.isSaving = true
         const id = this.$route.params.id;
         axios.patch(`/api/ips/${id}`, this.ip)
           .then(response => {
             Swal.fire({
                 icon: 'success',
                 title: 'IP updated successfully!',
                 showConfirmButton: false,
                 timer: 1500
             })
             this.isSaving = false
             this.ip.name = ""
             this.ip.description = ""
             return response
           })
           .catch(error => {
             this.isSaving = false
             Swal.fire({
                 icon: 'error',
                 title: 'An Error Occured!',
                 showConfirmButton: false,
                 timer: 1500
             })
             return error
           });
     },
   },
 };
 </script>