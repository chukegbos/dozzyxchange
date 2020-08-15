<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>Wallet</b></h3>
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
        <div class="portfolio-item text-center product-hover p-4">
          <h2> Naira Wallet</h2>
          <p class="header-title mb-4">Available Balance</p>
          <h3> <span>&#8358;</span> {{ user.balance }}</h3>
          
        </div>          
      </div>

      <div class="modal fade" id="addFund" tabindex="-1" role="dialog" aria-labelledby="addFundLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
         
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="createFund()">
              <div class="modal-body">
                <div class="form-group">
                  <label>How much do you want to withdraw</label>
                  <input v-model="form.amount" type="number" name="amount"
                    class="form-control">
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>

          </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="portfolio-item text-center product-hover p-4">
          <h2 v-if="withdraw"> Pending Withdrawal</h2>
          <h3>
            <span v-if="withdraw"> 
              <span>&#8358;</span> {{ withdraw.amount }}
            </span>

            <span v-else> 
              No withdrawal request
              <br>
              <a href="#" @click=newModal class="btn btn-excel"> Withdraw </a>
            </span>
          </h3>
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
      this.getWithdraw();
    },


    data(){
      return{
        user:'',
        withdraw: '',
        form: new Form({
          id: '',
          amount: '',
        })
      }
    },

    methods: {
      getUser(){
        axios.get('/api/user')
          .then(({data}) => {
            this.user = data;

            if(this.user.confirmed!=1){
              this.$router.push({ path: '/confirm-email'});
            }

            if(!this.user.acc_number){
              this.$router.push({ path: '/user'});
            }
          }
        )
      },

      getWithdraw(){
        axios.get('/api/withdraw')
          .then(({data}) => {
            this.withdraw = data;
            console.log(this.withdraw);
          }
        )
      },

      newModal(){
        this.editMode = false,
        this.form.reset();
        $('#addFund').modal('show');
      },


      createFund(){
        axios.post('/api/withdraw', this.form)
        .then(()=>{
        
          Swal.fire(
              'Updated!',
              'Withdraw Initiated.',
              'success'
          )
          $('#addFund').modal('hide');
          this.getUser();
          this.getWithdraw();
        })

        .catch((error) => {
          if (error.response.status == 422){
            Swal.fire(
              'Failed!',
              'Oops there is an error somewhere',
              'error'
            )
          }

          if (error.response.status == 400){
            Swal.fire(
              'Failed!',
              'You do not have upto that amount!',
              'error'
            )
            
          }

          
        });       
      },

      formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      }
    },
  }
</script>