<script>
import SideBar from '@/Components/SideBar.vue';
import moment from 'moment';

export default {
    name: 'Commande',
    components: {
        SideBar,
    },
    props: {
        commandes: {
            type: Array,
            default: () => [],
        },
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY HH:mm');
        },
    },
};
</script>

<template>
    <SideBar />
    <div class="mt-5 col-md-9 content">
        <div class="d-flex">
            <h1 class="ps-1">Commandes</h1>
            <button type="button" class="btn ms-4 btn-success align-items title-button" data-bs-toggle="modal"
                data-bs-target="#add">
                <i class="fas fa-add"></i>
            </button>
        </div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Total</th>
                    <th>Date de création</th>
                    <th>Date de mise à jour</th>
                    <th class="text-center">Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="commande in $page.props.commandes" :key="commande.id">
                    <td class="align-middle">{{ commande.reference }}</td>
                    <td class="align-middle">{{ commande.total }}</td>
                    <td class="align-middle">{{ formatDate(commande.created_at) }}</td>
                    <td class="align-middle">{{ formatDate(commande.updated_at) }}</td>
                    <td class="align-middle text-center">
                        <i :class="commande.status ? 'fas fa-lock text-danger' : 'fas fa-unlock text-success'"></i>
                    </td>
                    <td class="align-middle col-3">
                        <button type="button" class="btn btn-danger ms-4">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button v-if="!commande.status" type="button" class="btn ms-4 btn-primary">
                            <i class="fas fa-pencil"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style>
#app {
    display: flex;
    height: 100%;
}

.content{
    margin-left: 300px;
}

html, body {
    height: 100%;
    overflow-y: auto;
}
</style>
