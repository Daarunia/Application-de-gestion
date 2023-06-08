<template>
    <SideBar />
    <div class="col-md-9">
        <p>Commande {{ $page.props.name }}</p>
    </div>
</template>

<script>
import SideBar from '@/Components/SideBar.vue';

export default {
    name: 'Commande',
    components: {
        SideBar,
    },
};
</script>

<style>
#app {
    display: flex;
    height: 100%;
}

html {
    height: 100%;
}
</style>
