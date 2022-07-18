<template>
  <div>
    <div class="page-title">
      <span>All Posts</span>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-success mb-3 btn-sm" @click="$router.push('/admin/posts/create')">New Post</button>
     </div>
    <div v-if="posts.length == 0" class="card">
      <div class="card-body">
          <p>No posts are found</p>          
      </div>
    </div>

    <table v-if="posts.length" class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Title</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(post, index) in posts" v-bind:key="index">
          <th scope="row">{{ post.id }}</th>
          <td>{{ post.title }}</td>
          <td>{{ post.status }}</td>
          <td>
            <button @click="$router.push('/admin/posts/'+post.id+'/update')" class="btn btn-warning btn-sm mr-2">Edit</button>
            <button @click="deletePost(post.id, index)" class="btn btn-danger btn-sm">Del</button>
          </td>
        </tr>
      </tbody>
    </table>
    
  </div>
</template>

<script>
export default {
  name: 'admin-post-page',
  data: function(){
    return {
        posts : [],
    }
  },
  mounted : function(){
    this.getPosts();
  },
  methods : {
    getPosts: function(){
      const self = this;
      self.$store.commit('loading', true);

      self.axios.get(self.$api_url + 'admin/posts', { withCredentials: true,})
          .then(res => {
              self.posts = res.data;
          })
          .catch(err => {
              const message = err.response.data.message ? err.response.data.message : err.message;
              self.$toast.error(message);
          })
          .finally(() => {
              self.$store.commit('loading', false);
          });
    },
    deletePost: function(id, index){
        if(confirm("Are you sure to delete operation?") === false)
          return;

        const self = this;
        self.$store.commit('loading', true);
        self.axios.delete(self.$api_url + 'admin/posts/' + id + '/delete', { withCredentials: true,})
            .then(res => {
                self.$toast.success(res.data.message);
                self.posts.splice(index,1);
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