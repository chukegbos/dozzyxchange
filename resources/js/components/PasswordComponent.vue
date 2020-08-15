<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>Change Password</b></h3>
          </div>
          <div class="widget-user-image mt-3">
            <img class="img-circle elevation-2" :src="'/account/img/favicon.png'">
          </div>

          <div class="card-footer">
            <div class="row">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="errors.length" class="bg-red-500 text-white py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
        <p v-for="error in errors" :key="error" class="text-sm" style="color:red">
          {{ error }}
        </p>
    </div>


    <div class="row">
      <div class="col-md-3">
      </div>

      <div class="col-md-6">
        <div class="card" id="password">
          <div class="card-header">
            <div class="card-title">
              <h4>Change Password</h4>
            </div>
          </div>
          
          <div class="card-body">
            <form @submit.prevent="changePassword()">
              <div class="form-group">
                <label>Old Password</label>
                <input required class="form-control" v-model="formData.current_password" type="password">
              </div>

              <div class="form-group">
                <label>New Password</label>
                <input class="form-control" v-model="formData.new_password" type="password">
              </div>

              <div class="form-group">
                <label>Confirm Password</label>
                <input  class="form-control" v-model="formData.password_confirmation" type="password">
              </div>

              <button type="submit" class="btn btn-primary">Change</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    created() {
      this.getUser();
    },

    data(){
      return{
        user: '',
        model: {},

        formData: {
          current_password: '',
          new_password: '',
          password_confirmationation: '',
        },

        errors: [],
      }
    },



    methods: {
      getUser(){
        axios.get('/api/user') 
          .then(({data}) => {
            this.user = data;
          }
        )
      },

      changePassword(){
        this.$Progress.start();

        axios.put('/api/user/password', this.formData)
        .then(()=>{
        
          Swal.fire(
              'Updated!',
              'Your password has been updated.',
              'success'
          )

          this.$router.push({ path: '/home'});
        })

        .catch((error) => {
          if (error.response.status == 422){
            Swal.fire(
              'Failed!',
              'Oops there is an error somewhere',
              'error'
            )
            this.errors = error.response.data.errors.new_password;
            console.log(this.errors)
          }

          else
          {
            Swal.fire(
              'Failed!',
              'Oops there is an error somewhere',
              'error'
            )
          }
        });       
      },
    },
  }
</script>