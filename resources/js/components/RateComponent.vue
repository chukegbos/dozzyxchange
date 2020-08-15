<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username">
              <b>Our Rates</b>
            </h3>
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

    <div v-if="cryptos.length">
      <div class="p-4 text-center">
        <h4><strong>Cryptos</strong></h4>
      </div>
      <div class="row">
        <div class="col-md-3" v-for="crypto in cryptos" :key="crypto.id">
          <div class="portfolio-item text-center product-hover">
            <img :src="'/storage/'+crypto.image" class="img-fluid" style="height:120px">

            <h5 class="header-title mb-4"> {{ crypto.name }}</h5>
            <p><b>Buying Rate:</b> {{ crypto.buying_rate }}/$</p>
            
          </div>          
        </div>
      </div>
    </div>


    <div v-if="cryptos.length">
      <div class="p-4 text-center">
        <h4><strong>Airtime</strong></h4>
      </div>
      <div class="row">
        <div class="col-md-3" v-for="network in networks" :key="network.id">
          <div class="portfolio-item text-center product-hover">
            <img :src="'/storage/'+network.image" class="img-fluid" style="height:120px">

            <h5 class="header-title mb-4"> {{ network.name }}</h5>
            <p><b>Rate:</b> {{ network.rate }}%</p>
            
          </div>          
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
      this.loadCrypto();
    },


    data(){
      return{
        cryptos: {},
        networks: {},
      }
    },

    methods: {
      getUser(){
        axios.get('/api/user') 
          .then(({data}) => {
            this.user = data;
            this.email = this.user.email;
            this.phone = this.user.phone;
          }
        )
      },

      loadCrypto(){
        axios.get('/api/getrates') 
          .then(({data}) => {
            this.cryptos = data.crypto;
            this.networks = data.network;
        })
      },
    },
  }
</script>