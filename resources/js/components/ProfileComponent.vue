<template>
  <b-overlay :show="is_busy" rounded="sm">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-widget widget-user">
            <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
              <h3 class="widget-user-username"><b>Account Setup</b></h3>
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
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">
                <h4>Update Profile</h4>
              </div>
            </div>
            
            <div class="card-body">
              <form @submit.prevent="updateUser()">
                <div class="form-group">
                  <label>First Name</label>
                  <input v-model="form.first_name" required class="form-control">
                </div>

                <div class="form-group">
                  <label>Last Name</label>
                  <input v-model="form.last_name" required class="form-control">
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input v-model="form.username" readonly="true" class="form-control">
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input v-model="form.email" readonly="true" class="form-control" type="email">
                </div>

                <div class="form-group">
                  <label>Phone Number</label>
                  <input v-model="form.phone" required class="form-control" type="tel">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">
                <h4>Bank Details</h4>
              </div>
            </div>
            
            <div class="card-body">
              <form @submit.prevent="UploadBank()">
                <div class="form-group">
                  <label>Account Number</label>
                  <input v-model="bank.acc_number" class="form-control" required @change="onType()">
                </div>

                <div class="form-group">
                  <label>Select Bank</label>
                  <b-form-select 
                    v-model="bank.bank_name" 
                    :options="banks"
                    value-field="code"
                    text-field="name"
                    label="Select Bank"
                    v-on:change="onChange($event)"
                  >

                    <template v-slot:first>
                      <b-form-select-option :value="null" disabled>-- Please select your bank--</b-form-select-option>
                    </template>
                  </b-form-select>
                </div>

                <div class="form-group">
                  <label>Account Name</label>
                  <input v-model="bank.acc_name" readonly="true" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Upload</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </b-overlay>
</template>

<script>

  export default {
    created() {
      this.getUser();
      this.getBank();
    },

    data(){
      return{
        user: '',
        model: {},
        is_busy: false,
        form: new Form({
          id: '',
          first_name: '',
          last_name: '',
          username: '',
          email: '',
          phone:'',
          address: '',

        }),

        bank: {
          bank_name: null,
          acc_name: '',
          acc_number: '',
        },

        bank_detail: {
          bank_id: '',
          bank_account: '',
        },


        banks: {},
        errors: [],
      }
    },

    methods: {
      getUser(){
        axios.get('/api/user') 
          .then(({data}) => {
            this.user = data;
            this.form = data;
            this.bank = data;
          }
        )
      },

      getBank(){
        axios.get('/api/user/bank') 
          .then(({data}) => {
          this.banks = data;
        })
      },

      updateUser(){
        this.$Progress.start();

        axios.put('/api/user/'+this.form.id, this.form)
        .then(()=>{
        
          Swal.fire(
              'Updated!',
              'Your profile has been updated.',
              'success'
          )

          this.getUser();;
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
      },

      UploadBank(){
        axios.put('/api/user/'+this.form.id, this.bank)
        .then(()=>{
        
          Swal.fire(
              'Updated!',
              'Your bank details has been updated.',
              'success'
          )

          this.getUser();;
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
      },

      onType() {
        this.bank_detail.bank_account = this.bank.acc_number;
        console.log(this.bank_detail)
      },

      onChange(event) {
        this.bank_detail.bank_id = event;
        if(this.is_busy) return;
        this.is_busy = true;
        axios.post('/api/user/fetchbank', this.bank_detail)
        .then(({data}) => {
          console.log(data)

          if(data.data.account_name=='error'){
            Swal.fire(
              'Failed!',
              'Such account do not exist, check to see if you are correct',
              'error'
            )
          }
          else{
            this.bank.acc_name= data.data.account_name;
          }
          
        })
        .catch((err) => {
          Swal.fire(
            'Failed!',
            'Such account do not exist, check to see if you are correct',
            'error'
          )
        })

        .finally(() => {
          this.is_busy = false;
        });
      },

    },
  }
</script>