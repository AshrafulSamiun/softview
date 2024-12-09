<template>
  <div
    :id="id"
    class="upload-container"
    @dragover.prevent="dragging = true"
    @dragleave.prevent="dragging = false"
    @drop.prevent="handleDrop"
  >
    <div v-if="!photo" class="upload-placeholder" :class="{ dragging }">
      <p>Drag and drop a photo or</p>
      <input
        type="file"
        :ref="inputRef"
        @change="handleFileChange"
        class="file-input"
      />
      <button @click="browseFile" type="button">Browse</button>
    </div>
    <div v-else class="preview">
      <img :src="photoUrl" alt="Uploaded Photo" />
      <button @click="removePhoto" type="button">Remove</button>
    </div>
  </div>
</template>

<script>
import {ref} from "vue";

export default {
  props: {
    id: {
      type: String,
      required: true,
    },
    modelValue: {
      type: Object,
      default: null,
    },
    inputRef: {
      type: String,
      default: "fileInput",
    },
  },
  emits: ["update:modelValue"],
  data() {
    return {
      dragging: false,
      photo: this.modelValue || null,
      photoUrl: this.modelValue?.url || null,
    };
  },
  methods: {
    async uploadFile(file) {
      const formData = new FormData();
      formData.append("photo", file);

      try {
        const response = await axios.post("/upload-photo", {image: this.asset_photo,image_file_name: 'asset_photo',image_folder_name: 'board_of_director'}, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        this.photoUrl = response.data.path;
        this.photo = { file, url: response.data.path };
        this.$emit("update:modelValue", this.photo); // Emit the updated value
      } catch (error) {
        alert("Upload failed.");
        console.error(error);
      }
    },

    createPhoto(){
                
      axios.post('/image/store',{image: this.asset_photo,image_file_name: 'asset_photo',image_folder_name: 'board_of_director'}).then(({ data }) => {
          var response=data.split("**");
          this.asset_image_temp_id=response[1];
         
          this.updateModePhoto=true;
          toast({
              type: 'success',
              title: 'Data Save Successfully'
          });
      });
  },
    handleDrop(event) {
      this.dragging = false;
      const file = event.dataTransfer.files[0];
      if (file) this.uploadFile(file);
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) this.uploadFile(file);
    },
    browseFile() {
      this.$refs[this.inputRef].click();
    },
    removePhoto() {
      this.photo = null;
      this.photoUrl = null;
      this.$emit("update:modelValue", null); // Emit null when the photo is removed
    },
  },
};
</script>

<style scoped>
.upload-container {
  border: 2px dashed #ccc;
  padding: 20px;
  text-align: center;
  cursor: pointer;
  position: relative;
}

.upload-placeholder {
  color: #999;
}

.upload-placeholder.dragging {
  background-color: #f0f8ff;
}

.file-input {
  display: none;
}

.preview img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto 10px;
}
</style>
