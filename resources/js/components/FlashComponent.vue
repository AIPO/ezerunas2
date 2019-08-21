<template>
  <div class="alert alert-warning alert-flash" role="alert" v-show="show">
    <strong>Success</strong>
    {{body}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</template>

<script>
import { setTimeout } from "timers";
export default {
  props: ["message"],
  data() {
    return {
      body: "",
      show: false
    };
  },
  created() {
    if (this.message) {
      this.flash();
    }
    window.events.$on("flash", message => {
      this.flash(message);
    });
  },
  methods: {
    flash(message) {
      this.body = message;
      this.show = true;
      this.hide();
    },
    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
<style>
.alert-flash {
  position: fixed;
  right: 25px;
  bottom: 20px;
}
</style>
