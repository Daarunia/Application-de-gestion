<template>
    <div id="sidebar">
        <header class="d-flex align-items-center flex-column">
            <h3 class="mt-5 mb-4" href="#">Douane Express</h3>
            <div class="horizontal-line mb-4"></div>
        </header>
        <ul class="nav flex-column">
            <li class="mb-3">
                <inertia-link href="/services">Services</inertia-link>
            </li>
            <li class="mb-3">
                <inertia-link href="/commandes">Commandes</inertia-link>
            </li>
        </ul>
    </div>
</template>

<script>
import { InertiaLink  } from '@inertiajs/inertia-vue3';

export default {
    components: {
        InertiaLink,
    },
    name: 'SideBar',
    props: {
        name: String,
    },
};
</script>

<style>
#sidebar {
    z-index: 1000;
    display: flex;
    flex-direction: column;
    left: 250px;
    width: 250px;
    height: 100%;
    overflow-y: auto;
    background: #37474F;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#sidebar header {
    font-size: 20px;
    line-height: 52px;
    text-align: center;
}

#sidebar header h3 {
    color: #fff;
    display: block;
}

#sidebar .nav a {
    background: none;
    color: #CFD8DC;
    font-size: 14px;
    margin-left: 24px;
    text-decoration: none;
}

#sidebar .nav a:hover {
    background: none;
    color: #ECEFF1;
}

.horizontal-line {
    border-top: 1px solid white;
    width: 60%;

}
</style>
