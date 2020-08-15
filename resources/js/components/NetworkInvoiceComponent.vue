<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">   
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-center" style="background-color:#AE0200; color:#fff">
            <h3 class="widget-user-username"><b>Invoice</b></h3>
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
          <div class="card-body text-center">
            <h4>Hello {{ user.username | capitalize}},</h4>
            <p class="p-2">Transfer NGN{{ transaction.amount }} worth of airtime to this phone number below: </p>

            <div class="p-2" style="background-color:#F9FAFC">
              <h2>{{ transaction.rec_number }}</h2>
              <p style="color:red">(Please never save this number)</p>
              <h4 style="color:red">WE DO NOT ACCEPT VTU OR RECHARGE PIN</h4>
            </div>

            <div style="color:red" class="p-2">
              Please use the display phone number only once because a new number will be provided for every transaction so as to avoid loss of airtime 
            </div>

            <div class="p-2">
              <p><strong>How to transfer MTN Airtime</strong></hp>

              <div class="p-2" style="background-color:#F9FAFC">
                <b>Using USSD</b>
                Dial: <strong>{{ transaction.transfer_code }}</strong>
              </div>

              <div class="p-2" style="background-color:#F9FAFC">
                <b>How to Set your Pin</b><br>
                <p>Your default PIN is <b>0000</b>. You are advised to change your default pin to the desired one.</p>
                <p>
                  To change your pin,<br>
                  Dial: <strong>{{ transaction.pin_change }}</strong>
                </p>
              </div>
            </div>

            <form @submit.prevent="updateImage()" class="form-inline">
              
                <label class="mr-4">Upload Proof of Payment: </label>
                <input type="file" @change="uploadImage" accept="image/*" name="pop" class="form-control" required>
             
              <button type="submit" class="btn btn-excel">Upload</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    created() {
      let source = this.$route.params.ref_id;
      if(source){
        this.fetch_advert_data();
      };
      this.getUser();
    },

    data(){
      return{
        form: {
          id: '',
          ref_id: '',
          pop: '',
        },
        user: '',
        transaction: '',
      }
    },

    methods: {
      getUser(){
        axios.get('/api/user') 
          .then(({data}) => {
            this.user = data;
          }
        )
      },

      fetch_advert_data(){
        let ref_id = this.$route.params.ref_id;
        if(ref_id)
        axios.get('/api/invoice/network/'+ref_id)
        .then((response) => {
            this.form = response.data;
            this.form.ref_id = ref_id;
            this.transaction = response.data;
        })
        .catch();
      },

      uploadImage(e){
        let file = e.target.files[0];
        let reader = new FileReader();
        if(file['size'] < 8388608){
          reader.onloadend = (file) => {
            this.form.pop = reader.result;
          }
          reader.readAsDataURL(file);
        }else{
           Swal("Failed!", "Oops, You are uploading a large file, try again. Upload file less that 8MB", "Warning")
        }
      },

      updateImage(){
        axios.post('/api/invoice/network', this.form)
        .then(()=>{
          Swal.fire(
            'Updated!',
            'POP uploaded successfully.',
            'success'
          )
          this.$router.push({ path: '/transaction/airtime'});
        })

        .catch((error) => {
          Swal.fire(
            'Failed!',
            'Oops there is an error somewhere',
            'error'
          )
        });       
      },
    },
  }
</script>

<style>
  .bg-exel{
    background:#000;
    color: #fff;
  }
</style>