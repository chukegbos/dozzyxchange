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
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <h3> Details</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="text-center" v-if="network">
              <img :src="'/storage/'+network.image" class="img-fluid center" style="height:150px">
            </div>

            <div v-if="form.amount" class="p-2">
              <p><strong>Rate:</strong> {{ network.rate }}%</p>
              <p><strong>Your are selling:</strong> {{ form.amount }} worth of {{ network.name }} airtime</p>

              <p><strong>We are paying you:</strong> NGN {{ form.amount - ((network.rate/100) * form.amount) }}</p>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Initiate Transaction</h4>
          </div>

          <form @submit.prevent="create()">
            <div class="card-body">
              <div class="form-group">
                
                <b-form-select 
                  v-model="form.network_id" 
                  :options="networks"
                  value-field="id"
                  text-field="name"
                  label="Select Network"
                   v-on:change="onChange($event)"
                >

                <template v-slot:first>
                  <b-form-select-option :value="null" disabled>-- Please select your network--</b-form-select-option>
                </template>
                </b-form-select>
              </div>

              <div class="form-group" v-if="form.network_id!=null">
                <input type="hidden" name="user_id">
                <label for="input-live">Amount:</label>
                <b-form-input
                  id="input-live"
                  v-model="form.amount"
                  @change="calculate()"
                  aria-describedby="input-live-help input-live-feedback"
                ></b-form-input>
              </div>

              <div class="form-group" v-if="form.network_id!=null">
                <input type="hidden" name="user_id">
                <label for="input-live">We are Paying:</label>
                <b-form-input
                  id="input-live"
                  v-model="form.paying"
                  readonly
                  aria-describedby="input-live-help input-live-feedback"
                ></b-form-input>
              </div>

              <div class="form-group" v-if="form.amount">
                <label for="input-live">Sender Phone Number:</label>
                <b-form-input
                  id="input-live"
                  v-model="form.sender_phone"
                  aria-describedby="input-live-help input-live-feedback"
                ></b-form-input>
              </div>
            </div>

            <div class="card-footer" v-if="form.amount">
              <button type="submit" class="btn btn-excel">Initiate</button>
            </div>
          </form>
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
      this.loadNetwork();
    },


    data(){
      return{
        networks: {},
        network: '',
        form: {
          id: '',
          network_id: null,
          sender_phone: '',
          amount: '',
          user_id:'',
          paying: '',
          rec_number: '',
        },
        
      }
    },

    methods: {
      getUser(){
        axios.get('/api/user') 
          .then(({data}) => {
            this.form.sender_phone = data.phone;
            this.form.user_id = data.id;
          }
        )
      },

      loadNetwork(){
        axios.get('/api/network') 
          .then(({data}) => {
            this.networks = data;
        })
      },

     
      onChange(event) {
        axios.get('/api/network/'+event) 
          .then(({data}) => {
            this.network = data.airtime;
            this.form.rec_number = data.line.number;
        })
      },

      create(){
        axios.post('/api/network', this.form)
        .then((data)=>{
          Swal.fire(
              'Created!',
              'Transaction Successfully Initiated.',
              'success'
          )
          this.$router.push({ path: '/network/invoice/'+ data.data});
        })

        .catch((error) => {
          Swal.fire(
            'Failed!',
            'Error somewhere, its our fault.',
            'error'
          )
        });       
      },

      calculate() {
        this.form.paying = this.form.amount - ((this.network.rate/100) * this.form.amount)
      },

      


    },
  }
</script>