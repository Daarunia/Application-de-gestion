<script>
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { ref } from 'vue';

export default {
    name: 'CommandeAddModal',
    components: {
        FlatPickr
    },
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
            date: ref('2023-06-28'),
            isAddingService: false,
            form: {
                status: false,
                categories: [],
                totalPrice: 0,
                commandDate: null,
            },
        };
    },
    methods: {
        createCommand() {
            this.form.categories = this.services,
            this.form.totalPrice = this.totalPrice(),
            this.form.commandDate = this.date

            try {
                console.log(this.form);
                this.$inertia.post('/commandes', this.form);
                // Re-init
                this.services = [];
                this.date = ref('2023-06-28');
            } catch (error) {
                console.log(error);
            }
        },
        totalPrice() {
            return this.services.reduce((total, service) => total + service.price, 0);
        },
        async addService(serviceName, quantity) {
            this.isAddingService = true;
            try {
                let encodedServiceName = serviceName.replace(/\//g, "|");
                const existingIndex = this.services.findIndex(service => service.name === serviceName);

                // If the service has not been added to the command, we create it otherwise, we update the quantity and the price.
                if (existingIndex === -1) {
                    let response = await this.updatePrice(serviceName, quantity)

                    this.services.push({ name: serviceName, quantity, price: parseFloat(response.data.price) });
                    this.isAddingService = false;
                } else {
                    this.services[existingIndex].quantity += quantity;
                    let response = await this.updatePrice(serviceName, this.services[existingIndex].quantity)

                    this.services[existingIndex].price = parseFloat(response.data.price);
                    this.isAddingService = false;
                }
            } catch (error) {
                console.error(error);
            }
        },
        // For incrementing the quantity of the service by 1
        async decreaseQuantity(service) {
            if (service.quantity > 0) {
                service.quantity--;
                await this.handleQuantityChange(service);
            }
        },
        // For decrementing the quantity of the service by 1
        async increaseQuantity(service) {
            if (service.quantity < 999) {
                service.quantity++;
                await this.handleQuantityChange(service);
            }
        },
        // Update the quantity of a service
        async handleQuantityChange(service) {
            const indexNumber = this.services.findIndex(services => services.name === service.name);

            let response = await this.updatePrice(service.name, service.quantity)
            this.services[indexNumber].price = parseFloat(response.data.price);
            console.log(this.services);
        },
        // Update the price accordingly when manually changing the quantity input of a service
        async updatePrice(serviceName, quantity) {
            let encodedServiceName = serviceName.replace(/\//g, "|");
            try {
                return await axios.get(`/api/service/${encodedServiceName}/${quantity}`);
            } catch (error) {
                console.log(error);
                throw error;
            }
        },
        // Delete a specific service type from the services array for the current new command.
        deleteService(service) {
            this.services.splice(this.services.findIndex(services => services.name === service.name), 1);
            this.totalPrice();
        },
        toggleLock() {
            this.form.status = !this.form.status;
        },
    },
}
</script>

<template>
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="putModalLabel">Nouvelle commande</h3>
                </div>
                <div class="modal-padding modal-body modal-add-min-height">
                    <div class="d-flex align-items-start flex-column justify-content-between ms-3 mb-3">
                        <h5 class="mt-3">Informations de commande</h5>
                        <div class="horizontal-line grey-line mb-2"></div>
                        <div class="d-flex align-items-center flex-row">
                            <div class="d-flex align-items-center flex-row ms-2">
                                <label class="me-3">Date :</label>
                                <flat-pickr class="form-control text-center w-50" v-model="date"></flat-pickr>
                            </div>
                            <label class="me-4">Status :</label>
                            <button @click="toggleLock" :class="form.status ? 'btn btn-danger' : 'btn btn-primary'">
                                <i :class="form.status ? 'fas fa-lock' : 'fas fa-unlock'"></i>
                            </button>
                        </div>
                        <h5 class="mt-3">Services</h5>
                        <div class="horizontal-line grey-line mb-2"></div>
                        <div class="d-flex align-items-start flex-row mb-1 ms-2 mt-1 w-100" v-for="service in services">
                            <input type="text" class="form-control w-50 me-5" readonly :value="service.name">
                            <div class="input-group w-25 ms-5">
                                <button class="btn btn-outline-secondary" type="button"
                                    @click="decreaseQuantity(service)">-</button>
                                <input min="0" max="999" type="number" class="form-control text-center"
                                    @input="handleQuantityChange(service)" v-model="service.quantity">
                                <button class="btn btn-outline-secondary" type="button"
                                    @click="increaseQuantity(service)">+</button>
                            </div>
                            <button type="button" class="btn btn-danger ms-4" @click="deleteService(service)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-2 ms-3 mb-2">
                        <select class="form-select" v-model="selectedService">
                            <option v-for="service in servicesName">{{ service }}</option>
                        </select>
                        <button type="button" class="btn btn-success ms-4 me-4" @click="addService(selectedService, 1)"
                            :disabled="isAddingService">
                            Ajouter
                        </button>
                    </div>
                </div>
                <div class="footer pt-2 footer-ligne d-flex justify-content-end align-items-center mb-2">
                    <label class="me-4">Prix :</label>
                    <input type="number" class="form-control w-25" readonly :value=totalPrice()>
                    <button type="button" class="btn btn-success ms-2" data-bs-dismiss="modal"
                        @click.prevent="createCommand()">Enregistrer</button>
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
