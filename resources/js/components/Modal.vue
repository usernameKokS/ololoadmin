<template>
  <div class="appmodal">
    <div class="modal-container">
      <div class="modal-header">
        <h3>{{ title }}</h3>
        <img src="/img/closemodal.svg" alt="modal" @click="$emit('close')" />
      </div>
      <div class="modal-body">
        <video-player
          class="vjs-custom-skin"
          ref="videoPlayer"
          :options="playerOptions"
          :playsinline="true"
        ></video-player>
      </div>
    </div>
  </div>
</template>

<script>
// import videojs from 'video.js';

export default {
  props: ['title', 'src'],
  data() {
    return {
      ms: 2134,
      playerOptions: {
        height: '360',
        autoplay: false,
        muted: true,
        language: 'es',
        playbackRates: [0.7, 1.0, 1.5, 2.0],
        sources: [
          {
            type: 'video/mp4',
            src: this.src,
          },
        ],
      },
    };
  },
  mounted() {
    console.log('Modal open');
  },
  created() {
    document.body.style.overflow = 'hidden';
  },
  beforeDestroy() {
    document.body.style.overflow = 'auto';
  },
};
</script>
