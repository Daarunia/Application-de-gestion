<template>
    <SideBar/>
    <div class="col-md-9">
        <p>Commande</p>
    </div>
</template>

<script>
import SideBar from '../Components/SideBar.vue';

export default {
    components: {
        SideBar,
    },
    name: 'Commande',
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
