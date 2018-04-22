<template>
  <div>
    <div class="text-center map-responsive">
      <!-- <iframe
        width="600"
        height="450"
        frameborder="0" style="border:0"
        :src="`https://www.google.com/maps/embed/v1/place?key=${apiKey}&q=411+Nguyễn+Văn+Cừ,+Ngọc Lâm,+Long Biên,+Hà Nội,+Việt Nam`"
        allowfullscreen>
      </iframe> -->
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.6393672070085!2d105.87618021443622!3d21.047111092528546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a97e5c8bfb83%3A0xcdbdd375976534f1!2zNDExIE5ndXnhu4VuIFbEg24gQ-G7qywgTmfhu41jIEzDom0sIExvbmcgQmnDqm4sIEjDoCBO4buZaSwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1524401622795" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      apiKey: 'AIzaSyAQyy8Xg9ALAws7DPzrGFtteAeQ_iCbqfc'
    };
  }
};
</script>

<style lang="scss">
.map-responsive {
  position: relative;
  padding-bottom: 44.9%;
  overflow: hidden;
  height: 0;

  iframe {
    width: 100%;
    top: 0;
    position: absolute;
    left: 0;
    height: 100%;
  }
}
</style>
