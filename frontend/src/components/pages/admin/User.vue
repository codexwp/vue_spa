<template>
  <div>
    <div class="page-title">
      <span>All Users</span>
    </div>
    <div v-if="users.length == 0" class="card">
      <div class="card-body">
          <p>No users are found</p>          
      </div>
    </div>

    <table v-if="users.length" class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in users" v-bind:key="index">
          <th scope="row">{{ user.id }}</th>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ index }}</td>
        </tr>
      </tbody>
    </table>
    
  </div>
</template>

<script>
export default {
  name: 'admin-user-page',
  data: function(){
    return {
        users : [],
    }
  },
  mounted : function(){
    this.getUsers();
  },
  methods : {
    getUsers: function(){
      const self = this;
      self.$store.commit('loading', true);

      self.axios.get(self.$api_url + 'admin/users', { withCredentials: true,})
          .then(res => {
              self.users = res.data;
          })
          .catch(err => {
              const message = err.response.data.message ? err.response.data.message : err.message;
              self.$toast.error(message);
          })
          .finally(() => {
              self.$store.commit('loading', false);
          });
    }
  }
}
</script>