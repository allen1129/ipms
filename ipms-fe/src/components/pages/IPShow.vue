<template>
    <layout-div>
         <h2 class="text-center mt-5 mb-3">Show IP</h2>
         <div class="card">
             <div class="card-header">
                 <router-link 
                     class="btn btn-info float-right"
                     to="/">View All Ip's
                 </router-link>
             </div>
             <div class="card-body">
                 <b className="text-muted">IP:</b>
                 <p>{{ip.ip}}</p>
                 <b className="text-muted">Name:</b>
                 <p>{{ip.name}}</p>
                 <b className="text-muted">Comment:</b>
                 <p>{{ip.comment}}</p>
             </div>
         </div>
    </layout-div>
 </template>
  
 <script>
 import axios from 'axios';
 import LayoutDiv from './LayoutDiv.vue';
 import Swal from 'sweetalert2'
  
 export default {
   name: 'ProjectShow',
   components: {
     LayoutDiv,
   },
   data() {
     return {
       ip: {
         name: '',
         comment: '',
         ip: '',
       },
       isSaving:false,
     };
   },
   created() {
     const id = this.$route.params.id;
     axios.get(`/api/ips/${id}`)
     .then(response => {
         let ipData = response.data
         this.ip.ip = ipData.ip
         this.ip.name = ipData.name
         this.ip.comment = ipData.comment
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
      
   },
 };
 </script>