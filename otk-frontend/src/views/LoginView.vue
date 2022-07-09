<template>
  <div class="login">
    <div class="center">
        <h1>{{loginLabels.login}}</h1>
        <form>
            <div class="inputbox">
                <input type="text" required="required" v-model="email">
                <span>{{loginLabels.email}}</span>
                </div>
                <div class="inputbox">
                <input type="text" required="required" v-model="password">
                <span>{{loginLabels.password}}</span>
                </div>
                <div class="inputbox">
                <input type="button" value="Mehet!" class="submit">
            </div>
        </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { LOGIN } from '../labels/labels';
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'

export default defineComponent({
  name: 'LoginView',
  components: {
    
  },

  data(){
    return{
      email: "",
      password: ""
    }
  },

  methods:{
  },

  computed:{
    loginLabels() {
      return LOGIN;
    }
  }
});
</script>

<style scoped>

.login{
    text-align: left;
}

@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
/* body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(45deg, greenyellow, dodgerblue);
  font-family: "Sansita Swashed", cursive;
} */
.center {
  position: relative;
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
}
.center h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}
.center .inputbox {
  position: relative;
  width: 300px;
  height: 50px;
  margin-bottom: 25px;
}
.center .inputbox input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  border: 2px solid #000;
  outline: none;
  background: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 1.2em;
}
.center .inputbox:last-child {
  margin-bottom: 0;
}
.center .inputbox span {
  position: absolute;
  top: 14px;
  left: 20px;
  font-size: 1em;
  transition: 0.6s;
  font-family: sans-serif;
}
.center .inputbox input:focus ~ span,
.center .inputbox input:valid ~ span {
  transform: translateX(-13px) translateY(-35px);
  font-size: 1em;
}
.center .inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.center .inputbox:hover [type="button"] {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.submit:hover{
    cursor:pointer;
}

</style>