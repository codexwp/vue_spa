<script>
export default {
  name: 'auth-logout',
  created: function(){
    const self = this;
    self.axios.post(self.$api_url + 'logout', self.user, {withCredentials: true,})
      .then((res) => {
          self.$toast.success(res.data.message);
          self.$store.commit('clearAuth');
          self.$router.push('/login');
      })
      .catch(err => {
          const message = err.response.data.message ? err.response.data.message : err.message;
          self.$toast.error(message);
      });
  }
}
</script>