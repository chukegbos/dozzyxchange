<template>
  <div class="page-content pt-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-widget widget-user">
            <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
              <h3 class="widget-user-username"><b>Statement of Accounts</b></h3>
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
              Statement of Account
            </div>

            <div v-if="transactions.data.length">
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tr>
                    <th>Trans ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                  </tr>

                  <tr v-for="transaction in transactions.data" :key="transaction.id">
                    <td>{{ transaction.txid }}</td>
                    <td>{{ transaction.type }}</td>
                    <td>{{ transaction.amount }}</td>
                    <td>{{ transaction.purpose}}</td>
                   
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
        axios.get('/api/transaction/account/?page=' + page)
        .then((response) => {
            this.transactions = response.data;
        })
      },

      fetch_data(){
        axios.get('/api/transaction/account')
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
    },
  }
</script>
