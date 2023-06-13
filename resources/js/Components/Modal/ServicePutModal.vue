<script>
import { useForm } from '@inertiajs/vue3';

export default {
    name: 'ServicePutModal',
    props: {
        serviceId: {
            type: Number,
            default: null
        },
        service: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: null,
        };
    },
    beforeMount() {
        this.form = useForm({
            name: this.service.name,
            reference: this.service.reference,
            price: this.service.price,
        });
    },
    methods: {
        submit() {
            try {
                this.$inertia.put(`/services/${this.serviceId}`, this.form);
            } catch (error) {
                console.error(error);
            }
        },
    },
}
</script>

<template>
    <div class="modal fade" :id="'put-' + this.serviceId" tabindex="-1" aria-labelledby="putModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="putModalLabel">Mise à jour du service</h5>
                </div>
                <form id="put" @submit.prevent="submit">
                    <div class="modal-body">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom"
                            v-model="this.form.name" :placeholder="service.name">
                        <label for="reference" class="form-label mt-3">Référence</label>
                        <input type="text" class="form-control" id="reference" name="reference" placeholder="Référence"
                            v-model="this.form.reference" :placeholder="service.reference">
                        <label for="price" class="form-label mt-3">Prix</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Prix"
                            v-model="this.form.price" :placeholder="service.price">
                    </div>
                    <div class="footer d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2 mb-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success me-2 mb-2" data-bs-dismiss="modal">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
