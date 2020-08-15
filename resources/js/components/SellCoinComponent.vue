<template>
  <div>
    <div class="breadcromb-area">
      <div class="row">
        <div class="col-md-6  col-sm-6">
          <h3>Upload your advert</h3>
        </div>
      </div>
    </div>

    <div class="page-content mt-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form @submit.prevent="updateImage()">
                  <div class="form-group">
                    <label>Upload Banner Image</label>
                    <input type="file" @change="uploadImage" accept="image/*" name="banner" class="form-control">
                  </div>

                  <div class="my-2" v-if="form.banner">
                    <img :src="form.banner" class="img-fluid">
                  </div>
                  <button type="submit" class="btn btn-success">Upload</button>
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

  export default {
    created() {
      let source = this.$route.params.ref_id;
      if(source){
        this.fetch_advert_data();
      }
    },

    data(){
      return{
        form: {
          id: '',
          ref_id: '',
          banner: '',
        },

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

      fetch_advert_data(){
        let ref_id = this.$route.params.ref_id;
        if(ref_id)
        axios.get('/api/user/prices/'+ref_id)
        .then((response) => {
            this.form = response.data;
            console.log(this.form)
        })
        .catch();
      },

      uploadImage(e){
        let file = e.target.files[0];
        let reader = new FileReader();
        if(file['size'] < 8388608){
          reader.onloadend = (file) => {
            this.form.banner = reader.result;
          }
          reader.readAsDataURL(file);
        }else{
           Swal("Failed!", "Oops, You are uploading a large file, try again. Upload file less that 8MB", "Warning")
        }
      },

      updateImage(){
        this.$Progress.start();
        axios.put('/api/user/prices/'+this.form.id, this.form)
        .then(()=>{
          Swal.fire(
            'Updated!',
            'Image uploaded successfully.',
            'success'
          )
          this.$router.push({path: '/user/place-advert'});
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