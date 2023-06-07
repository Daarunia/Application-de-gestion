<template>
    <SideBar/>
    <div class="col-md-9">
        <p>Service</p>
    </div>
</template>

<script>
import SideBar from '../Components/SideBar.vue';

export default {
    components: {
        SideBar,
    },
    name: 'Service',
    props: {
      name: String,
    },
  };
</script>

<style>
#app{
  display: flex;
  height: 100%;
}

html{
    height: 100%;
}
</style>




