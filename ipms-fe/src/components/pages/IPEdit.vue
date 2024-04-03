<template>
    <layout-div>
         <div class="card" style="margin-top:20px">
             <div class="card-header" style="text-align: center;">
                Edit IP 
             </div>
             <div class="card-body">
                 <form>
                     <div class="form-group">
                         <label htmlFor="name">IP</label>
                         <input 
                             v-model="ip.ip"
                             type="text"
                             class="form-control"
                             id="ip"
                             readonly
                             name="ip"/>
                     </div>
                     <div class="form-group">
                         <label htmlFor="description">Name</label>
                         <textarea 
                             v-model="ip.name"
                             class="form-control"
                             id="name"
                             rows="3"
                             name="name"></textarea>
                     </div>
                     <div class="form-group">
                         <label htmlFor="description">Comment</label>
                         <textarea 
                             v-model="ip.comment"
                             class="form-control"
                             id="comment"
                             rows="3"
                             name="comment"></textarea>
                     </div>
                     <div class="form-group ">
                        <button 
                            @click="handleSave()"
                            :disabled="isSaving"
                            type="button"
                            style="margin-left: 10px; margin-top:10px"
                            class="btn btn-primary  float-end">
                            Save
                        </button>
                        <router-link 
                            style=" margin-top:10px"
                            class="btn btn-info float-end"
                            to="/">View All IPS
                        </router-link>
                    </div>
                 </form>
             </div>
         </div>
    </layout-div>
 </template>
  
 <script>
 import axios from 'axios';
 import LayoutDiv from './LayoutDiv.vue';
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
         this.ip.ip = ipInfo.ip
         this.ip.name = ipInfo.name
         this.ip.comment = ipInfo.comment
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