<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>Verify Email</b></h3>
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

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <p class="p-3">
              Before proceeding, please check your email for a verification link. If you did not receive the email, <a href="#" @click=resend()>click here to request another link</a>.
            </p>
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
       
        form: new Form({
          id: '',
          name: '',
        })
      }
    },

    methods: {
      getUser(){
        axios.get('api/user') 
          .then(({data}) => {
            this.user = data;
          }
        )
      },


      resend()
      { 
        axios.get('api/resend') 
          .then(({data}) => {
            Swal.fire(
                'Created!',
                'Confirmation Email Sent.',
                'success'
            )
          }
        )
      },
    },
  }
</script>