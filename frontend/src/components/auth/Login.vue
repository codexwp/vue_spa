<template>
  <div>
    <div class="page-title">
      <span>Login</span>
    </div>
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <div class="card">
                <div class="card-body">
                    <form class="my-3" @submit="login($event)">

                        <div class="form-group mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                </div>
                                <input v-model="user.email" type="email" class="form-control" placeholder="Email address" :readonly="loading">                            
                            </div>
                            <small class="form-text text-danger">{{ errors.email }}</small>
                        </div>

                        <div class="form-group mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                                </div>
                                <input v-model="user.password" type="password" class="form-control" placeholder="Password" :readonly="loading">                                
                            </div>
                            <small class="form-text text-danger">{{ errors.password }}</small>
                       </div>

                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-success" :disabled="!isFormValid || loading">{{ loading ? 'Logging..' : 'Login' }}</button>
                        </div>  

                    </form>
                </div>
            </div>
        </div>
    </div>   
  </div>
</template>

<script>
export default {
  name: 'auth-login',
  data: function(){
    return {
        loading : false,
        user : {
            email : '',
            password : '',
            remember : false
        },
        errors : {
            email : '',
            password : ''
        }
    }
  },
  watch:{
        'user.email': function(newEmail){
            let email_regex = /\S+@\S+\.\S+/;
            if(newEmail == '')
                this.errors.email = 'Email address is required';
            else if(email_regex.test(newEmail) == false)
                this.errors.email = 'Email address is not valid'; 
            else
                this.errors.email = '';             
        },
        'user.password': function(newPassword){
            if(newPassword == '')
                this.errors.password = 'Password is required';
            else if(newPassword.length < 6)
                this.errors.password = 'Password should be at least 6 characters'; 
            else
                this.errors.password = '';             
        },
  },
  computed:{
        isFormValid: function(){
            let valid = true;
            const self = this;
            for (const [key, value] of Object.entries(self.errors)) {
                if(self.user[key] == '' || value != ''){
                    valid = false;
                    break;
                }
            }            
            return valid;
        }
  },
  methods: {
    login: function(e){
        e.preventDefault();
        const self = this;
        if(self.isFormValid == false)
            return false;

        self.loading = true;
        self.axios.post(self.$api_url + 'login', self.user, { withCredentials: false,})
            .then(res => {
                self.$store.commit('setAuth', res.data);
                self.$router.push('/redirect');
            })
            .catch(err => {
                const message = err.response.data.message ? err.response.data.message : err.message;
                self.$toast.error(message);
            })
            .finally(() => {
                self.loading = false;
            });
    }
  }
}
</script>