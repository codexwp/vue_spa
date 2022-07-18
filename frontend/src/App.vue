<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-dark bg-success">
      <div class="container">
        <a class="navbar-brand" href="#">Vue SPA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">       
            
            <!--Admin Routes-->
            <li class="nav-item" v-if="isAdmin">
                <router-link class="nav-link" to="/admin/">Home</router-link>
            </li>
             <li class="nav-item" v-if="isAdmin">
                <router-link class="nav-link" to="/admin/users">Users</router-link>
            </li>
            <li class="nav-item" v-if="isAdmin">
                <router-link class="nav-link" to="/admin/posts">Posts</router-link>
            </li>
            <!--End Admin Routes-->



            <li class="nav-item" v-if="isNotLogged">
                <router-link class="nav-link" to="/" >Home</router-link>
            </li> 
             <li class="nav-item" v-if="isNotLogged">
                <router-link class="nav-link" to="/blogs" >Blogs</router-link>
            </li>           
            <li class="nav-item" v-if="isNotLogged">
                <router-link class="nav-link" to="/contact" >Contact</router-link>
            </li>

            <li class="nav-item" v-if="isNotLogged">
                <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item" v-if="isLogged">
                <router-link class="nav-link" to="/logout">Logout</router-link>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <div class="container">

      <div v-if="$store.state.loading" class="loading">
        <div class="bg-blur"></div>
        <div class="loader"></div>
      </div>

      <div class="pt-4">
        <router-view></router-view>
      </div>
    </div>    
  </div>
</template>

<script>
export default {
  watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = to.meta.title || to.name;
            }
        },
    },
  computed: {
    isAdmin: function(){
      const auth = this.$store.state.auth;
      if(auth && auth.user.role === 'admin')
          return true;
      return false;    
    },
    isLogged: function(){
      const auth = this.$store.state.auth;
      if(auth)
          return true;
      return false;  
    },
    isNotLogged: function(){
      const auth = this.$store.state.auth;
      if(auth === '')
          return true;
      return false;  
    }
  },
  methods: {

  },
  created: function () {
    const self = this;
    self.axios.defaults.headers.common = {
      "Accept": "application/json",
      'Content-Type': 'application/json',
    };
    self.axios.interceptors.response.use(undefined, function (err) {
      //return new Promise(function (resolve, reject) {
      return new Promise(function () {
        if (err.response.status === 401) {
          self.$store.commit('clearAuth');
          self.$router.push('/login');
        }
        throw err;
      });
    });
  }
}

</script>