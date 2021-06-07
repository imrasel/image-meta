<template>
  <div id="app">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <router-link to="/" class="navbar-brand" tag="a">ImageMeta</router-link>
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

export default {
  name: 'App',
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

</style>
