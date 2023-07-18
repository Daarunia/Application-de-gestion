<script>
import moment from 'moment';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    name: 'CommandePutModal',
    components: {
        FlatPickr
    },
    props: {
        updateData: {
            type: Object,
            required: true,
            default: null
        },
        servicesName: {
            type: Object,
            required: true,
            default: null
        },
    },
    data() {
        return {
            isAddingService: false,
            form: {
                categories: [],
                totalPrice: 0,
                commandDate: null,
            },
        }
    },
    computed: {
        totalPrice() {
            if (this.updateData && this.updateData.services) {
                let totalPrice = 0;
                for (const serviceName in this.updateData.services) {
                    const service = this.updateData.services[serviceName];
                    totalPrice += service.price;
                }
                return totalPrice;
            }
            return 0;
        },
    },
    methods: {
        formatDate(date) {
            return moment(date).format('YYYY-MM-DD');
        },
        async addService(serviceName, quantity) {
            this.isAddingService = true;
            try {
                // If the service has not been added to the command, we create it otherwise, we update the quantity and the price.
                if (this.updateData.services.hasOwnProperty(serviceName)) {
                    this.updateData.services[serviceName].quantity += quantity;
                    let response = await this.updatePrice(serviceName, this.updateData.services[serviceName].quantity)

                    this.updateData.services[serviceName].price = parseFloat(response.data.price);
                    this.isAddingService = false;
                } else {
                    let response = await this.updatePrice(serviceName, quantity)

                    this.updateData.services[serviceName] = {
                        quantity: quantity,
                        price: parseFloat(response.data.price)
                    };
                    this.isAddingService = false;
                }
            } catch (error) {
                console.error(error);
            }
        },
        // For incrementing the quantity of the service by 1
        async decreaseQuantity(service) {
            if (this.updateData.services[service].quantity > 0) {
                this.updateData.services[service].quantity--;
                await this.handleQuantityChange(service);
            }
        },
        // For decrementing the quantity of the service by 1
        async increaseQuantity(service) {
            if (this.updateData.services[service].quantity < 999) {
                this.updateData.services[service].quantity++;
                await this.handleQuantityChange(service);
            }
        },
        // Update the quantity of a service
        async handleQuantityChange(service) {
            let response = await this.updatePrice(service, this.updateData.services[service].quantity)
            this.updateData.services[service].price = parseFloat(response.data.price);
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
            if (this.updateData.services.hasOwnProperty(service)) {
                delete this.updateData.services[service];
            }
        }
    }
}
</script>

<template>
    <div class="modal fade" id="put" tabindex="-1" aria-labelledby="putModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="putModalLabel">Mise à jour d'une commande</h3>
                </div>
                <div class="ms-2 modal-padding modal-body modal-add-min-height">
                    <div class="d-flex align-items-start flex-column justify-content-between ms-3 mb-3">
                        <h5 class="mt-3">Date</h5>
                        <div class="horizontal-line grey-line mb-2"></div>
                        <div class="d-flex align-items-center flex-row ms-2">
                            <label class="me-4">Date de commande :</label>
                            <flat-pickr class="form-control text-center w-50" v-model="date"
                                :value="formatDate(updateData?.date)"></flat-pickr>
                        </div>
                        <h5 class="mt-3">Services</h5>
                        <div class="horizontal-line grey-line mb-2"></div>
                        <div class="d-flex align-items-start flex-row mb-1 ms-2 mt-1 w-100"
                            v-for="(value, key) in updateData?.services" :key="key">
                            <input type="text" class="form-control w-50 me-5" readonly :value="key">
                            <div class="input-group w-25 ms-5">
                                <button class="btn btn-outline-secondary" type="button"
                                    @click="decreaseQuantity(key)">-</button>
                                <input min="0" max="999" type="number" class="form-control text-center"
                                    :value="value.quantity">
                                <button class="btn btn-outline-secondary" type="button"
                                    @click="increaseQuantity(key)">+</button>
                            </div>
                            <button type="button" class="btn btn-danger ms-4" @click="deleteService(key)">
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
                    <input type="number" class="form-control w-25" readonly :value="totalPrice">
                    <button type="button" class="btn btn-danger ms-4 me-2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>
