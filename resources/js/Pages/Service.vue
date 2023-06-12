<script>
import { useForm } from '@inertiajs/vue3'
import SideBar from '../Components/SideBar.vue';
import { router } from '@inertiajs/vue3'
import axios from 'axios';

export default {
    components: {
        SideBar,
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
            form: useForm({
                name: '',
                reference: '',
                price: '',
            }),
        };
    },
    methods: {
        submitService() {
            try {
                router.post('/services', this.form);
                window.location.reload();
            } catch (error) {
                console.error(error);
            }
        },
        deleteService(serviceId) {
            try {
                axios.delete(`/services/${serviceId}`);
                window.location.reload()
            } catch (error) {
                console.error(error);
            }
        },
        updateService() {
            try {
                router.put(`/services/${this.serviceId}`, this.form);
            } catch (error) {
                console.error(error);
            }
        }
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
            <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nouveau service</h5>
                        </div>
                        <form id="add" @submit.prevent="submitService">
                            <div class="modal-body">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nom"
                                    v-model="form.name">
                                <label for="reference" class="form-label mt-3">Référence</label>
                                <input type="text" class="form-control" id="reference" name="reference"
                                    placeholder="Référence" v-model="form.reference">
                                <label for="price" class="form-label mt-3">Prix</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Prix"
                                    v-model="form.price">
                            </div>
                            <div class="footer d-flex justify-content-end">
                                <button class="btn btn-secondary me-2 mb-2" data-bs-dismiss="modal">Annuler
                                </button>
                                <button type="submit" class="btn btn-success me-2 mb-2"
                                    data-bs-dismiss="modal">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                        <button type="button" class="btn ms-4 btn-primary" data-bs-toggle="modal" data-bs-target="#update">
                            <i class="fas fa-pencil"></i>
                        </button>
                        <div class="modal fade" id="update" tabindex="-1" aria-labelledby="addModal" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalLabel">Modifier un service</h5>
                                    </div>
                                    <form :id="'form-' + service.id" @submit.prevent="updateService">
                                        <div class="modal-body">
                                            <label for="name" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="name" name="name" :placeholder="service.name"
                                                v-model="form.name">
                                            <label for="reference" class="form-label mt-3">Référence</label>
                                            <input type="text" class="form-control" id="reference" name="reference"
                                                :placeholder="service.reference" v-model="form.reference">
                                            <label for="price" class="form-label mt-3">Prix</label>
                                            <input type="text" class="form-control" id="price" name="price" placeholder="Prix"
                                                :placeholder="service.price" v-model="form.price">
                                        </div>
                                        <div class="footer d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary me-2 mb-2"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-success me-2 mb-2" data-bs-dismiss="modal">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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




