<template>
  <div>
    <div class="event">
      <div class="container">
        <router-link to="/gallerylist/1" title="กิจกรรมทั้งหมดของ GAMA">
          <h1>ภาพกิจกรรมของ GAMA</h1>
        </router-link>
        <div class="row">
          <div
            class="col-lg-3 col-6"
            v-for="(gallery,index) in Gallery.slice().reverse().slice(0,4)"
            :key="index"
            @click="seethisGallery(gallery.g_id)"
          >
            <div class="shadow-block1"></div>
            <div class="shadow-block2"></div>
            <img :src="getImgUrlGallery(gallery.g_image)" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    getImgUrlGallery(pic) {
      return this.path_files + "Gallery/" + pic;
    },
    seethisGallery(this_Gallery) {
      this.$router.push({
        name: "gallery",
        params: { GalleryID: this_Gallery }
      });
    }
  },
  computed: {
    path_files() {
      return this.$store.getters.getPath_Files;
    },
    Gallery() {
      return this.$store.getters.getGallery;
    }
  },
  created() {
    this.$store.dispatch("initDataGallery");
    this.$store.dispatch("initDataGallery_Image");
  }
};
</script>
<style scoped>
.event {
  height: 331px;
  background: linear-gradient(
    180deg,
    rgba(255, 255, 255, 0) 0%,
    rgba(255, 255, 255, 0.1) 48.44%,
    rgba(242, 242, 242, 0) 100%
  );
}

.event h1 {
  font-style: normal;
  font-weight: 600;
  font-size: 29px;
  line-height: 120%;
  text-align: center;
  color: rgba(255, 255, 255, 0.3);
}

.event img {
  position: relative;
  z-index: 0;
  margin-top: 29px;
  width: 253px;
  height: 190px;
  cursor: pointer;
  display: block;
  margin-left: auto;
  margin-right: auto;
  background: rgba(56, 105, 173, 0.131938);
  border-radius: 4px;
}

.event img:hover {
  transition: 0.25s;
  opacity: 0.7;
}

.shadow-block1,
.shadow-block2 {
  position: absolute;
  z-index: 0;
  box-sizing: border-box;
  margin-top: 29px;
  width: 253px;
  height: 190px;
  margin-left: auto;
  margin-right: auto;
  background: rgba(255, 255, 255, 0.131938);
  border-radius: 4px;
}
.shadow-block1:hover,
.shadow-block2:hover {
}

/* .shadow-block2 {
  position: absolute;
  z-index: 0;
  box-sizing: border-box;
  margin-top: 29px;
  width: 253px;
  height: 190px;
  background: rgba(255, 255, 255, 0.131938);
  border-radius: 4px;
} */

@media only screen and (max-width: 600px) {
  .event img {
    width: 100%;
    height: 80%;
  }
  .shadow-block1,
  .shadow-block2 {
    display: none;
  }
}
</style>