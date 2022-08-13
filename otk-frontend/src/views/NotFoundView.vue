<template>
  <div>
    <div class="error">
        404
    </div>
    <h1 class="sign">a keresett oldal nem található!</h1>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "NotFound",
});
</script>

<style scoped>

.error {
    font-size: 20vh;
    text-align: center;
}

.sign {
    text-align: center;
}
    
</style>