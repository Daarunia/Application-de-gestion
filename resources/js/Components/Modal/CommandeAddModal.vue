<script>
import { useForm } from '@inertiajs/vue3';

export default {
    name: 'CommandeAddModal',
    props: {
        servicesName: {
            type: Object,
            required: true,
            default: null
        },
    },
    data() {
        return {
            services: [],
            form: useForm({
                name: '',
                reference: '',
                price: '',
            }),
            price: 0,
        };
    },
    methods: {
        fetchPrice(serviceName, quantity) {
            try {
                let encodedServiceName = serviceName.replace(/\//g, "|");
                const existingIndex = this.services.findIndex(service => service.name === serviceName);

                // If the service has not been added to the command, we create it otherwise, we update the quantity and the price.
                if (existingIndex === -1) {
                    axios.get(`/api/service/${encodedServiceName}/${quantity}`)
                    .then(response => {
                        this.services.push({ name: serviceName, quantity, price: parseFloat(response.data.price)});
                        this.price += parseFloat(response.data.price);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                } else {
                    this.services[existingIndex].quantity += quantity;
                    axios.get(`/api/service/${encodedServiceName}/${this.services[existingIndex].quantity}`)
                    .then(response => {
                        this.services[existingIndex].price = parseFloat(response.data.price);
                        this.price = parseFloat(response.data.price);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            } catch (error) {
                console.error(error);
            }
            console.log(this.services);
        },
    },
}
</script>

<template>
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="putModalLabel">Nouvelle commande</h5>
                </div>
                <div class="modal-padding modal-body modal-add-min-height">
                    <div class="d-flex align-items-center justify-content-center mt-2 b-2">
                        <select class="ms-3 form-select" v-model="selectedService">
                            <option v-for="service in servicesName">{{ service }}</option>
                        </select>
                        <button type="button" class="btn btn-success ms-4 me-4" @click="fetchPrice(selectedService, 1)">
                            <i class="fas fa-add"></i>
                        </button>
                    </div>
                </div>
                <div class="footer pt-2 footer-ligne d-flex justify-content-end align-items-center mb-2">
                    <label class="me-4">Prix :</label>
                    <input type="number" class="form-control w-25" readonly v-model=price>
                    <button type="button" class="btn btn-success ms-2" data-bs-dismiss="modal">Enregistrer</button>
                    <button type="button" class="btn btn-danger ms-2 me-2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.modal-add-min-height {
    min-height: 50px;
}
</style>
