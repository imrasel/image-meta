<template>
  <div>

    <div class="container">

      <div v-if="isLoading" class="loading">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only"></span>
        </div>
      </div>

      <div v-else class="row">
        <div v-for="(photo, index) in photos" :key="index" class="col-sm-3 mt-3">
          <div class="image-item">
            <img class="img-thumbnail" :src="photo.url" alt="">
            <div class="overlay">
              <div class="actions">
                <button @click="showImage(photo)" class="btn btn-secondary btn-sm">View</button> <br>  
                <button @click="downloadItem(photo.url)" class="btn btn-secondary btn-sm mt-2">Download</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <nav aria-label="Page navigation" class="pages">
          <ul class="pagination pagination-dark">
            <li v-for="(link, index) in links" :key="index" class="page-item" :class="link.active ? 'active' : ''">
              <button @click.prevent="getPhotos(link.url)" class="page-link" ><span v-html="link.label">{{ link.label }}</span></button>
            </li>
          </ul>
      </nav>
      </div>
    </div>

  <modal-photo :photo="selectedPhoto"></modal-photo>
  </div>
</template>

<script>
import http from '../utils/axiosConfig';
import ModalPhoto from '../components/ModalPhoto';

export default {
  name: 'App',
  components: {
    ModalPhoto
  },
  data() {
    return {
      isLoading: false,
      image: '',
      url: '',
      query: '',
      photos: [],
      selectedPhoto: {},
      links: []
    }
  },

  methods: {
    downloadItem (url) {
      console.log(url);
      let filename = url.split('images/')[1];
      http.get('download/' + filename, { responseType: 'blob' })
        .then(response => {
          const blob = new Blob([response.data], { type: 'application/image' })
          const link = document.createElement('a')
          link.href = URL.createObjectURL(blob)
          link.download = filename
          link.click()
          URL.revokeObjectURL(link.href)
        }).catch(console.error)
    },
    showImage(photo) {
      this.selectedPhoto = photo;
      this.$bvModal.show('modal-image');
    },
    onFileSelect(e) {
      this.image = e.target.files[0];
    },
    getPhotos(url) {
      // console.log(url);
      // console.log(url ? url.split('?')[1]: []);
      // console.log(url.length);
      let param = '';
      if (url) {
        param = url ? url.split('?')[1] : '';
      }

      this.isLoading = true;
      http.get('photos?' + param)
        .then(response => {
          this.isLoading = false;
          console.log('response ', response.data);
          if (response.data.success) {
            this.photos = response.data.photos.data;
            this.links = response.data.photos.links;
            // this.$bvModal.show('modal-image');
          } else if (!response.data.success) {
            alert(response.data.error)
          } else {
            alert('Something went wrong!')
          }
        })
        .catch(error => {
          this.isLoading = false;
          console.log('error ', error)
          alert('Something went wrong')
        });
    }
  },
  mounted() {
    console.log(this.$route)
    this.query = this.$route.query.page ? this.$route.fullPath : '';
    this.getPhotos(this.query);
  }
}
</script>

<style>

.image {
  width: 300px;
  margin: 10px auto;
  text-align: center;
}
.image-item {
  position: relative;
}
.image-item:hover .overlay {
  opacity: 1;
}

.overlay {
  opacity: 0;
  transition: .3s ease-in-out;
  position: absolute;
  text-align: center;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba(0,0,0, 0.4);
}

.pages {
    float: right;
    margin-top: 40px;
    overflow: hidden;
}


.actions {
  padding-top: 30px;
}

.loading {
  width: 100%;
  text-align: center;
  height: 200px;
  padding-top: 100px;
}

.strong {
  font-weight: 600;
}
</style>
