<script>
export default {
    name: 'CommandeGetModal',
    props: {
        data: {
            type: Object,
            required: true,
            default: null
        },
    },
}
</script>

<template>
    <div class="modal fade" id="get" tabindex="-1" aria-labelledby="getModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="getModalLabel">Commande</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="footer d-flex justify-content-end align-items-center me-2 mb-2">
                    <label class="me-4">Référence :</label>
                    <input type="text" class="form-control w-25 me-4" readonly :value="data.commande?.reference">
                    <label class="me-4">Total :</label>
                    <input type="text" class="form-control w-25" readonly :value="data.commande?.total">
                    <button type="button" class="btn btn-secondary ms-4" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>
