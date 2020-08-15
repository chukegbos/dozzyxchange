<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>Services</b></h3>
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
      <div class="col-md-4">
        <div class="portfolio-item text-center product-hover">
          <img :src="'./img/btc.jpg'" class="img-fluid portfolio-image" style="height:200px">
          <h3 class="header-title mb-4">Crypto Currency</h3>
          <router-link to="/services/crypto" class="btn btn-excel"> Let's Trade </router-link>
        </div>          
      </div>


      <div class="col-md-4">
        <div class="portfolio-item text-center product-hover">
          <img :src="'./img/airtime.jpg'" class="img-fluid portfolio-image" style="height:200px">
          <h3 class="header-title mb-4">Airtime2Cash</h3>
          <router-link to="/services/airtime" class="btn btn-excel"> Let's Trade </router-link>
        </div>          
      </div>

      <div class="col-md-4">
        <div class="portfolio-item text-center product-hover">
          <img :src="'./img/gcard.png'" class="img-fluid portfolio-image" style="height:200px">
          <h3 class="header-title mb-4">Gift Card</h3>
          <button class="btn btn-excel"> Coming Soon </button>
        </div>          
      </div>
    </div>
  </div>
</template>

<script>
  import paystack from 'vue-paystack';
  export default {
    created() {
      this.getUser();
    },
    
    data(){
      return{
        user:'',
      }
    },

    methods: {
      getUser(){
        axios.get('/api/user') 
          .then(({data}) => {
            this.user = data;
            if(!this.user.confirmed){
              this.$router.push({ path: '/confirm-email'});
            }

            if(!this.user.acc_number){
              this.$router.push({ path: '/user'});
            }
          }
        )
      },
    },
  }
</script>