<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              Users
            </div>
            <div class="card-tools">
              <button class="btn btn-success" @click=newModal>Add New <i class="fa fa-user-plus fa-fw"></i></button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Registerd Date</th>
                <th>Modify</th>
              </tr>

              <tr v-for="user in users.data" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.type | capitalize }}</td>
                <td>{{ user.created_at | myDate }}</td>
                <td>
                  <a href="#" @click="editModal(user)">
                    <i class="fa fa-edit"></i>
                  </a>
                  |
                  <a href="#" @click="deleteUser(user.id)">
                    <i class="fa fa-trash text-red"></i>
                  </a>
                </td>
              </tr>                  
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewUserLabel" v-show="!editMode">Add New</h5>
            <h5 class="modal-title" id="addNewUserLabel" v-show="editMode">Update User's Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                  class="form-control" placeholder="Fullname" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <select name="type" v-model="form.type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                  <option selected="">Select User Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.email" type="email" name="email"
                  class="form-control" placeholder="Email Address" :class="{ 'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.password" placeholder="Password" type="password" name="password"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return{
        editMode: false,
        model: {},
        users: {},
        form: new Form({
          id: '',
          name: '',
          email: '',
          password: '',
          type:'Select User Role',
          remember: false
        })
      }
    },

    methods: {
      getResults(page=1){
        axios.get('api/user?page=' + page)
        .then(response => {
          this.users = response.data;
        });
      },

      editModal(user){
        this.editMode = true,
        this.form.reset();
        $('#addNewUser').modal('show');
        this.form.fill(user);
      },

      newModal(){
        this.editMode = false,
        this.form.reset();
        $('#addNewUser').modal('show');
      },

      loadUsers(){
        axios.get('api/user') .then(({data}) => {
          this.users = data})
      },

      createUser(){
        this.$Progress.start();

        this.form.post('api/user')
        .then(()=>{
          Fuse.$emit('AfterCreate');
        
          $('#addNewUser').modal('hide')
          
          toast({
            icon: 'success',
            title: this.form.name + ' Created successfully',
          })
          this.$Progress.finish();
          
        })

        .catch(() => {
          this.$Progress.fail();
        });       
      },

      updateUser(){
        this.$Progress.start();

        this.form.put('api/user/'+this.form.id)
        .then(()=>{
          $('#addNewUser').modal('hide')
          
          Swal.fire(
              'Updated!',
              'Your file has been updated.',
              'success'
          )
          this.$Progress.finish();
          Fuse.$emit('AfterCreate');
        })

        .catch(() => {
          this.$Progress.fail();
        });       
      },

      deleteUser(id){
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
            this.form.delete('api/user/'+id)
            .then(()=>{
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              this.$Progress.finish();
              Fuse.$emit('AfterCreate');
            })

            .catch(() => {
              Swal("Failed!", "Ops, Something went wrong, try again.", "Warning")
            });
          }
        })
      },
    },

    created() {
      Fuse.$on('searching',() => {
        let query =this.$parent.search;
        axios.get('api/findUser?q=' + query)
        .then((data) => {
          this.users = data.data
        })
      });

      this.loadUsers();
      Fuse.$on('AfterCreate',() => {
        this.loadUsers();
      });
    }
  }
</script>
