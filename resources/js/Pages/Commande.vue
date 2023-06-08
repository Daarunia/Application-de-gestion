<template>
    <SideBar/>
    <div class="col-md-9">
        <p>Commande {{ $page.props.name }}</p>
    </div>
</template>

<script>
import SideBar from '../Components/SideBar.vue';

export default {
    components: {
        SideBar,
    },
    name: 'Commande',
    mounted() {
        console.log(this.$page.name);
    }
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
