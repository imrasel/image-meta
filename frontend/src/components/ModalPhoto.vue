
<template>
  <b-modal id="modal-image" size="xl" title="Image Meta">
    <div class="image">
      <img class="img-thumbnail" :src="photo.url" alt="">
    </div>
    
    <div class="meta-data mt-4">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h4>Camera</h4>
              <table class="table table-striped">
                <tbody>
                  <tr v-for="(item, index) in camera" :key="index">
                    <td class="strong">{{ index }}</td>
                    <td>{{ item }}</td>
                  </tr>
                </tbody>
              </table>
              <span v-if="camera.length == 0" class="text-danger">No camera data found</span>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h4>Author and copyrights</h4>
              <table class="table table-striped">
                <tbody>
                  <tr v-for="(item, index) in copyrights" :key="index">
                    <td class="strong">{{ index }}</td>
                    <td>{{ item }}</td>
                  </tr>
                </tbody>
              </table>
              <span v-if="copyrights.length == 0" class="text-danger">No copyrights data found</span>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h4>Exif</h4>
              <table class="table table-striped">
                <tbody>
                  <tr v-for="(item, index) in exifs" :key="index">
                    <td class="strong">{{ index }}</td>
                    <td>{{ item }}</td>
                  </tr>
                </tbody>
              </table>

              <span v-if="exifs.length == 0" class="text-danger">No exif data found</span>
              
            </div>
          </div>
        </div>
      </div>

      
    </div>

    <template #modal-footer="{}">
      <div></div>
    </template>

  </b-modal>
</template>

<script>
export default {
  props: ['photo'],
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
}
</script>

<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
