<template>
  <div class="page-content pt-3">
    <div class="container">
       <div class="row">
          <div class="col-md-12">   
            <div class="card card-widget widget-user">
              <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
                <h3 class="widget-user-username"><b>Airtime Transactions</b></h3>
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
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              Airtime to Cash Transactions
            </div>
            <div v-if="transactions.data.length">
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tr>
                    <th>Trans ID</th>
                    <th>Network</th>
                    <th>Sender Phone</th>
                    <th>Airtime (NGN )</th>
                    <th>Recieving (NGN)</th>
                    <th>Status</th>
                    <th>Modify</th>
                  </tr>

                  <tr v-for="transaction in transactions.data" :key="transaction.id">
                    <td>{{ transaction.ref_id }}</td>
                    <td>{{ transaction.name }}</td>
                    <td>{{ transaction.sender_phone }}</td>
                    <td>{{ transaction.amount }}</td>
                    <td>{{ transaction.paying }}</td>
                    <td>{{ transaction.status | capitalize }}</td>
                    <td>
                      <span v-if="transaction.status=='pending'">
                        <a href="#" @click="onPay(transaction.ref_id)" class="btn btn-primary">
                          Pay
                        </a>
                      
                        <a href="#" @click="deleteTransaction(transaction.ref_id)"  class="btn btn-excel">
                          Delete
                        </a>
                      </span>
                    </td>
                  </tr>                  
                </table>
              </div>
              <div class="card-footer">
                <pagination :data="transactions" @pagination-change-page="getResults"></pagination>
              </div>
            </div>

          
            <div v-else class="p-5">
              <div class="alert alert-info text-center">No transaction found.</div>
            </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    created() {
      this.fetch_data();
    },

    data(){
      return{
        
        transactions: [],
       
        form: new Form({
          id: '',
          name: '',
        })
      }
    },

    methods: {
      getResults(page=1){
        axios.get('/api/transaction/airtime/?page=' + page)
        .then((response) => {
            this.transactions = response.data;
        })
      },

      fetch_data(){
        axios.get('/api/transaction/airtime')
        .then((response) => {
            this.transactions = response.data;
        })
        .catch((error) => {
          Swal.fire(
                'Failed!',
                'Error Try Again',
                'error'
          )
        });
      },

      onPay(id)
      { 
        this.$router.push({ path: '/network/invoice/'+ id});
      },

      deleteTransaction(id){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        })
        .then((result) => {
          if (result.value) {
            this.$Progress.start();
            this.form.delete('/api/transaction/airtime/'+id)
            .then(()=>{
              Swal.fire(
                'Deleted!',
                'Your transaction has been deleted.',
                'success'
              )
              this.$Progress.finish();
              this.fetch_data();
            })

            .catch(() => {
              Swal("Failed!", "Ops, Something went wrong, try again.", "Warning")
            });
          }
        })
      },
    },
  }
</script>
