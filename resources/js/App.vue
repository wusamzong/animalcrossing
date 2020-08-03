<template>
  <div>
    <Navbar :app="this"></Navbar>
    <spinner v-if="loading"></spinner>
    <div v-else-if="initiated" class="container-xl px-0">
      <router-view :app="this" />
    </div>
  </div>
</template>
<script>
import Navbar from "./components/navbar";
export default {
  name: "app",
  components: {
    Navbar,
  },
  data() {
    
    return {
      user: null,
      loading: false,
      initiated: false,
      
      req: axios.create({
        baseUrl: BASE_URL,
      }),
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.loading = true;
      this.req.get("api/auth/init").then((response) => {
        if(this.$cookie.get('username')){
          this.getCookie();
        }        
        //this.user = response.data.user;
        this.loading = false;
        this.initiated = true;
      });
    },
    getCookie() {
      const data={
          username: this.$cookie.get('username'),
          password: this.$cookie.get('password')
        }
      this.req.post("api/auth/getCookie",data)
      .then(response => {        
        this.user = response.data;
      }).catch(err=>{
        console.log('error');
      });
    },

  },
};
</script>
<style>
html{
  width: 100vw;
}
body{
  font-family: '微軟正黑體';
  width: 100vw;
}
.bg-AC{  
  background: #00AC64;  /* Animal Crossing === AC*/
}
template{
  width:100%;
}
</style>