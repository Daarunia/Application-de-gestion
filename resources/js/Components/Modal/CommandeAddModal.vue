<script>
export default {
    name: 'CommandeAddModal',
    props: {
        services: {
            type: Object,
            required: true,
            default: null
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
                <div class=" ms-5 modal-padding modal-body modal-add-min-height">

                </div>
                <div class="footer pt-2 footer-ligne d-flex justify-content-end align-items-center mb-2">
                    <select class="ms-3 form-select">
                        <option v-for="service in services">{{ service.name }}</option>
                    </select>
                    <button type="button" class="btn btn-success ms-4" data-bs-dismiss="modal">
                        <i class="fas fa-add"></i>
                    </button>
                    <button type="button" class="btn btn-danger ms-4 me-2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.modal-add-min-height{
    min-height: 50px;
}
</style>
