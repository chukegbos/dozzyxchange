<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>Welcome {{ user.name | capitalize}}</b></h3>
            <h5 class="widget-user-desc">Wallet Balance: <b>NGN {{ user.balance }}</b></h5>
          </div>
          <div class="widget-user-image mt-3">
            <img class="img-circle elevation-2" :src="'/img/favicon.png'">
          </div>

          <div class="card-footer">
            <div class="row">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-7">
        <div class="card">
          <div class="card-body">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" :src="'./img/abanner.jpeg'" style="height:300px">
                </div>

                <div class="carousel-item">
                  <img class="d-block w-100" :src="'./img/bbanner.jpeg'" style="height:300px">
                </div>

                <div class="carousel-item">
                  <img class="d-block w-100" :src="'./img/cbanner.jpeg'" style="height:300px">
                </div>

              </div>

              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>

              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card">
          <div class="card-header text-center">
            Profile Analysis
          </div>
          <div class="card-body">
            <p v-if="user.confirmed==1"> 
              Email Confirmed <span class="pull-right"><i class="fa fa-check fa-2x text-blue"></i></span>
            </p>
            <p v-else> 
              Confirm your email 
              <span class="pull-right"><i class="fa fa-times fa-2x text-red"></i></span>
              <br>
              <a href="">Click here to send a confirmation request. Also check your spam folder</a>
            </p>
            <hr style="background-color:#AE0200">


            <p v-if="user.acc_number"> 
              Bank Account Activated <span class="pull-right"><i class="fa fa-check fa-2x text-blue"></i></span>
            </p>
            <p v-else> 
              Add a bank account <br>to activate your wallet
              <span class="pull-right"><i class="fa fa-times fa-2x text-red"></i></span>
              <br>
              <router-link to="/user">Click here to add</router-link>
            </p>
            <hr style="background-color:#AE0200">

            <p v-if="user.setup==1"> 
              Profile Completed <span class="pull-right"><i class="fa fa-check fa-2x text-blue"></i></span>
            </p>
            <p v-else> 
              Complete your profile
              <span class="pull-right"><i class="fa fa-times fa-2x text-red"></i></span>
              <router-link to="/user">Click here to add</router-link>
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
            console.log(data);
            this.user = data;
          }
        )
      },


      onBack()
      { 
        this.$router.go()
      },
    },
  }
</script>