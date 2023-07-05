<script>
import moment from 'moment';

export default {
    name: 'CommandePutModal',
    props: {
        updateData: {
            type: Object,
            required: true,
            default: null
        },
    },
    methods: {
        formatDate(date) {
            console.log(this.updateData.date);
            return moment(date).format('DD/MM/YYYY');
        },
    }
}
</script>

<template>
    <div class="modal fade" id="put" tabindex="-1" aria-labelledby="putModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class=" ms-5 modal-padding modal-body">
                    <h2 class="mt-3 modal-title" id="putModalLabel">Commande</h2>
                    <div class="horizontal-line grey-line mb-4"></div>
                    <div class="mt-2 d-flex justify-content-start align-items-center">
                        <label class="me-3">Date de création :</label>
                        <input type="text" class="form-control w-25 me-4" readonly
                            :value="formatDate(updateData?.date)">
                    </div>
                </div>
                <div class="footer pt-2 footer-ligne d-flex justify-content-end align-items-center mb-2">
                    <button type="button" class="btn btn-danger ms-4 me-2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>
