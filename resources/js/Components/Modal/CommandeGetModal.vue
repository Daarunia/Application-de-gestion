<script>
import moment from 'moment';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

export default {
    name: 'CommandeGetModal',
    components: {
        PulseLoader,
    },
    props: {
        isLoading: {
            type: Boolean,
            required: true,
        },
        getData: {
            type: Object,
            required: true,
            default: null
        },
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY HH:mm');
        },
    }
}
</script>

<template>
    <div class="modal fade" id="get" tabindex="-1" aria-labelledby="getModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="getModalLabel">Commande</h2>
                </div>
                <div v-if="isLoading" class="ms-2 modal-padding modal-body modal-add-min-height">
                    <div class="spinner">
                        <pulse-loader :loading="isLoading" :color="spinnerColor" :size="spinnerSize"></pulse-loader>
                    </div>
                </div>
                <div v-else class=" ms-5 modal-padding modal-body">
                    <div class="mt-2 d-flex justify-content-start align-items-center">
                        <label class="me-3">Date de création :</label>
                        <input type="text" class="form-control w-25 me-4" readonly
                            :value="formatDate(getData.commande?.created_at)">
                        <label class="me-3 ms-2">Date de mise à jour :</label>
                        <input type="text" class="form-control w-25 me-5" readonly
                            :value="formatDate(getData.commande?.updated_at)">
                    </div>
                    <div class="mt-3 mb-3" v-for="service in getData?.services">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="m-0">{{ service.name }}</p>
                            <input type="text" class="quantity-input text-center form-control w-25" readonly
                                :value="service?.pivot.quantity">
                        </div>
                    </div>
                </div>
                <div class="footer pt-2 footer-ligne d-flex justify-content-end align-items-center mb-2">
                    <label class="me-4">Référence :</label>
                    <input type="text" class="form-control w-25 me-4" readonly :value="getData.commande?.reference">
                    <label class="me-4">Total :</label>
                    <input type="text" class="form-control w-25" readonly :value="getData.commande?.total">
                    <button type="button" class="btn btn-danger ms-4 me-2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.grey-line {
    border: solid 0.1px #6c757d;
}

.quantity-input {
    max-width: 100px;
    margin-right: 20%;
}

.footer-ligne {
    border-top: var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);
}

.modal-padding {
    padding: 0px;
}
</style>
