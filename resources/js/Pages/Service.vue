<script>
import { useForm } from '@inertiajs/vue3'
import SideBar from '../Components/SideBar.vue';
import ServiceAddModal from '../Components/Modal/ServiceAddModal.vue';
import ServicePutModal from '../Components/Modal/ServicePutModal.vue';
import moment from 'moment';


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
                this.$inertia.delete(`/service/${serviceId}`);
            } catch (error) {
                console.error(error);
            }
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY HH:mm');
        },
    },
};
</script>

<template>
    <SideBar />
    <div class="mt-5 col-md-9 content">
        <div class="d-flex">
            <h1 class="ps-1">Services</h1>
            <button type="button" class="btn ms-4 btn-success align-items title-button" data-bs-toggle="modal"
                data-bs-target="#add">
                <i class="fas fa-add"></i>
            </button>
            <ServiceAddModal />
        </div>
        <table class="table table-service mt-3">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Date de création</th>
                    <th>Date de mise à jour</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="service in $page.props.services" :key="service.id">
                    <td class="align-middle">{{ service.reference }}</td>
                    <td class="align-middle">{{ service.name }}</td>
                    <td class="align-middle">{{ service.price }}</td>
                    <td class="align-middle">{{ formatDate(service.created_at) }}</td>
                    <td class="align-middle">{{ formatDate(service.updated_at) }}</td>
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

.content{
    margin-left: 300px;
}

#app {
    display: flex;
    height: 100%;
}

html, body {
    height: 100%;
    overflow-y: auto;

}
</style>




