<script>
import { useForm } from '@inertiajs/vue3'
import SideBar from '../Components/SideBar.vue';
import { router } from '@inertiajs/vue3'
import ServiceAddModal from '../Components/Modal/ServiceAddModal.vue';
import ServicePutModal from '../Components/Modal/ServicePutModal.vue';

export default {
    components: {
        SideBar,
        ServiceAddModal,
        ServicePutModal
    },
    name: 'Service',
    props: {
        services: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            service: useForm({
                name: '',
                reference: '',
                price: '',
            }),
        }
    },
    methods: {
        deleteService(serviceId) {
            try {
                this.$inertia.delete(`/services/${serviceId}`);
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>

<template>
    <SideBar />
    <div class="ms-5 mt-5 col-md-9">
        <div class="d-flex">
            <h1 class="ps-1">Services</h1>
            <button type="button" class="btn ms-4 btn-success align-items title-button" data-bs-toggle="modal"
                data-bs-target="#add">
                <i class="fas fa-add"></i>
            </button>
            <ServiceAddModal />
        </div>
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
                    <td class="align-middle col-3">
                        <button type="button" class="btn ms-4 btn-primary" data-bs-toggle="modal"
                            :data-bs-target="'#put-' + service.id">
                            <i class="fas fa-pencil"></i>
                        </button>
                        <ServicePutModal :serviceId="service.id" :service="service" />
                        <button type="button" class="btn btn-danger ms-4" @click="deleteService(service.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style>
.title-button {
    width: 40px;
    height: 40px;
}

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




