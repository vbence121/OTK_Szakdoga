<template>
  <div class="register">
    <div class="center">
        <h1>Regisztráció</h1>
        <form>
            <div class="inputbox">
            <input type="text" required="required" v-model="email">
            <span>Email</span>
            </div>
            <div class="inputbox">
            <input type="text" required="required" v-model="username">
            <span>Felhasználónév</span>
            </div>
            <div class="inputbox">
            <input type="text" required="required" v-model="realName">
            <span>Teljes név</span>
            </div>
            <div class="inputbox">
            <input type="text" required="required" v-model="phoneNumber">
            <span>Telefonszám</span>
            </div>
            <div class="inputbox">
            <input type="text" v-model="company">
            <span>Cég/Szervezet</span>
            </div>
            <div class="inputbox">
            <input type="text" required="required" v-model="password">
            <span>Jelszó</span>
            </div>
            <div class="inputbox">
            <input type="text" required="required" v-model="passwordAgain">
            <span>Jelszó újra</span>
            </div>
            <div class="inputbox">
            <input type="submit" value="Mehet!" class="submit" @click="submit">
            </div>
        </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'

export default defineComponent({
  name: 'RegisterView',
  components: {
    
  },

  data(){
    return{
      email: "",
      username: "",
      password: "",
      passwordAgain: "",
      realName: "",
      phoneNumber: "",
      company: "",

      errorMessage: "",
    }
  },

  methods:{

    async submit(): Promise<void>{
      const userData = JSON.stringify({ 
        email: this.email,
        username: this.username,
        password: this.password,
        passwordAgain: this.passwordAgain,
        realName: this.realName,
        phoneNumber: this.phoneNumber,
        company: this.company   
      });
      console.log(userData);
      axios.post("https://79da43d4-5562-43ed-bebe-441c7f7b271e.mock.pstmn.io", userData)
      .then(response => {
        console.log(response);

      })
      .catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
    });
    }
  }
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");

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
.center .inputbox [type="submit"] {
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