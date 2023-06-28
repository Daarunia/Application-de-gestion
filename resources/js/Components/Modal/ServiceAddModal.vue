<script>
import { useForm } from '@inertiajs/vue3';

export default {
    name: 'ServiceAddModal',
    data() {
        return {
            form: {
                name: '',
                reference: '',
                price: '',
            },
        };
    },
    methods: {
        submit() {
            try {
                this.$inertia.post('/services', this.form);
            } catch (error) {
                console.error(error);
            }
        },
    },
}
</script>

<template>
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Nouveau service</h5>
                </div>
                <form id="add" @submit.prevent="submit">
                    <div class="modal-body">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" v-model="form.name">
                        <label for="reference" class="form-label mt-3">Référence</label>
                        <input type="text" class="form-control" id="reference" name="reference" placeholder="Référence"
                            v-model="form.reference">
                        <label for="price" class="form-label mt-3">Prix</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Prix"
                            v-model="form.price">
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
