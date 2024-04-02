<template>
    <layout-div>
      <h2 class="text-center mt-5 mb-3">Create New IP</h2>
      <div class="card">
          <div class="card-header">
              <router-link 
                  class="btn btn-info float-right"
                  to="/">View All IP
              </router-link>
          </div>
          <div class="card-body">
              <form>
                  <div class="form-group">
                      <label htmlFor="ip">IP</label>
                      <input 
                          v-model="ip.ip"
                          type="text"
                          class="form-control"
                          id="ip"
                          name="name"/>
                  </div>
                  <div class="form-group">
                      <label htmlFor="description">Name</label>
                      <textarea 
                          v-model="ip.name"
                          class="form-control"
                          id="name"
                          rows="3"
                          name="description"></textarea>
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
  import LayoutDiv from './LayoutDiv.vue';
  import Swal from 'sweetalert2'
   
  export default {
    name: 'IPCreate',
    components: {
      LayoutDiv,
    },
    data() {
      return {
        ip: {
          name: '',
          ip: '',
          comment: '',
        },
        isSaving:false,
      };
    },
    methods: {
      handleSave() {
          this.isSaving = true
          axios.post('/api/ip', this.ips)
            .then(response => {
              Swal.fire({
                  icon: 'success',
                  title: 'Project saved successfully!',
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