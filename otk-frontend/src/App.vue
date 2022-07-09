<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/login">Bejelentkezés</router-link> |
    <router-link to="/register">Regisztráció</router-link>
  </nav>
  <router-view/>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

body{
  margin:0px;
  padding: 0px;
}

nav {
  padding: 30px;
  border-bottom: 1px solid #dfe1e5;
  box-shadow: 0 4px 6px -8px #222;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
  text-decoration: none;
}

nav a.router-link-exact-active {
  color: dodgerblue;
}
</style>
