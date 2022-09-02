<template>
  <div class="edit-section-photo">
    <div class="container">
      <div class="wrap-icon5"></div>
      <div class="container container-two">
        <h2>Fotos</h2>
        <div class="photo-content">
          <div class="photos-wrap">
            <div class="item-wrapper" v-for="(image, index) in images" :key="image.id  + '-label'">
              <img
                src="/img/quit.svg"
                class="item-quit"
                alt="quit"
                @click="deleteImage(index, image.id)"
              />
              <div
                class="item itemActiveSeter"
                @click="setActive(image.id)"
                :style="'background: url(/storage' +  image.url + ')'"
              >
                <div class="wrapper-activ-photo" v-if="image.active">
                  <div class="activ-photo">Foto principal</div>
                </div>
              </div>
            </div>

            <div class="item-wrapper" v-for="(n, index) in (10 - images.length)" :key="index">
              <div class="item item--addphoto" @click.prevent="$refs.avatar2.click()">
                <div class="empty-item">
                  <img src="/img/plusgrey.svg" alt="upload" class="uploadimage" />
                  <span>añadir foto</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <p class="photo-desc">
            *Haz click sobre la foto que quieres tener
            como portada en tu anuncio y que aparezca en los listados.
        </p>
        <div v-for="(file, index) in files" :key="file.id">
            <div class="progress" v-if="(file.active || file.progress !== '0.00') && file.progress != 100">
                <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}"></div>
            </div>
        </div>
        <div class="wrap-all-btn" v-if="images.length <= 9">
          <file-upload
            extensions="gif,jpg,jpeg,png,webp"
            accept="image/png, image/gif, image/jpeg, image/webp"
            name="avatar"
            input-id="avatar2"
            :post-action="'/avatar/store' + post_id"
            class="btn btn-normal btn_green-hover avatar-upload-btn non-fixed-btn5"
            :drop="!edit"
            v-model="files"
            :headers="{ 'X-CSRF-TOKEN': csrf }"
            @input-filter="inputFilter"
            @input-file="inputFile"
            ref="upload"
            success="getImages"
          >
            <div>
              <img src="/img/plus.svg" alt="svg" />
              <span>Añadir fotos</span>
            </div>
          </file-upload>
        </div>
        <label for="avatar2" ref="avatar2" style="display: none;">clicker</label>
      </div>
    </div>
  </div>
</template>

<script>
import FileUpload from "vue-upload-component";
import Notify from './Notify';

export default {
  props: ["csrf", "post"],
  data() {
    return {
      images: [],
      files: [],
      edit: false,
      post_id: this.post.id
    };
  },
  components: {
    FileUpload
  },
  mounted() {
    this.getImages();
  },
  methods: {
    closeModal() {
      this.$refs.upload.clear();
      this.$modal.hide("cropper-modal");
    },
    setActive(id) {
      const url = "https://metrics.almejarosa.es/avatar/active";
      axios
        .post(url, {
          id: id,
          post_id: this.post_id
        })
        .then(res => {
          this.images = res.data;
        });
    },
    getImages() {
      axios.get(`https://metrics.almejarosa.es/getimages` + this.post.id).then(response => {
        this.images = response.data;
      });
    },
    deleteImage(index, id) {
      const url = "https://metrics.almejarosa.es/avatar/destroy" + id;
      axios.post(url).then(res => {
        this.images = res.data;
      });
      // this.images.splice(index, 1);
    },
    alert(message) {
      alert(message);
    },
    inputFile(newFile, oldFile) {
      if (newFile && !oldFile) {
        this.$refs.upload.active = true;
      }
      if (newFile) {
        if (newFile.response == "Success") {
          this.$nextTick(function() {
            if (newFile.success == true) {
              this.getImages();
            }
          });
        }
      }

      if (!newFile && oldFile) {
        this.edit = false;
      }
    },
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(gif|jpg|jpeg|png|webp)$/i.test(newFile.name)) {
          this.$modal.show(
            Notify,
            {
              title: "Error",
              type: "error",
              // porterrors: error.response.data.errors
              message: "Choose picture!"
            },
            {
              width: 380,
              height: "auto"
            }
          );
          return prevent();
        }

        if (newFile.size > 10000024) {
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
      }
      if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
        newFile.url = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.url = URL.createObjectURL(newFile.file);
        }
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@import "~cropperjs/dist/cropper.css";

.modal-croped {
  width: 100%;
  margin: 0 auto;
}

.item-quit {
  cursor: pointer;
}

.itemActiveSeter {
  background-size: cover !important;
  background-repeat: no-repeat !important;
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
