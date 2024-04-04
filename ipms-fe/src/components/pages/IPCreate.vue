<template>
  <layout-div>
    <div class="card" style="margin-top:20px">
          <div class="card-header" style="text-align: center;">
            Add IP 
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
                <div class="form-group ">
                  <button 
                      @click="handleSave()"
                      :disabled="isSaving"
                      type="button"
                      style="margin-left: 10px; margin-top:10px"
                      class="btn btn-primary float-end">
                      Save 
                  </button>
                    <router-link 
                    style=" margin-top:10px"
                    class="btn btn-info float-end"
                    to="/">View All IP
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
    isSaving: false,
  };
},
methods: {
  handleSave() {
    this.isSaving = true;
    axios.post('/api/ips', this.ip) // corrected typo: this.ips to this.ip
      .then(response => {
        Swal.fire({
            icon: 'success',
            title: 'IP saved successfully!',
            showConfirmButton: false,
            timer: 1500
        })
        this.isSaving = false;
        this.ip.name = "";
        this.ip.description = "";
        return response;
      })
      .catch(error => {
        this.isSaving = false;
        console.log(error);
        let errorMessage = 'An error occurred while saving the IP.';
        if (error.response && error.response.data && error.response.data.errors) {
            // Extract the first error message from the errors object
            const errors = error.response.data.errors;
            const errorMessageKey = Object.keys(errors)[0];
            let errorMessageValue = errors[errorMessageKey];
            // Format the error message to make it clearer
            errorMessageValue = errorMessageValue.replace('This value', errorMessageKey.toUpperCase());
            errorMessage = errorMessageValue;
        }
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            showConfirmButton: false,
            timer: 3000 // Adjust the timer as needed
        });
        return error;
      });
  },
},
};
</script>
