<template>
    <layout-div>
          <div class="container">
              <h2 class="text-center mt-5 mb-3">IP's Manager</h2>
              <div class="card">
                  <div class="card-header">
                      <router-link to="/create"
                          class="btn btn-primary float-end"
                          >Add New IP
                      </router-link>
                  </div>
                  <div class="card-body">
               
                      <table class="table table-bordered" style="text-align:center">
                          <thead>
                              <tr >
                                  <th>IP</th>
                                  <th>Name</th>
                                  <th>Comment</th>
                                  <th width="240px">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                               
                              <tr v-for="ip in ips" :key="ip.id">
                                  <td>{{ip.ip}}</td>
                                  <td>{{ip.name}}</td>
                                  <td>{{ip.comment}}</td>
                                  <td>
                                      <router-link :to="`/show/${ip.id}`" class="btn btn-info mx-1">Show</router-link>
                                      <router-link :to="`/edit/${ip.id}`" class="btn btn-success mx-1">Edit</router-link>
                                      <button 
                                          @click="handleDelete(ip.id)"
                                          className="btn btn-danger mx-1">
                                          Delete
                                      </button>
                                  </td>
                              </tr>
                                   
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </layout-div>
  </template>
   
  <script>
  import axios from 'axios';
  import LayoutDiv from './LayoutDiv.vue';
  import Swal from 'sweetalert2'
   
  export default {
    name: 'IPList',
    components: {
      LayoutDiv,
    },
    data() {
      return {
        ips:[]
      };
    },
    created() {
      this.fetchList();
    },
    methods: {
        fetchList() {
            axios.get('/api/ips')
            .then(response => {
                this.ips = response.data;
                return response
            })
            .catch(error => {
                return error
            });
        },
      handleDelete(id){
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                  axios.delete(`/api/projects/${id}`)
                  .then( response => {
                      Swal.fire({
                          icon: 'success',
                          title: 'IP deleted successfully!',
                          showConfirmButton: false,
                          timer: 1500
                      })
                      this.fetchList();
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
                  });
              }
            })
      }
    },
  };
  </script>