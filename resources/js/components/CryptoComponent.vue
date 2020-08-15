<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>
              <span v-if="crypto">Trade {{ crypto.name }}</span>
              <span v-else>Crypto Currencies</span></b>
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

    <div v-if="coin==false">
      <div class="row" v-if="cryptos.length">
        <div class="col-md-3" v-for="crypto in cryptos" :key="crypto.id">
          <div class="portfolio-item text-center product-hover">
            <img :src="'/storage/'+crypto.image" class="img-fluid" style="height:150px">

            <h3 class="header-title mb-4"> {{ crypto.name }}</h3>
            <!--<button @click=buy(crypto) class="btn btn-primary"> Buy </button>-->

            <button @click=sell(crypto) class="btn btn-excel"> Sell </button>
          </div>          
        </div>
      </div>

      <div v-else class="alert alert-info text-center p-4">Nothing found, check back later.</div>
    </div>

    <div v-else>
      <div v-if="sellcoin==true">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="text-center">
                  <h4 class="bold" style="font-size: 24px;border-bottom: 2px dotted ;padding-bottom: 15px;text-transform: uppercase">Sending Details</h4>
                </div>


                <form @submit.prevent="storeSell()">
                  <p class="text-center">Send your value to this {{ crypto.name }} address</p>
                
                  <br>

                  <div class="form-group">
                    <textarea class="form-control" readonly="true">{{ address }}</textarea>
                  </div>

                  <p><small><strong>Note:</strong> Only click submit when you have made the payment</small></p>
                  <button type="submit" class="btn btn-success">Submit</button>
                </form>
              </div>
            </div>
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
        sellcoin: false,
        buycoin:false,
        coin: false,
        address: '',
        form: {
          id: '',
          addr: '',
          value: '',
          type: '',
          crypto_id: '',
        },
        btc: '',
        crypto: '',
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
        axios.get('/api/crypto') 
          .then(({data}) => {
            this.cryptos = data;
        })
      },

      buy(crypto){
        if(crypto)
        this.crypto = crypto;
        this.buycoin = true;
        this.sellcoin = false;
        this.coin = true

        axios.get('/api/crypto/'+crypto.id) 
          .then(({data}) => {
            this.btc = data;
        })

        //this.$router.push({path: '/buycoin/'+id});
      },

      sell(crypto){
        if(crypto)
        this.crypto = crypto;
        this.buycoin = false;
        this.sellcoin = true;
        this.coin = true

        axios.get('/api/crypto/'+crypto.id) 
          .then(({data}) => {
            this.btc = data.btc;
            this.address = data.address;
            this.form.addr = data.address;
            this.form.crypto_id = this.crypto.id;
            this.form.type = 'sell';
            console.log(this.btc)
        })
        //this.$router.push({path: '/sellcoin/'+id});
      },

      storeSell(){
        axios.post('/api/postcrypto', this.form)
        .then(()=>{
        
          Swal.fire(
            'Updated!',
            'Your request has been submitted and your wallet will be credited once we confirm your payment.',
            'success'
          )
          this.$router.push({path: '/transaction/crypto'});
        })

        .catch((error) => {
          Swal.fire(
            'Failed!',
            'Oops there is an error somewhere',
            'error'
          )

          if (error.response.status == 422){
           this.errors = e.data.errors;
          }
        });
      }
    },
  }
</script>