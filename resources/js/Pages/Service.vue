<template>
    <SideBar />
    <div class="ms-5 mt-5 col-md-9">
        <h1 class="ps-1">Services</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="service in $page.props.services" :key="service.id">
                    <td class="align-middle">{{ service.reference }}</td>
                    <td class="align-middle">{{ service.name }}</td>
                    <td class="align-middle">{{ service.price }}</td>
                    <td class="align-middle text-center col-3">
                        <button class="btn btn-primary">
                            <i class="fas fa-pencil"></i>
                        </button>
                        <button type="button" class="btn ms-4 btn-success">
                            <i class="fas fa-add"></i>
                        </button>
                        <button class="btn btn-danger ms-4">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import SideBar from '../Components/SideBar.vue';
import ServiceModal from '../Components/ServiceModal.vue';

export default {
    components: {
        SideBar,
        ServiceModal
    },
    name: 'Service',
    props: {
        services: {
            type: Array,
            default: () => [],
        },
    },
};
</script>

<style>
.table {
    width: 70%;
}

#app {
    display: flex;
    height: 100%;
}

html {
    height: 100%;
}
</style>




