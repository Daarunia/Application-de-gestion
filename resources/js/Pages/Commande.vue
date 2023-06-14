<template>
    <SideBar />
    <div class="ms-5 mt-5 col-md-9">
        <div class="d-flex">
            <h1 class="ps-1">Commandes</h1>
            <button type="button" class="btn ms-4 btn-success align-items title-button" data-bs-toggle="modal"
                data-bs-target="#add">
                <i class="fas fa-add"></i>
            </button>
        </div>
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
