<template>
    <div>
        <h3>Redirecting...</h3>
    </div>
</template>
<script>
export default {
  name: 'redirect-route',
  created: function(){
    const auth = this.$store.state.auth;
    console.log(auth);
    if( auth && auth.user.role === 'admin')
       this.$router.push('/admin/');
    else if( auth && auth.user.role === 'user')
       this.$router.push('/user/');   
    else
       this.$router.push('/');    
  }
}
</script>