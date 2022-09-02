<template>
  <div class="edit-section-video">
    <div class="container">
      <div class="wrap-icon6"></div>
      <div class="container container-two">
        <div class="videos-header">
          <h2>Videos</h2>
          <span class="video-desc">(Video máximo de 1 minuto)</span>
        </div>
        <div class="video-wrapper">
          <div class="row">
            <div
              class="col-md-12 col-lg-4"
              v-for="(video, index) in videos"
              :key="'videoform' + video.id"
            >
              <div class="video-item-wrap">
                <img
                  src="/img/quit.svg"
                  class="item-quit"
                  alt="quit"
                  @click="deleteVideo(index, video.id)"
                />
                <div class="video-item flex-sour" @click="openModal('/storage/' + video.url)">
                  <video :src="'/storage/' + video.url" style="width: 100%; height: 100%;"></video>
                </div>
              </div>
            </div>
            <div
              class="col-md-12 col-lg-4"
              v-for="(n, index) in (3 - videos.length)"
              :key="'videouload' +index"
            >
              <div class="video-item-wrap" @click.prevent="$refs.video2.click()">
                <div class="video-item item__empty-item">
                  <div class="empty-item">
                    <img src="/img/plusgrey.svg" alt="upload" class="uploadimage" />
                    <span>añadir video</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="video-desc-icon">
          <img src="/img/24-hours.svg" alt="hour" />
          <span>- Los videos solamente se publicarán en los portales tipo: slumi.com y erosguia.com. Dependiendo de su tarifa.</span>
        </div>
        <div v-for="(file, index) in files" :key="file.id">
            <div class="progress" v-if="(file.active || file.progress !== '0.00') && file.progress != 100">
                <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}"></div>
            </div>
        </div>
        <div class="wrap-all-btn loaded-wraper" v-if="videos.length <= 2">
          <file-upload
            input-id="video2"
            name="file"
            :post-action="'/video/store' + post.id"
            accept="video/mp4,video/avi,video/mov"
            class="btn btn-normal btn_green-hover avatar-upload-btn non-fixed-btn6"
            extensions="mp4,avi,mov"
            v-model="files"
            :headers="{ 'X-CSRF-TOKEN': csrf }"
            @input-filter="inputFilter"
            @input-file="inputFile"
            ref="upload"
          >
            <div>
              <img src="/img/plus.svg" alt="svg" />
              <span>Añadir vIDEOS</span>
            </div>
          </file-upload>

          <div v-for="(file, index) in files" :key="file.id">
            <span v-if="file.active">Wait. File loaded</span>
          </div>

        </div>
        <label for="video2" ref="video2" style="display: none;">clicker</label>
      </div>
    </div>
  </div>
</template>

<script>
import Modal from "./Modal.vue";
import FileUpload from "vue-upload-component";
import Notify from './Notify';

export default {
  components: {
    FileUpload
  },
  props: ["csrf", "post"],
  data() {
    return {
      videos: [],
      files: []
    };
  },
  mounted() {},
  created() {
    this.getVideos();
  },
  methods: {
    openModal(src) {
      this.$modal.show(
        Modal,
        {
          title: "Video",
          src
        },
        {
          width: "90%",
          maxWidth: 810,
          height: "auto",
          minWidth: 360,
          minHeight: 700
        }
      );
    },
    getVideos() {
      /*global axios*/

      axios
        .get("https://metrics.almejarosa.es/getvideos" + this.post.id)
        .then(response => {
          this.videos = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    alert(message) {
      alert(message);
    },
    deleteVideo(index, id) {
      const url = "https://metrics.almejarosa.es/video/destroy" + id;
      axios.delete(url);
      this.videos.splice(index, 1);
      console.log(id);
    },
    inputFile(newFile, oldFile) {
      if (newFile && !oldFile) {
        // Update file
        console.log("add");
        // Start upload

        // min size
        if (newFile.size >= 0 && newFile.size < 2.5e+8) {
          this.$refs.upload.active = true;
        } else {
          console.log(34234);
        }
      }
      if (newFile && oldFile) {
        // update
        console.log("update", newFile);
      }
      if (!newFile && oldFile) {
        // remove
        console.log("remove", oldFile);
      }

      if (newFile) {
        if (newFile.response == "Success") {
          this.$nextTick(function() {
            if (newFile.success == true) {
              this.getVideos();
            }
          });
        }
      }
    },
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Before adding a file
        // Filter system files or hide files

        if (newFile.size > 2.5e+8) {
          this.$modal.show(
            Notify,
            {
              title: "Error",
              type: "error",
              // porterrors: error.response.data.errors
              message: "Too large size!"
            },
            {
              width: 380,
              height: "auto"
            }
          );
          return prevent();
        }

        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent();
        }
        // Filter php html js file

        if (!/\.(mp4|avi|mov)$/i.test(newFile.name)) {
          this.$modal.show(
            Notify,
            {
              title: "Error",
              type: "error",
              // porterrors: error.response.data.errors
              message: "Choose mp4, avi or mov file!"
            },
            {
              width: 380,
              height: "auto"
            }
          );
          return prevent();
        }


      }
    }
  }
};
</script>

<style lang="scss" scoped>
.video-desc {
  font-size: 14px;
}

.item-quit {
  cursor: pointer;
}

.video-item {
  background-color: black;
}

.item__empty-item {
  background-color: transparent;
}

.loaded-wraper{
  display: flex;
  align-items: center;
  .file-uploads-html5{
    margin-right: 15px;
  }
}

.progress
{
    height: 5px;
    background: #e0e0e0;
    margin: 5px 0 10px 0;
    border-radius: 5px;
    .progress-bar
    {
        background: #fe6885;
        height: 5px;
    }
}
</style>
