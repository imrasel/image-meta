<template>
  <div>
    <div class="container">
      <div v-if="isLoading" class="loading">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only"></span>
        </div>
      </div>

      <div v-else class="offset-sm-3 col col-sm-6">
        <div class="drop-image">
          <form @submit.prevent="storePhoto" enctype="multipart/form-data">
            <div class="form-group mt-3">
              <label for="image" class="strong">Upload a file</label>
              <input @change="onFileSelect" type="file" name="image" class="form-control mt-2" id=""  >
            </div>
            <div class="form-group mt-4">
              <label for="url" class="strong">Or input an image url</label>
              <input type="text" v-model="url" name="url" class="form-control mt-2" id="" placeholder="">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-info mt-2">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <modal-photo :photo="photo"></modal-photo>

  </div>
</template>

<script>
import http from '../utils/axiosConfig';
import ModalPhoto from '../components/ModalPhoto';

export default {
  name: 'ImageUpload',
  components: {
    ModalPhoto
  },
  data() {
    return {
      image: '',
      url: '',
      photo: {},
      isLoading: false,
    }
  },

  methods: {
    onFileSelect(e) {
      this.image = e.target.files[0];
    },
    storePhoto() {
      let data = new FormData();
      if (!this.image && !this.url) {
        alert('Please select and image or enter an url');
        return
      }
      data.append('image', this.image);
      data.append('url', this.url);

      this.isLoading = true;
      http.post('photos', data)
        .then(response => {
          this.isLoading = false;
          console.log('response ', response.data);
          if (response.data.success) {
            this.image = this.url = '';
            this.photo = response.data.photo;
            this.$bvModal.show('modal-image');
          } else if (!response.data.success) {
            alert(response.data.error)
          } else {
            alert('Something went wrong!')
          }
        })
        .catch(error => {
          this.isLoading = false;
          console.log('error ', error)
          alert('Something went wrong. May be file not supproted')
        });
    }
  },
}
</script>

<style>

.image {
  width: 300px;
  margin: 10px auto;
  text-align: center;
}

.strong {
  font-weight: 600;
}
</style>
