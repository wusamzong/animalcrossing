<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Register</div>
      <div class="card-body">
        <div class="col-md-6 offset-md-3">
          <form v-on:submit.prevent="onSubmit">
              <div class="alert alert-danger" v-if="errors.length">
                <ul class="mb-0">
                  <li v-for="(error, index) in errors" :key="index">
                    {{ error }}
                  </li>
                </ul>
              </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" placeholder="Name..." v-model="name">
              <label>Username</label>
              <input type="text" class="form-control" placeholder="Username..." v-model="username">
              <label>Password</label>
              <input type="password" class="form-control" placeholder="Password..." v-model="password">
              <label>Password Again</label>
              <input type="password" class="form-control" placeholder="Password Again..." v-model="passwordAgain">
              <button class="btn btn-primary">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'register',
  props: ['app'],
  data(){
    return{
      name: '',
      username: '', 
      password: '',
      passwordAgain: '',
      errors: []
    }
  },
  methods:{
    onSubmit(){
      this.errors = [];
      if(!this.name){
        this.errors.push('Name is required.');
      }
      if(!this.username){
        this.errors.push('Username is required.');
      }
      if(!this.password){
        this.errors.push('Password is required.');
      }
      if(!this.passwordAgain){
        this.errors.push('Password confirmation is required.');
      }
      if(this.passwordAgain !== this.password){
        this.errors.push('Password do not match');
      }

      if(!this.errors.length){
        const data={
          name: this.name,
          username: this.username,
          password: this.password
        }

        this.app.req
        .post('api/auth/register',data)
        .then(response =>{
          this.app.user = response.data;
          this.$router.push('/');
        }).catch(err=>{
          this.errors.push(err.response.data.error);
        });
      }
    }
  }
};
</script>