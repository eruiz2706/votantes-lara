<template>
    <div>
      <router-link to="/example">Example1</router-link>
      <router-link to="/example2">Example2</router-link>

      <router-view></router-view>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
