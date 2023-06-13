<template>
    <SideBar />
    <div class="col-md-9">
        <p>Commande</p>
    </div>
</template>

<script>
import SideBar from '@/Components/SideBar.vue';
import ServiceAddModal from '../Components/Modal/ServiceAddModal.vue';

export default {
    name: 'Commande',
    components: {
    SideBar,
    ServiceAddModal,
    ServiceAddModal
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
