<template>
  <div id="app">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">ImageMeta</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <router-link to="/" tag="a" class="nav-link">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/images" tag="a" class="nav-link">Uploaded Images</router-link>
          </li>
        </ul>
      </div>
      </div>
    </nav>

    <router-view></router-view>

  </div>
</template>

<script>
import http from '../src/utils/axiosConfig';

export default {
  name: 'App',
  components: {
  },
  data() {
    return {
      image: '',
      url: '',
      photo: {}
    }
  },
  computed: {
    camera() {
      return this.photo.camera ? JSON.parse(this.photo.camera) : [];
    },
    copyrights() {
      return this.photo.copyrights ? JSON.parse(this.photo.copyrights) : [];
    },
    exifs() {
      return this.photo.exifs ? JSON.parse(this.photo.exifs) : [];
    }
  },
  methods: {
    onFileSelect(e) {
      this.image = e.target.files[0];
    },
    storePhoto() {
      let data = new FormData();
      data.append('image', this.image);
      data.append('url', this.url);

      http.post('photos', data)
        .then(response => {
          console.log('response ', response.data);
          if (response.data.success) {
            this.photo = response.data.photo;
            this.$bvModal.show('modal-image');
          } else if (!response.data.success) {
            alert(response.data.error)
          } else {
            alert('Something went wrong!')
          }
        })
        .catch(error => {
          console.log('error ', error)
          alert('Something went wrong. May be file not supproted')
        });
    }
  },
  mounted() {
    // this.storePhoto();
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  /* margin-top: 60px; */
}

.image {
  width: 300px;
  margin: 10px auto;
  text-align: center;
}

.strong {
  font-weight: 600;
}
</style>
