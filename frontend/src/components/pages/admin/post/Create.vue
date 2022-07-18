<template>
  <div>
    <div class="page-title">
      <span>Create Post</span>
    </div>

    <div class="card">
      <div class="card-body">
          
        <form v-on:submit="create($event)">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span></label>
                <input v-model="post.title" type="text" class="form-control" id="title" placeholder="Post Title">
                <small class="form-text text-danger">{{ errors.title }}</small>
            </div>
            <div class="form-group">
                <label for="description">Description <span class="text-danger">*</span></label>
                <textarea v-model="post.description" class="form-control" id="description" rows="5" placeholder="Enter post description"></textarea>
                <small class="form-text text-danger">{{ errors.description }}</small>
            </div>
            <div class="form-group mb-5">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select v-model="post.status" class="form-control" id="status">
                    <option v-for="(val, index) in status" :value="val" v-bind:key="index">{{ val }}</option> 
                </select>
                <small class="form-text text-danger">{{ errors.status }}</small>
            </div> 
            <div class="text-center my-3">
                <button type="button" class="btn btn-default mr-3" @click="$router.push('/admin/posts')">Back</button>
                <button type="submit" class="btn btn-success" :disabled="!isFormValid">Create</button>
            </div>            
        </form>


      </div>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'admin-post-page',
  data: function(){
    return {
        post : {
            title : '',
            status : 'draft',
            description : ''
        },
        errors : {
            title : '',
            status : '',
            description : ''
        },
        status : ['publish', 'draft', 'private']
    }
  },
  watch:{
        'post.title': function(newTitle){
            this.errors.title =  newTitle ? '' : 'Title is required';                            
        },
        'post.status': function(newStatus){
            this.errors.status =  this.status.includes(newStatus) ? '' : 'Status is required';                            
        },
        'post.description': function(newDesc){
            this.errors.description =  newDesc ? '' : 'Post description is required';                            
        },
  },
  computed:{
        isFormValid: function(){
            let valid = true;
            const self = this;
            for (const [key, value] of Object.entries(self.errors)) {
                if(self.post[key] == '' || value != ''){
                    valid = false;
                    break;
                }
            }            
            return valid;
        }
  },
  methods : {
    clear: function(){
        this.post = {
            title : '',
            status : 'draft',
            description : ''
        }
    },
    create: function(e){
        e.preventDefault();
        const self = this;
        if(self.isFormValid == false)
            return false;

        self.$store.commit('loading', true);
        self.axios.post(self.$api_url + 'admin/posts', self.post, { withCredentials: true,})
            .then(res => {
                self.$toast.success(res.data.message);
                self.clear();
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