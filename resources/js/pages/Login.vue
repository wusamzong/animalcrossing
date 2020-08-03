<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Login</div>
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
              <label>Username</label>
              <input type="text" class="form-control" placeholder="Username..." value="Tom" v-model="username">
              <label>Password</label>
              <input type="password" class="form-control" placeholder="Password..." value="Tom" v-model="password">

              <button class="btn btn-outline-success">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'login',
  props: ['app'],
  data(){
    return{
      username: '', 
      password: '',
      errors: []
    }
  },
  methods:{
    setCookie(data) {
      
           
      
      
    },
    onSubmit(){
      this.errors = [];

      if(!this.username){
        this.errors.push('Username is required.');
      }
      if(!this.password){
        this.errors.push('Password is required.');
      }


      if(!this.errors.length){
        const data={
          username: this.username,
          password: this.password
        }
        
        this.app.req
        .post('api/auth/login',data)
        .then(response =>{
          this.app.user = response.data;
          this.$cookie.set('username', data.username);
          this.$cookie.set('password', data.password);
          this.$router.push('/');

        }).catch(err=>{
          this.errors.push(err.response.data.error);
        });
      }
    }
  }
};
</script>